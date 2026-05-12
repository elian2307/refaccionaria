import { Outlet, Link, useLocation } from 'react-router-dom';
import { Navbar, Nav, Container } from 'react-bootstrap';

export default function Layout() {
  const location = useLocation();

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
              <Link to="/login" className="btn btn-primary-custom ms-lg-3 mt-3 mt-lg-0">
                Iniciar Sesión
              </Link>
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
    </>
  );
}
