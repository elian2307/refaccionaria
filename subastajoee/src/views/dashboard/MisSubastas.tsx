import { Row, Col, Card, Badge } from 'react-bootstrap';

export default function MisSubastas() {
    const misSolicitudes = [
        { id: 101, refaccion: 'Bomba de Agua', vehiculo: 'Honda Civic 2018', fecha: '2026-05-10', estado: 'abierta', ofertas: 2 },
        { id: 102, refaccion: 'Balatas Delanteras', vehiculo: 'Toyota Corolla 2020', fecha: '2026-05-08', estado: 'cerrada', ofertas: 5 },
    ];

    return (
        <div>
            <h3 className="mb-4">Mis Subastas Publicadas</h3>
            <Row className="g-4">
                {misSolicitudes.map(sol => (
                    <Col xs={12} lg={6} key={sol.id}>
                        <Card className="glass-panel text-white border-0 p-4 h-100">
                            <div className="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 className="text-primary mb-1">{sol.refaccion}</h4>
                                    <p className="text-muted mb-0">{sol.vehiculo}</p>
                                </div>
                                <Badge bg={sol.estado === 'abierta' ? 'info' : 'secondary'} className="px-3 py-2 rounded-pill fs-6">
                                    {sol.estado.toUpperCase()}
                                </Badge>
                            </div>
                            <div className="d-flex justify-content-between mt-auto pt-3 border-top" style={{ borderColor: 'rgba(255,255,255,0.1) !important' }}>
                                <div>
                                    <small className="text-muted d-block">Publicada</small>
                                    <strong>{sol.fecha}</strong>
                                </div>
                                <div className="text-end">
                                    <small className="text-muted d-block">Pujas Recibidas</small>
                                    <strong className="text-primary fs-5">{sol.ofertas}</strong>
                                </div>
                            </div>
                            <button className="btn btn-outline-custom w-100 mt-4">Ver Detalles y Pujas</button>
                        </Card>
                    </Col>
                ))}
            </Row>
        </div>
    );
}
