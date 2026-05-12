import { Row, Col, Card, Badge } from 'react-bootstrap';

export default function MisOfertas() {
    const misOfertas = [
        { id: 201, refaccion: 'Alternador', vehiculo: 'Nissan Versa 2015', precio: '$1,200 MXN', estado: 'pendiente', dias_entrega: 2 },
        { id: 202, refaccion: 'Amortiguadores', vehiculo: 'Ford Fiesta 2016', precio: '$2,500 MXN', estado: 'aceptada', dias_entrega: 1 },
        { id: 203, refaccion: 'Batería', vehiculo: 'VW Vento 2019', precio: '$1,800 MXN', estado: 'rechazada', dias_entrega: 0 },
    ];

    const getEstadoBadge = (estado: string) => {
        switch(estado) {
            case 'aceptada': return 'info'; // Success color mapped to info class
            case 'pendiente': return 'warning';
            case 'rechazada': return 'danger';
            default: return 'secondary';
        }
    };

    return (
        <div>
            <h3 className="mb-4">Mis Pujas Realizadas</h3>
            <Row className="g-4">
                {misOfertas.map(oferta => (
                    <Col xs={12} lg={4} key={oferta.id}>
                        <Card className="glass-panel text-white border-0 p-4 h-100">
                            <div className="d-flex justify-content-between align-items-center mb-3">
                                <h5 className="mb-0">{oferta.refaccion}</h5>
                                <Badge bg={getEstadoBadge(oferta.estado)} className="px-3 py-2 rounded-pill">
                                    {oferta.estado.toUpperCase()}
                                </Badge>
                            </div>
                            <p className="text-muted mb-4">{oferta.vehiculo}</p>
                            
                            <div className="bg-dark p-3 rounded mb-4" style={{ backgroundColor: 'rgba(0,0,0,0.3) !important' }}>
                                <div className="d-flex justify-content-between mb-2">
                                    <span className="text-muted">Cantidad Pujada:</span>
                                    <strong className="text-primary">{oferta.precio}</strong>
                                </div>
                                <div className="d-flex justify-content-between">
                                    <span className="text-muted">Entrega / Retiro:</span>
                                    <strong>{oferta.dias_entrega === 0 ? 'Mismo día' : `${oferta.dias_entrega} días`}</strong>
                                </div>
                            </div>
                            
                            <button className="btn btn-outline-custom w-100 mt-auto">Ver Subasta Original</button>
                        </Card>
                    </Col>
                ))}
            </Row>
        </div>
    );
}
