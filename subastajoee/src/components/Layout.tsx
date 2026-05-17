import { useState } from 'react';
import { Outlet, Link, useLocation, useNavigate } from 'react-router-dom';
import { Navbar, Nav, Container, Modal, Button, Form, Alert } from 'react-bootstrap';
import axios from 'axios';

export default function Layout() {
  const location = useLocation();
  const navigate = useNavigate();

  const [showLogin, setShowLogin] = useState(false);
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);

  const handleClose = () => {
    setShowLogin(false);
    setError('');
  };
  const handleShow = () => setShowLogin(true);

  const handleLogin = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setError('');

    try {
      const response = await axios.post('http://localhost:8000/api/login', {
        email,
        password
      });

      if (response.data.success) {
        localStorage.setItem('token', response.data.token);
        localStorage.setItem('user', JSON.stringify(response.data.user));
        handleClose();
        navigate('/dashboard');
      }
    } catch (err: any) {
      setError(err.response?.data?.msg || 'Error al iniciar sesión. Verifica tus credenciales.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <>
      <Navbar expand="lg" fixed="top" className="navbar-custom" variant="dark">
        <Container>
          <Navbar.Brand as={Link} to="/">Subastas JOEE</Navbar.Brand>
          <Navbar.Toggle aria-controls="basic-navbar-nav" />
          <Navbar.Collapse id="basic-navbar-nav">
            <Nav className="ms-auto align-items-center">
              <Nav.Link as={Link} to="/" className={location.pathname === '/' ? 'active' : ''}>
                Inicio
              </Nav.Link>
              <Nav.Link as={Link} to="/auctions" className={location.pathname === '/auctions' ? 'active' : ''}>
                Subastas
              </Nav.Link>
              <Nav.Link as={Link} to="/contact" className={location.pathname === '/contact' ? 'active' : ''}>
                Contacto
              </Nav.Link>

              {localStorage.getItem('token') ? (
                <Link to="/dashboard" className="btn btn-primary-custom ms-lg-3 mt-3 mt-lg-0">
                  Ir al Dashboard
                </Link>
              ) : (
                <Button variant="primary" className="btn-primary-custom ms-lg-3 mt-3 mt-lg-0" onClick={handleShow}>
                  Iniciar Sesión
                </Button>
              )}
            </Nav>
          </Navbar.Collapse>
        </Container>
      </Navbar>

      <main className="main-content">
        <Outlet />
      </main>

      <footer className="footer-custom text-center">
        <Container>
          <p className="mb-0 text-muted">
            &copy; {new Date().getFullYear()} Subastas JOEE. Todos los derechos reservados.
          </p>
        </Container>
      </footer>

      {/* Login Modal */}
      <Modal show={showLogin} onHide={handleClose} centered contentClassName="bg-dark text-white border-0 shadow-lg" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
        <Modal.Header closeButton closeVariant="white" className="border-0 pb-0 px-4 pt-4">
          <Modal.Title className="fw-bold fs-3">Bienvenido de nuevo</Modal.Title>
        </Modal.Header>
        <Modal.Body className="px-4 pb-4 pt-2">
          <p className="text-white-50 mb-4">Ingresa con tu cuenta para acceder a Subastas JOEE.</p>
          {error && <Alert variant="danger" className="rounded-4 border-0">{error}</Alert>}
          <Form onSubmit={handleLogin}>
            <Form.Group className="mb-4" controlId="formBasicEmail">
              <Form.Label className="text-white-50 ms-2 mb-2 small fw-semibold text-uppercase tracking-wide">Correo Electrónico</Form.Label>
              <Form.Control
                type="email"
                placeholder="tucorreo@ejemplo.com"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                required
                className="form-control-custom"
              />
            </Form.Group>

            <Form.Group className="mb-4" controlId="formBasicPassword">
              <Form.Label className="text-white-50 ms-2 mb-2 small fw-semibold text-uppercase tracking-wide">Contraseña</Form.Label>
              <Form.Control
                type="password"
                placeholder="••••••••"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                required
                className="form-control-custom"
              />
            </Form.Group>

            <Button variant="primary" type="submit" className="btn-primary-custom w-100 py-3 mt-2 fs-5" disabled={loading}>
              {loading ? (
                <>
                  <span className="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                  Iniciando sesión...
                </>
              ) : 'Entrar a mi cuenta'}
            </Button>
          </Form>
        </Modal.Body>
      </Modal>
    </>
  );
}
