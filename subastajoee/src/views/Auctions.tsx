import { Container, Row, Col, Card, Badge } from 'react-bootstrap';

export default function Auctions() {
    // Mock data based on the "subastas" table schema, but context is users selling parts
    const mockRequests = [
        { 
            id: 1, 
            marca_vehiculo: 'Nissan', 
            modelo_vehiculo: 'Versa', 
            anio_vehiculo: '2018', 
            nombre_refaccion: 'Alternador Original', 
            descripcion_problema: 'Se retiró por siniestro, el alternador funciona al 100%.',
            urgencia: 'baja', 
            estado: 'abierta',
            fecha_expiracion: '2026-05-15',
            ofertas_count: 3
        },
        { 
            id: 2, 
            marca_vehiculo: 'Honda', 
            modelo_vehiculo: 'Civic', 
            anio_vehiculo: '2015', 
            nombre_refaccion: 'Motor Completo 1.8L', 
            descripcion_problema: 'Motor recién ajustado, se vende por cambio de proyecto.',
            urgencia: 'media', 
            estado: 'abierta',
            fecha_expiracion: '2026-05-20',
            ofertas_count: 8
        },
        { 
            id: 3, 
            marca_vehiculo: 'Chevrolet', 
            modelo_vehiculo: 'Chevy', 
            anio_vehiculo: '2008', 
            nombre_refaccion: 'Transmisión Manual', 
            descripcion_problema: 'Transmisión de 5 velocidades, sin zumbidos.',
            urgencia: 'alta', 
            estado: 'abierta',
            fecha_expiracion: '2026-05-14',
            ofertas_count: 12
        },
        { 
            id: 4, 
            marca_vehiculo: 'Volkswagen', 
            modelo_vehiculo: 'Jetta', 
            anio_vehiculo: '2019', 
            nombre_refaccion: 'Faros LED (Par)', 
            descripcion_problema: 'Ligeros rayones de uso, micas no estrelladas.',
            urgencia: 'baja', 
            estado: 'abierta',
            fecha_expiracion: '2026-05-18',
            ofertas_count: 5
        },
    ];

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
                    <h1 className="fw-bold mb-2">Subastas de Refacciones</h1>
                    <p className="text-muted mb-0">Revisa las piezas publicadas y puja por ellas</p>
                </div>
                <div>
                    <Badge bg="primary" className="p-2 px-3 rounded-pill fs-6">
                        {mockRequests.length} Subastas Activas
                    </Badge>
                </div>
            </div>

            <Row className="g-4">
                {mockRequests.map((req) => (
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
                                <p className="text-muted small mt-2 mb-0">
                                    {req.marca_vehiculo} {req.modelo_vehiculo} {req.anio_vehiculo}
                                </p>
                            </Card.Header>
                            <Card.Body className="d-flex flex-column p-4">
                                <p className="mb-4 small">{req.descripcion_problema}</p>
                                
                                <div className="mt-auto d-flex justify-content-between align-items-end">
                                    <div>
                                        <p className="text-muted small mb-1">Pujas Recibidas</p>
                                        <h4 className="fw-bold mb-0">{req.ofertas_count}</h4>
                                    </div>
                                    <div className="text-end">
                                        <p className="text-muted small mb-1">Termina en</p>
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
