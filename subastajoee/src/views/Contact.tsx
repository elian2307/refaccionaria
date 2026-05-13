import { Container, Row, Col, Form, Button } from 'react-bootstrap';

export default function Contact() {
    return (
        <Container className="py-5 my-5">
            <Row className="justify-content-center">
                <Col lg={8}>
                    <div className="text-center mb-5">
                        <h1 className="fw-bold text-white">Ponte en Contacto</h1>
                        <p className="text-white-50">¿Tienes alguna duda sobre cómo funciona la plataforma o quieres registrar tu refaccionaria? Envíanos un mensaje.</p>
                    </div>
                    
                    <div className="glass-panel p-4 p-md-5">
                        <Form>
                            <Row>
                                <Col md={6} className="mb-4">
                                    <Form.Group controlId="formFirstName">
                                        <Form.Label className="text-white-50 mb-2">Nombre</Form.Label>
                                        <Form.Control type="text" placeholder="Juan" className="form-control-custom text-white bg-dark" />
                                    </Form.Group>
                                </Col>
                                <Col md={6} className="mb-4">
                                    <Form.Group controlId="formLastName">
                                        <Form.Label className="text-white-50 mb-2">Apellido</Form.Label>
                                        <Form.Control type="text" placeholder="Pérez" className="form-control-custom text-white bg-dark" />
                                    </Form.Group>
                                </Col>
                            </Row>

                            <Form.Group className="mb-4" controlId="formEmail">
                                <Form.Label className="text-white-50 mb-2">Correo Electrónico</Form.Label>
                                <Form.Control type="email" placeholder="juan@ejemplo.com" className="form-control-custom text-white bg-dark" />
                            </Form.Group>

                            <Form.Group className="mb-5" controlId="formMessage">
                                <Form.Label className="text-white-50 mb-2">Mensaje</Form.Label>
                                <Form.Control as="textarea" rows={5} placeholder="¿En qué podemos ayudarte?" className="form-control-custom text-white bg-dark" />
                            </Form.Group>

                            <div className="d-grid">
                                <Button className="btn-primary-custom" size="lg" type="button">
                                    Enviar Mensaje
                                </Button>
                            </div>
                        </Form>
                    </div>
                </Col>
            </Row>
        </Container>
    );
}
