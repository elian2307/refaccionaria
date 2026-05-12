import { Container, Row, Col } from 'react-bootstrap';
import { Link } from 'react-router-dom';

export default function Home() {
    return (
        <div className="home-view">
            {/* Hero Section */}
            <section className="hero-section py-5 my-5">
                <Container>
                    <Row className="align-items-center min-vh-50">
                        <Col lg={6} className="text-center text-lg-start mb-5 mb-lg-0">
                            <h1 className="display-4 fw-bold mb-4">
                                Compra y vende refacciones al <span style={{ color: 'var(--primary)' }}>Mejor Postor</span>
                            </h1>
                            <p className="lead text-muted mb-4">
                                Publica piezas de vehículos (motores, transmisiones, accesorios) y deja que otros usuarios pujen por ellas, o encuentra las piezas que necesitas al precio que tú decidas.
                            </p>
                            <div className="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start">
                                <Link to="/dashboard/subastas" className="btn btn-primary-custom btn-lg">
                                    Subastar una Refacción
                                </Link>
                                <Link to="/auctions" className="btn btn-outline-custom btn-lg">
                                    Ver Subastas Activas
                                </Link>
                            </div>
                        </Col>
                        <Col lg={6}>
                            <div className="glass-panel p-4 position-relative" style={{ height: '400px', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                                {/* Placeholder for a dynamic hero image or 3D element representing car parts */}
                                <div className="text-center">
                                    <h3 className="mb-3 text-white">Subastas Calientes</h3>
                                    <div className="d-flex align-items-center justify-content-center gap-2 mb-3">
                                        <span className="spinner-grow spinner-grow-sm text-danger" role="status" aria-hidden="true"></span>
                                        <span className="text-muted">Motor V8 Hemi - Dodge Charger 2018</span>
                                    </div>
                                    <div className="d-flex align-items-center justify-content-center gap-2">
                                        <span className="spinner-grow spinner-grow-sm text-warning" role="status" aria-hidden="true"></span>
                                        <span className="text-muted">Transmisión Automática - Honda Civic</span>
                                    </div>
                                </div>
                            </div>
                        </Col>
                    </Row>
                </Container>
            </section>
        </div>
    )
}