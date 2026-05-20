import { Container } from 'react-bootstrap';

export default function Footer() {
    return (
        <>
        <footer className="footer-custom text-center">
            <Container>
                <p className="mb-0">
                    &copy; {new Date().getFullYear()} Subastas JOEE
                </p>
            </Container>
        </footer>
        </>
    );
}