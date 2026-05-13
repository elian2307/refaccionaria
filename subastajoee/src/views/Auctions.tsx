import { useState, useEffect } from 'react';
import { Container, Row, Col, Card, Badge, Spinner, Alert } from 'react-bootstrap';
import axios from 'axios';

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
                        <Card className="glass-panel h-100 text-white border-0">
                            <Card.Header className="bg-transparent border-bottom border-secondary pt-4 pb-3">
                                <div className="d-flex justify-content-between align-items-start">
                                    <h5 className="fw-bold text-primary mb-0">{req.nombre_refaccion}</h5>
                                    {/* 
                                    <Badge bg={getUrgencyColor(req.urgencia)}>
                                        Condición: {req.urgencia.charAt(0).toUpperCase() + req.urgencia.slice(1)}
                                    </Badge> 
                                    */}
                                </div>
                                <p className="text-white-50 small mt-2 mb-0">
                                    {req.marca_vehiculo} {req.modelo_vehiculo} {req.anio_vehiculo}
                                </p>
                            </Card.Header>
                            <Card.Body className="d-flex flex-column p-4">
                                <p className="mb-4 small">{req.descripcion_problema}</p>
                                
                                <div className="mt-auto d-flex justify-content-between align-items-end">
                                    <div>
                                        <p className="text-white-50 small mb-1">Pujas Recibidas</p>
                                        <h4 className="fw-bold mb-0">{req.ofertas_count || 0}</h4>
                                    </div>
                                    <div className="text-end">
                                        <p className="text-white-50 small mb-1">Termina en</p>
                                        <Badge bg="secondary" className="fs-6 fw-normal">{req.fecha_expiracion}</Badge>
                                    </div>
                                </div>
                                <hr className="my-3 border-secondary" />
                                <button className="btn btn-outline-custom w-100">Pujar / Hacer Oferta</button>
                            </Card.Body>
                        </Card>
                    </Col>
                ))}
            </Row>
        </Container>
    );
}
