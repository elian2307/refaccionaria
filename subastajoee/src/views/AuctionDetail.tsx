import { useEffect, useState } from 'react'
import { Link, useParams, useOutletContext } from 'react-router-dom'
import { Alert, Badge, Button, Card, Col, Container, Row, Spinner } from 'react-bootstrap'
import axios from 'axios'

import type { Subasta } from '../interfaces/Subasta';

export default function AuctionDetail() {
  const { id } = useParams()
  const [subasta, setSubasta] = useState<Subasta | null>(null)
  const [loading, setLoading] = useState(true)
  const [error, setError] = useState<string | null>(null)
  
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
    // Aquí iría la lógica para abrir el modal o formulario de oferta
    console.log("Abrir formulario de oferta...")
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
    </Container>
  )
}