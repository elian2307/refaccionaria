import { useEffect, useState } from 'react'
import { Link, useParams, useOutletContext } from 'react-router-dom'
import { Alert, Badge, Button, Card, Col, Container, Row, Spinner, Modal, Form, InputGroup } from 'react-bootstrap'
import axios from 'axios'

import type { Subasta } from '../interfaces/Subasta';

export default function AuctionDetail() {
  const { id } = useParams()
  const [subasta, setSubasta] = useState<Subasta | null>(null)
  const [loading, setLoading] = useState(true)
  const [error, setError] = useState<string | null>(null)
  
  // Bid Modal State
  const [showBidModal, setShowBidModal] = useState(false)
  const [bidLoading, setBidLoading] = useState(false)
  const [bidError, setBidError] = useState('')
  const [bidSuccess, setBidSuccess] = useState(false)
  const [bidData, setBidData] = useState({
    precio_ofertado: '',
    dias_entrega: '',
    condicion_pieza: 'Nueva',
    meses_garantia: ''
  })

  // Use context from Layout.tsx to open login modal
  const context = useOutletContext<{ handleShowLogin?: () => void }>()
  const handleShowLogin = context?.handleShowLogin

  useEffect(() => {
    const fetchSubasta = async () => {
      try {
        const response = await axios.get(`http://localhost:8000/api/subasta/${id}`)

        if (response.data.success) {
          setSubasta(response.data.subasta)
        } else {
          setError('No se pudo cargar la información de la subasta.')
        }
      } catch (err: any) {
        setError(err.response?.data?.msg || 'Error de conexión con el servidor.')
      } finally {
        setLoading(false)
      }
    }

    fetchSubasta()
  }, [id])

  const getUrgencyColor = (urgency?: string) => {
    switch (urgency) {
      case 'alta':
        return 'danger'
      case 'media':
        return 'warning'
      case 'baja':
        return 'info'
      default:
        return 'secondary'
    }
  }

  const getStatusColor = (status?: string) => {
    switch (status) {
      case 'abierta':
        return 'info'
      case 'cerrada':
        return 'secondary'
      case 'cancelada':
        return 'danger'
      case 'finalizada':
        return 'success'
      default:
        return 'secondary'
    }
  }

  const formatText = (value?: string) => {
    if (!value) return 'No especificado'
    return value.charAt(0).toUpperCase() + value.slice(1)
  }

  const formatDate = (value?: string) => {
    if (!value) return 'No especificada'

    const date = new Date(value)

    if (Number.isNaN(date.getTime())) {
      return value
    }

    return date.toLocaleDateString('es-MX', {
      day: '2-digit',
      month: 'long',
      year: 'numeric',
    })
  }

  const handleMakeOfferClick = () => {
    const token = localStorage.getItem('token')
    if (!token && handleShowLogin) {
      handleShowLogin()
      return
    }
    setShowBidModal(true)
  }

  const handleBidSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    setBidLoading(true)
    setBidError('')

    try {
      const token = localStorage.getItem('token')
      const userStr = localStorage.getItem('user')
      if (!userStr || !token) throw new Error('No estás autenticado')

      const user = JSON.parse(userStr)

      const payload = {
        subasta_id: id,
        proveedor_id: user.id,
        precio_ofertado: Number(bidData.precio_ofertado),
        dias_entrega: Number(bidData.dias_entrega),
        condicion_pieza: bidData.condicion_pieza,
        meses_garantia: bidData.meses_garantia ? Number(bidData.meses_garantia) : null,
        fecha_oferta: new Date().toISOString().split('T')[0],
      }

      const response = await axios.post('http://localhost:8000/api/oferta', payload, {
        headers: { Authorization: `Bearer ${token}` }
      })

      if (response.data.success) {
        setBidSuccess(true)
        setTimeout(() => {
          setShowBidModal(false)
          setBidSuccess(false)
          // Reset form
          setBidData({
            precio_ofertado: '',
            dias_entrega: '',
            condicion_pieza: 'Nueva',
            meses_garantia: ''
          })
        }, 2000)
      }
    } catch (err: any) {
      setBidError(err.response?.data?.msg || err.response?.data?.message || 'Error al enviar la oferta.')
    } finally {
      setBidLoading(false)
    }
  }

  if (loading) {
    return (
      <Container className="py-5 my-5 text-center">
        <Spinner animation="border" variant="primary" />
        <p className="mt-3 text-white-50">Cargando detalles de la refacción...</p>
      </Container>
    )
  }

  if (error || !subasta) {
    return (
      <Container className="py-5 my-5">
        <Alert variant="danger">{error || 'No se encontró la subasta solicitada.'}</Alert>
        <Link to="/auctions" className="btn btn-outline-custom">
          Volver a subastas
        </Link>
      </Container>
    )
  }

  return (
    <Container className="py-5 my-5 auction-detail-view">
      <div className="mb-4">
        <Link to="/auctions" className="text-white-50">
          ← Volver a subastas
        </Link>
      </div>

      <Row className="g-4 align-items-stretch">
        <Col lg={6}>
          <Card className="glass-panel h-100 border-0 overflow-hidden">
            <div className="auction-detail-visual d-flex align-items-center justify-content-center text-center p-5">
              <div>
                <span className="detail-visual-icon">🔧</span>
                <h2 className="fw-bold text-white mt-3 mb-2">{subasta.nombre_refaccion}</h2>
                <p className="text-white-50 mb-0">
                  {subasta.marca_vehiculo} {subasta.modelo_vehiculo} {subasta.anio_vehiculo}
                </p>
              </div>
            </div>
          </Card>
        </Col>

        <Col lg={6}>
          <Card className="glass-panel h-100 text-white border-0">
            <Card.Body className="p-4 p-lg-5">
              <div className="d-flex flex-wrap gap-2 mb-4">
                <Badge bg={getStatusColor(subasta.estado)} className="px-3 py-2 rounded-pill">
                  {formatText(subasta.estado)}
                </Badge>

                <Badge bg={getUrgencyColor(subasta.urgencia)} className="px-3 py-2 rounded-pill">
                  Urgencia {formatText(subasta.urgencia)}
                </Badge>
              </div>

              <h1 className="fw-bold mb-3">{subasta.nombre_refaccion}</h1>

              <p className="text-white-50 fs-5 mb-4">
                Solicitud para {subasta.marca_vehiculo} {subasta.modelo_vehiculo} {subasta.anio_vehiculo}
              </p>

              <div className="detail-info-list mb-4">
                <div className="detail-info-item">
                  <span>Marca</span>
                  <strong>{subasta.marca_vehiculo}</strong>
                </div>

                <div className="detail-info-item">
                  <span>Modelo</span>
                  <strong>{subasta.modelo_vehiculo}</strong>
                </div>

                <div className="detail-info-item">
                  <span>Año</span>
                  <strong>{subasta.anio_vehiculo}</strong>
                </div>

                <div className="detail-info-item">
                  <span>Fecha límite</span>
                  <strong>{formatDate(subasta.fecha_expiracion)}</strong>
                </div>
              </div>

              <Button onClick={handleMakeOfferClick} className="btn-primary-custom w-100 mb-3">
                Hacer oferta
              </Button>

              <p className="small text-white-50 text-center mb-0">
                Revisa la información antes de realizar una oferta.
              </p>
            </Card.Body>
          </Card>
        </Col>
      </Row>

      <Row className="g-4 mt-4">
        <Col lg={8}>
          <Card className="glass-panel text-white border-0 h-100">
            <Card.Body className="p-4">
              <h3 className="fw-bold mb-3">Descripción de la refacción</h3>
              <p className="text-white-50 mb-0 lh-lg">
                {subasta.descripcion_problema}
              </p>
            </Card.Body>
          </Card>
        </Col>

        <Col lg={4}>
          <Card className="glass-panel text-white border-0 h-100">
            <Card.Body className="p-4">
              <h3 className="fw-bold mb-3">Resumen</h3>

              <div className="d-flex justify-content-between border-bottom border-secondary py-2">
                <span className="text-white-50">Ofertas recibidas</span>
                <strong>{subasta.ofertas_count || 0}</strong>
              </div>

              <div className="d-flex justify-content-between border-bottom border-secondary py-2">
                <span className="text-white-50">Estado</span>
                <strong>{formatText(subasta.estado)}</strong>
              </div>

              <div className="d-flex justify-content-between py-2">
                <span className="text-white-50">Urgencia</span>
                <strong>{formatText(subasta.urgencia)}</strong>
              </div>
            </Card.Body>
          </Card>
        </Col>
      </Row>

      {/* Bid Modal */}
      <Modal show={showBidModal} onHide={() => !bidLoading && setShowBidModal(false)} centered contentClassName="bg-dark text-white border-0 shadow-lg" backdropClassName="modal-backdrop-custom">
        <Modal.Header closeButton closeVariant="white" className="border-0 pb-0 px-4 pt-4">
          <Modal.Title className="fw-bold fs-3">Hacer Oferta</Modal.Title>
        </Modal.Header>
        <Modal.Body className="px-4 pb-4 pt-2">
          <p className="text-white-50 mb-4">Ingresa los detalles de tu oferta para esta refacción.</p>

          {bidError && <Alert variant="danger" className="rounded-4 border-0">{bidError}</Alert>}
          {bidSuccess && <Alert variant="success" className="rounded-4 border-0">¡Oferta enviada con éxito!</Alert>}

          <Form onSubmit={handleBidSubmit}>
            <Row className="g-3 mb-3">
              <Col md={6}>
                <Form.Group>
                  <Form.Label className="text-white-50 ms-2 mb-2 small fw-semibold text-uppercase tracking-wide">Precio ($)</Form.Label>
                  <InputGroup>
                    <InputGroup.Text className="bg-dark text-white border-secondary">$</InputGroup.Text>
                    <Form.Control
                      type="number"
                      placeholder="0.00"
                      value={bidData.precio_ofertado}
                      onChange={(e) => setBidData({...bidData, precio_ofertado: e.target.value})}
                      required
                      min="1"
                      step="0.01"
                      className="form-control-custom rounded-end"
                    />
                  </InputGroup>
                </Form.Group>
              </Col>

              <Col md={6}>
                <Form.Group>
                  <Form.Label className="text-white-50 ms-2 mb-2 small fw-semibold text-uppercase tracking-wide">Días de entrega</Form.Label>
                  <Form.Control
                    type="number"
                    placeholder="Ej. 3"
                    value={bidData.dias_entrega}
                    onChange={(e) => setBidData({...bidData, dias_entrega: e.target.value})}
                    required
                    min="1"
                    className="form-control-custom"
                  />
                </Form.Group>
              </Col>
            </Row>

            <Row className="g-3 mb-4">
              <Col md={6}>
                <Form.Group>
                  <Form.Label className="text-white-50 ms-2 mb-2 small fw-semibold text-uppercase tracking-wide">Condición</Form.Label>
                  <Form.Select
                    value={bidData.condicion_pieza}
                    onChange={(e) => setBidData({...bidData, condicion_pieza: e.target.value})}
                    className="form-control-custom"
                    style={{ appearance: 'auto' }}
                  >
                    <option value="Nueva">Nueva</option>
                    <option value="Usada">Usada</option>
                    <option value="Reconstruida">Reconstruida</option>
                  </Form.Select>
                </Form.Group>
              </Col>

              <Col md={6}>
                <Form.Group>
                  <Form.Label className="text-white-50 ms-2 mb-2 small fw-semibold text-uppercase tracking-wide">Garantía (Meses)</Form.Label>
                  <Form.Control
                    type="number"
                    placeholder="Opcional"
                    value={bidData.meses_garantia}
                    onChange={(e) => setBidData({...bidData, meses_garantia: e.target.value})}
                    min="0"
                    className="form-control-custom"
                  />
                </Form.Group>
              </Col>
            </Row>

            <Button variant="primary" type="submit" className="btn-primary-custom w-100 py-3 mt-2 fs-5" disabled={bidLoading || bidSuccess}>
              {bidLoading ? (
                <>
                  <span className="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                  Enviando...
                </>
              ) : 'Enviar Oferta'}
            </Button>
          </Form>
        </Modal.Body>
      </Modal>

    </Container>
  )
}
