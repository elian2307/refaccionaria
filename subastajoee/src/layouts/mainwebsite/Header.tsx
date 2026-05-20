import { Link } from 'react-router-dom';
import { Navbar, Nav, Container, Button} from 'react-bootstrap';
import { useLocation } from 'react-router-dom';

interface HeaderProps {
  buttonFunction: () => void;
}

export default function Header({ buttonFunction }: HeaderProps) {
    const location = useLocation();

    return (
        <>
            <Navbar expand="lg" fixed="top" className="navbar-custom" variant="dark">
                <Container>
                    <Navbar.Brand as={Link} to="/" className='d-flex align-items-center makemebig'>
                    <img
                        src={`${import.meta.env.VITE_API_ASSETS}/joee/img/iso.png`}
                        className="d-inline-block align-top me-2 inlinelogo"
                        style={{ objectFit: 'contain' }}
                    />
                    Subastas JOEE
                    </Navbar.Brand>
                    <Navbar.Toggle aria-controls="basic-navbar-nav" />
                    <Navbar.Collapse id="basic-navbar-nav">
                        <Nav className="ms-auto align-items-center">
                            <Nav.Link as={Link} to="/" className={location.pathname === '/' ? 'active' : ''}>
                                Inicio
                            </Nav.Link>
                            <Nav.Link as={Link} to="/search" className={location.pathname === '/search' ? 'active' : ''}>
                                Buscar
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
                                <Button variant="primary" className="btn-primary-custom ms-lg-3 mt-3 mt-lg-0" onClick={buttonFunction}>
                                    Iniciar Sesión
                                </Button>
                            )}
                        </Nav>
                    </Navbar.Collapse>
                </Container>
            </Navbar>
        </>
    )

}


