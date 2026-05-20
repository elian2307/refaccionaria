import { useEffect, useState, type FormEvent } from 'react'
import { Link, useParams, useOutletContext } from 'react-router-dom'
import { Alert, Badge, Button, Card, Col, Container, Form, Modal, Row, Spinner } from 'react-bootstrap'
import { api, apiAuth } from '../services/api'
import { getToken, getUser } from '../services/auth'
import type { Subasta } from '../interfaces/Subasta'

interface PujaForm {
  precio_ofertado: string
}

const pujaInicial: PujaForm = {
  precio_ofertado: '',
}

export default function AuctionDetail() {
  const { slug } = useParams()

  const [subasta, setSubasta] = useState<Subasta | null>(null)
  const [loading, setLoading] = useState(true)
  const [savingOffer, setSavingOffer] = useState(false)

  const [showOfferModal, setShowOfferModal] = useState(false)

  const [offerError, setOfferError] = useState<string | null>(null)
  const [offerSuccess, setOfferSuccess] = useState<string | null>(null)
  const [error, setError] = useState<string | null>(null)

  const [pujaForm, setPujaForm] = useState<PujaForm>(pujaInicial)

  const context = useOutletContext<{ handleShowLogin?: () => void }>()
  const handleShowLogin = context?.handleShowLogin

  useEffect(() => {
    const fetchSubasta = async () => {
      try {
        const response = await api.get(`/subasta/${slug}`)

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
  }, [slug])

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
    setOfferError(null)
    setOfferSuccess(null)

    if (!getToken()) {
      if (handleShowLogin) {
        handleShowLogin()
      }

      return
    }

    const user = getUser()

    if (user?.rol !== 'comprador' && user?.rol !== 'admin') {
      setOfferError('Solo los compradores pueden hacer pujas.')
      return
    }

    if (subasta?.estado !== 'abierta') {
      setOfferError('Esta subasta no está abierta, por eso no se puede hacer una puja.')
      return
    }

    setShowOfferModal(true)
  }

  const handleOfferChange = (field: keyof PujaForm, value: string) => {
    setPujaForm((current) => ({
      ...current,
      [field]: value,
    }))
  }

  const handleSubmitOffer = async (e: FormEvent<HTMLFormElement>) => {
    e.preventDefault()

    if (!subasta) return

    setSavingOffer(true)
    setOfferError(null)
    setOfferSuccess(null)

    try {
      await apiAuth.post('/oferta', {
      subasta_id: subasta.id,
      precio_ofertado: Number(pujaForm.precio_ofertado),
      })

      setOfferSuccess('Tu puja se registró correctamente.')
      setPujaForm(pujaInicial)
      setShowOfferModal(false)

      setSubasta((current) =>
        current
          ? {
              ...current,
              ofertas_count: (current.ofertas_count || 0) + 1,
            }
          : current
      )
    } catch (err: any) {
      setOfferError(err.response?.data?.msg || 'No se pudo registrar la puja.')
    } finally {
      setSavingOffer(false)
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

      {offerError && <Alert variant="danger">{offerError}</Alert>}
      {offerSuccess && <Alert variant="success">{offerSuccess}</Alert>}

      <Row className="g-4 align-items-stretch">
        <Col lg={6}>
          {subasta.img_subastas && subasta.img_subastas.length > 0 ? (
            <img
              src={subasta.img_subastas[0].url}
              alt={subasta.nombre_refaccion}
              className="img-fluid rounded mb-3 auction-card-img"
              style={{ height: '100%', width: '100%', objectFit: 'cover' }}
            />
          ) : (
            <div
              className="d-flex align-items-center justify-content-center bg-dark rounded mb-3 text-white-50 border border-secondary"
              style={{ height: '180px', width: '100%' }}
            >
              <span className="small">Sin imagen disponible</span>
            </div>
          )}
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
                Hacer puja
              </Button>

              <p className="small text-white-50 text-center mb-0">
                Revisa la información antes de realizar una puja.
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
              <p className="text-white-50 mb-0 lh-lg">{subasta.descripcion_problema}</p>
            </Card.Body>
          </Card>
        </Col>

        <Col lg={4}>
          <Card className="glass-panel text-white border-0 h-100">
            <Card.Body className="p-4">
              <h3 className="fw-bold mb-3">Resumen</h3>

              <div className="d-flex justify-content-between border-bottom border-secondary py-2">
                <span className="text-white-50">Pujas recibidas</span>
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

      <Modal
        show={showOfferModal}
        onHide={() => setShowOfferModal(false)}
        centered
        contentClassName="bg-dark text-white border-0 shadow-lg"
      >
        <Modal.Header closeButton closeVariant="white" className="border-0 pb-0 px-4 pt-4">
          <Modal.Title className="fw-bold fs-3">Hacer puja</Modal.Title>
        </Modal.Header>

        <Modal.Body className="px-4 pb-4 pt-2">
          <p className="text-white-50 mb-4">
            Ingresa los datos de tu puja para {subasta.nombre_refaccion}.
          </p>

          <Form onSubmit={handleSubmitOffer}>
            <Form.Group className="mb-3">
              <Form.Label>Precio ofertado</Form.Label>
              <Form.Control
                type="number"
                min="1"
                step="0.01"
                value={pujaForm.precio_ofertado}
                onChange={(e) => handleOfferChange('precio_ofertado', e.target.value)}
                required
                className="form-control-custom"
              />
            </Form.Group>
            
            <Button type="submit" className="btn-primary-custom w-100 py-3" disabled={savingOffer}>
              {savingOffer ? 'Guardando puja...' : 'Enviar puja'}
            </Button>
          </Form>
        </Modal.Body>
      </Modal>
    </Container>
  )
}