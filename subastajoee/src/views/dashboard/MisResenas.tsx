import { Row, Col, Card } from 'react-bootstrap';

export default function MisResenas() {
    const resenas = [
        { id: 1, autor: 'Juan Pérez', calificacion: 5, comentario: 'Excelente proveedor, la pieza llegó nueva y en el tiempo acordado.', fecha: '2026-05-05' },
        { id: 2, autor: 'Taller El Tuercas', calificacion: 4, comentario: 'Buena comunicación, la pieza era usada pero en buenas condiciones como se prometió.', fecha: '2026-04-20' }
    ];

    const renderStars = (rating: number) => {
        return Array.from({ length: 5 }).map((_, index) => (
            <i key={index} className={`fa-solid fa-star ${index < rating ? 'text-primary' : 'text-secondary'}`}></i>
        ));
    };

    return (
        <div>
            <div className="d-flex justify-content-between align-items-center mb-4">
                <h3 className="mb-0">Mis Reseñas</h3>
                <div className="text-end">
                    <h4 className="text-primary mb-0">4.5 <i className="fa-solid fa-star"></i></h4>
                    <small className="text-muted">Promedio General</small>
                </div>
            </div>
            
            <Row className="g-4">
                {resenas.map(resena => (
                    <Col xs={12} md={6} key={resena.id}>
                        <Card className="glass-panel text-white border-0 p-4 h-100">
                            <div className="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 className="mb-1">{resena.autor}</h5>
                                    <small className="text-muted">{resena.fecha}</small>
                                </div>
                                <div className="d-flex gap-1">
                                    {renderStars(resena.calificacion)}
                                </div>
                            </div>
                            <p className="mb-0" style={{ fontStyle: 'italic', color: 'var(--text-lessopacityxd)' }}>
                                "{resena.comentario}"
                            </p>
                        </Card>
                    </Col>
                ))}
            </Row>
        </div>
    );
}
