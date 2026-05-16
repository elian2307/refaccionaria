import { Container, Row, Col, Card, Badge } from 'react-bootstrap';
import { Link } from 'react-router-dom';

const categories = [
    'Motores',
    'Transmisiones',
    'Frenos',
    'Suspensión',
    'Carrocería',
    'Eléctrico',
];

const featuredAuctions = [
    {
        title: 'Motor V8 Hemi',
        vehicle: 'Dodge Charger 2018',
        urgency: 'Alta',
    },
    {
        title: 'Transmisión Automática',
        vehicle: 'Honda Civic',
        urgency: 'Media',
    },
    {
        title: 'Faros delanteros',
        vehicle: 'Nissan Sentra 2020',
        urgency: 'Baja',
    },
];

export default function Home() {
    return (
        <div className="home-view">
            <section className="hero-section py-5 my-5">
                <Container>
                    <Row className="align-items-center g-5">
                        <Col lg={6} className="text-center text-lg-start">
                            <Badge bg="primary" className="mb-3 px-3 py-2 rounded-pill">
                                Plataforma de subastas automotrices
                            </Badge>

                            <h1 className="display-4 fw-bold mb-4 text-white">
                                Compra y vende refacciones al{' '}
                                <span className="text-gradient-custom">Mejor Postor</span>
                            </h1>

                            <p className="lead text-white-50 mb-4">
                                Publica refacciones de vehículos y permite que otros usuarios pujen por ellas.
                                También puedes encontrar piezas disponibles y revisar sus detalles antes de hacer una oferta.
                            </p>

                            <div className="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start">
                                <Link to="/dashboard/subastas" className="btn btn-primary-custom btn-lg">
                                    Subastar una Refacción
                                </Link>

                                <Link to="/auctions" className="btn btn-home-secondary btn-lg">
                                    Ver Subastas Activas
                                </Link>
                            </div>
                        </Col>

                        <Col lg={6}>
                            <Card className="glass-panel border-0 text-white home-hero-card">
                                <Card.Body className="p-4 p-lg-5">
                                    <div className="d-flex justify-content-between align-items-center mb-4">
                                        <div>
                                            <p className="text-white-50 mb-1">Actividad reciente</p>
                                            <h3 className="fw-bold mb-0">Subastas destacadas</h3>
                                        </div>

                                        <Badge bg="danger" className="rounded-pill px-3 py-2">
                                            En vivo
                                        </Badge>
                                    </div>

                                    <div className="home-live-list">
                                        {featuredAuctions.map((auction) => (
                                            <div className="home-live-item" key={auction.title}>
                                                <div>
                                                    <h6 className="fw-bold mb-1">{auction.title}</h6>
                                                    <p className="small text-white-50 mb-0">{auction.vehicle}</p>
                                                </div>

                                                <span className="home-live-badge">
                                                    {auction.urgency}
                                                </span>
                                            </div>
                                        ))}
                                    </div>

                                    <div className="mt-4 pt-4 border-top border-secondary">
                                        <p className="text-white-50 small mb-3">
                                            Revisa las piezas disponibles, compara información y entra al detalle
                                            de cada subasta antes de pujar.
                                        </p>

                                        <Link to="/auctions" className="btn auction-action-btn auction-action-primary">
                                            Explorar subastas
                                        </Link>
                                    </div>
                                </Card.Body>
                            </Card>
                        </Col>
                    </Row>
                </Container>
            </section>

            <section className="py-5">
                <Container>
                    <div className="text-center mb-5">
                        <h2 className="fw-bold text-white mb-3">Categorías de refacciones</h2>
                        <p className="text-white-50 mb-0">
                            Encuentra piezas según el sistema o área del vehículo.
                        </p>
                    </div>

                    <Row className="g-4">
                        {categories.map((category) => (
                            <Col key={category} xs={6} md={4} lg={2}>
                                <Card className="glass-panel text-white border-0 h-100 home-category-card">
                                    <Card.Body className="text-center p-4">
                                        <div className="home-category-dot mx-auto mb-3" />
                                        <h6 className="fw-bold mb-0">{category}</h6>
                                    </Card.Body>
                                </Card>
                            </Col>
                        ))}
                    </Row>
                </Container>
            </section>

            <section className="py-5">
                <Container>
                    <Row className="g-4 align-items-stretch">
                        <Col lg={4}>
                            <Card className="glass-panel text-white border-0 h-100 home-info-card">
                                <Card.Body className="p-4">
                                    <span className="home-step-number">01</span>
                                    <h4 className="fw-bold mt-3 mb-3">Publica tu refacción</h4>
                                    <p className="text-white-50 mb-0">
                                        Agrega los datos principales de la pieza, vehículo compatible,
                                        descripción y fecha límite de la subasta.
                                    </p>
                                </Card.Body>
                            </Card>
                        </Col>

                        <Col lg={4}>
                            <Card className="glass-panel text-white border-0 h-100 home-info-card">
                                <Card.Body className="p-4">
                                    <span className="home-step-number">02</span>
                                    <h4 className="fw-bold mt-3 mb-3">Recibe pujas</h4>
                                    <p className="text-white-50 mb-0">
                                        Los usuarios pueden revisar la información de la refacción
                                        y realizar una oferta según su interés.
                                    </p>
                                </Card.Body>
                            </Card>
                        </Col>

                        <Col lg={4}>
                            <Card className="glass-panel text-white border-0 h-100 home-info-card">
                                <Card.Body className="p-4">
                                    <span className="home-step-number">03</span>
                                    <h4 className="fw-bold mt-3 mb-3">Elige la mejor opción</h4>
                                    <p className="text-white-50 mb-0">
                                        Compara las ofertas recibidas y avanza con la opción que más
                                        convenga para tu refacción.
                                    </p>
                                </Card.Body>
                            </Card>
                        </Col>
                    </Row>
                </Container>
            </section>

            <section className="py-5">
                <Container>
                    <Card className="glass-panel border-0 text-white home-cta-card">
                        <Card.Body className="p-4 p-lg-5 text-center">
                            <h2 className="fw-bold mb-3">Explora refacciones disponibles</h2>
                            <p className="text-white-50 mb-4">
                                Revisa el listado completo de subastas y entra al detalle de cada publicación
                                para conocer mejor la pieza antes de participar.
                            </p>

                            <Link to="/auctions" className="btn auction-action-btn auction-action-primary home-cta-button">
                                Ver subastas activas
                            </Link>
                        </Card.Body>
                    </Card>
                </Container>
            </section>
        </div>
    )
}