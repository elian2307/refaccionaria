import { Row, Col, Card, Badge } from 'react-bootstrap';

export default function MisPedidos() {
    const pedidos = [
        { id: 'ORD-001', refaccion: 'Amortiguadores', proveedor: 'Refaccionaria El Pistón', total: '$2,500 MXN', fecha: '2026-05-11', estado: 'en_camino' },
        { id: 'ORD-002', refaccion: 'Filtro de Aceite', proveedor: 'AutoParts Express', total: '$350 MXN', fecha: '2026-05-01', estado: 'entregado' }
    ];

    const getEstadoBadge = (estado: string) => {
        switch(estado) {
            case 'entregado': return 'info'; // Success color
            case 'en_camino': return 'warning'; // Pending color
            case 'cancelado': return 'danger';
            default: return 'secondary';
        }
    };

    const formatEstado = (estado: string) => estado.replace('_', ' ').toUpperCase();

    return (
        <div>
            <h3 className="mb-4">Mis Órdenes</h3>
            <Row className="g-4">
                {pedidos.map(pedido => (
                    <Col xs={12} key={pedido.id}>
                        <Card className="glass-panel text-white border-0 p-4">
                            <Row className="align-items-center">
                                <Col md={3}>
                                    <small className="text-muted d-block">ID Órden</small>
                                    <strong className="text-primary">{pedido.id}</strong>
                                </Col>
                                <Col md={3}>
                                    <small className="text-muted d-block">Artículo</small>
                                    <strong>{pedido.refaccion}</strong>
                                </Col>
                                <Col md={3}>
                                    <small className="text-muted d-block">Proveedor</small>
                                    <strong>{pedido.proveedor}</strong>
                                </Col>
                                <Col md={3} className="text-md-end mt-3 mt-md-0">
                                    <Badge bg={getEstadoBadge(pedido.estado)} className="px-3 py-2 rounded-pill mb-2">
                                        {formatEstado(pedido.estado)}
                                    </Badge>
                                    <h5 className="mb-0">{pedido.total}</h5>
                                </Col>
                            </Row>
                        </Card>
                    </Col>
                ))}
            </Row>
        </div>
    );
}
