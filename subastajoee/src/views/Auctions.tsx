import { useState, useEffect } from 'react';
import { Container, Row, Col, Card, Badge, Spinner, Alert } from 'react-bootstrap';
import axios from 'axios';
import { Link } from 'react-router-dom';

interface Subasta {
    id: number;
    marca_vehiculo: string;
    modelo_vehiculo: string;
    anio_vehiculo: string | number;
    nombre_refaccion: string;
    descripcion_problema: string;
    urgencia: string;
    estado: string;
    fecha_expiracion: string;
    ofertas_count?: number;
}

export default function Auctions() {
    const [subastas, setSubastas] = useState<Subasta[]>([]);
    const [loading, setLoading] = useState<boolean>(true);
    const [error, setError] = useState<string | null>(null);

    useEffect(() => {
        const fetchSubastas = async () => {
            try {
                const token = localStorage.getItem('token');
                const config = token ? {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                } : {};

                const response = await axios.get('http://localhost:8000/api/subasta', config);

                if (response.data.success) {
                    setSubastas(response.data.subastas);
                } else {
                    setError('Error al obtener las subastas.');
                }
            } catch (err: any) {
                console.error('Error fetching subastas:', err);
                setError(err.response?.data?.message || 'Error de conexión con el servidor.');
            } finally {
                setLoading(false);
            }
        };

        fetchSubastas();
    }, []);

    const getUrgencyColor = (urgency: string) => {
        switch (urgency) {
            case 'alta': return 'danger';
            case 'media': return 'warning';
            case 'baja': return 'info';
            default: return 'secondary';
        }
    };
    const getStatusColor = (status: string) => {
        switch (status) {
            case 'abierta': return 'success';
            case 'cerrada': return 'secondary';
            case 'cancelada': return 'danger';
            case 'finalizada': return 'primary';
            default: return 'secondary';
        }
    };

    const formatText = (value: string) => {
        if (!value) return 'No especificado';
        return value.charAt(0).toUpperCase() + value.slice(1);
    };

    const formatDate = (value: string) => {
        if (!value) return 'No especificada';

        const date = new Date(value);

        if (Number.isNaN(date.getTime())) {
            return value;
        }

        return date.toLocaleDateString('es-MX', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
        });
    };

    const shortDescription = (value: string) => {
        if (!value) return 'Sin descripción disponible.';
        return value.length > 115 ? `${value.slice(0, 115)}...` : value;
    };

    return (
        <Container className="py-5 my-5">
            <div className="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h1 className="fw-bold mb-2 text-white">Subastas de Refacciones</h1>
                    <p className="text-white-50 mb-0">Revisa las piezas publicadas y puja por ellas</p>
                </div>
                <div>
                    <Badge bg="primary" className="p-2 px-3 rounded-pill fs-6">
                        {subastas.length} Subastas Activas
                    </Badge>
                </div>
            </div>

            {loading && (
                <div className="text-center py-5">
                    <Spinner animation="border" variant="primary" />
                    <p className="mt-3 text-white-50">Cargando subastas...</p>
                </div>
            )}

            {error && (
                <Alert variant="danger">
                    {error}
                </Alert>
            )}

            {!loading && !error && subastas.length === 0 && (
                <div className="text-center py-5">
                    <p className="text-white-50 fs-5">No hay subastas activas en este momento.</p>
                </div>
            )}

            <Row className="g-4">
                {subastas.map((req) => (
                    <Col key={req.id} xs={12} md={6} lg={4}>
                        <Card className="glass-panel h-100 text-white border-0 auction-card">
                            <Card.Header className="bg-transparent border-bottom border-secondary pt-4 pb-3">
                                <div className="d-flex justify-content-between align-items-start gap-3">
                                    <div>
                                        <h5 className="fw-bold text-primary mb-2">
                                            {req.nombre_refaccion}
                                        </h5>

                                        <p className="text-white-50 small mb-0">
                                            {req.marca_vehiculo} {req.modelo_vehiculo} {req.anio_vehiculo}
                                        </p>
                                    </div>

                                    <Badge bg={getUrgencyColor(req.urgencia)} className="rounded-pill px-3 py-2">
                                        {formatText(req.urgencia)}
                                    </Badge>
                                </div>
                            </Card.Header>

                            <Card.Body className="d-flex flex-column p-4">
                                <div className="mb-3">
                                    <Badge bg={getStatusColor(req.estado)} className="rounded-pill px-3 py-2">
                                        Estado: {formatText(req.estado)}
                                    </Badge>
                                </div>

                                <p className="mb-4 small text-white-50 auction-card-description">
                                    {shortDescription(req.descripcion_problema)}
                                </p>

                                <div className="auction-card-info mt-auto">
                                    <div className="auction-card-info-item">
                                        <span>Pujas recibidas</span>
                                        <strong>{req.ofertas_count || 0}</strong>
                                    </div>

                                    <div className="auction-card-info-item">
                                        <span>Fecha límite</span>
                                        <strong>{formatDate(req.fecha_expiracion)}</strong>
                                    </div>
                                </div>

                                <hr className="my-3 border-secondary" />

                                <div className="auction-actions">
                                    <Link to={`/auctions/${req.id}`} className="btn auction-action-btn auction-action-secondary">
                                        Ver detalles
                                    </Link>

                                    <button className="btn auction-action-btn auction-action-primary">
                                        Pujar / Hacer Oferta
                                    </button>
                                </div>
                            </Card.Body>
                        </Card>
                    </Col>
                ))}
            </Row>
        </Container>
    );
}
