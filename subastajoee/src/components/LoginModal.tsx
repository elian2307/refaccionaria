import { useState } from 'react';
import { Modal, Button, Form, Alert, Nav } from 'react-bootstrap';
import { api } from '../services/api';

interface LoginModalProps {
  show: boolean;
  onHide: () => void;
}

export default function LoginModal({ show, onHide }: LoginModalProps) {

  const [activeTab, setActiveTab] = useState<'login' | 'register'>('login');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [name, setName] = useState('');
  const [apellidos, setApellidos] = useState('');
  const [rol, setRol] = useState<'vendedor' | 'comprador'>('comprador');
  const [tipoUsuario, setTipoUsuario] = useState<'taller' | 'refaccionaria' | 'flotilla' | 'usuario'>('usuario');
  const [telefono, setTelefono] = useState('');
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');
  const [loading, setLoading] = useState(false);

  const handleClose = () => {
    onHide();
    setError('');
    setSuccess('');
    setEmail('');
    setPassword('');
    setConfirmPassword('');
    setName('');
    setApellidos('');
    setRol('comprador');
    setTipoUsuario('usuario');
    setTelefono('');
  };

  const handleLogin = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setError('');
    setSuccess('');

    try {
      const response = await api.post('/login', {
        email,
        password
      });

      if (response.data.success) {
        localStorage.setItem('token', response.data.token);
        localStorage.setItem('user', JSON.stringify(response.data.user));
        setSuccess('¡Sesión iniciada correctamente!');
        setTimeout(() => {
          handleClose();
        }, 1500);
      }
    } catch (err: any) {
      setError(err.response?.data?.msg || 'Error al iniciar sesión. Verifica tus credenciales.');
    } finally {
      setLoading(false);
    }
  };

  const handleRegister = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setError('');
    setSuccess('');

    // Validaciones básicas
    if (!name.trim() || !email.trim() || !password.trim() || !confirmPassword.trim() || !rol || !telefono.trim() || !tipoUsuario) {
      setError('Todos los campos son obligatorios.');
      setLoading(false);
      return;
    }

    if (password !== confirmPassword) {
      setError('Las contraseñas no coinciden.');
      setLoading(false);
      return;
    }

    if (password.length < 6) {
      setError('La contraseña debe tener al menos 6 caracteres.');
      setLoading(false);
      return;
    }

    if (!['vendedor', 'comprador'].includes(rol)) {
      setError('Tipo de usuario inválido.');
      setLoading(false);
      return;
    }

    if (!['taller', 'refaccionaria', 'flotilla', 'usuario'].includes(tipoUsuario)) {
      setError('Tipo de negocio inválido.');
      setLoading(false);
      return;
    }

    try {
      const response = await api.post('/register', {
        nombre: name,
        apellidos,
        email,
        password,
        password_confirmation: confirmPassword,
        rol,
        telefono,
        tipo_usuario: tipoUsuario,
      });

      if (response.data.success) {
        setSuccess('¡Cuenta creada correctamente! Inicia sesión con tus credenciales.');
        setTimeout(() => {
          setName('');
          setEmail('');
          setPassword('');
          setConfirmPassword('');
          setApellidos('');
          setTelefono('');
          setTipoUsuario('usuario');
          setActiveTab('login');
        }, 1500);
      }
    } catch (err: any) {
      setError(err.response?.data?.msg || 'Error al crear la cuenta. Por favor intenta de nuevo.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <Modal show={show} onHide={handleClose} centered contentClassName="bg-dark text-white border-0 shadow-lg" style={{ backgroundColor: 'rgba(0,0,0,0.5)' }}>
      <Modal.Header closeButton closeVariant="white" className="border-0 pb-0 px-4 pt-4">
        <Modal.Title className="fw-bold fs-3">
          {activeTab === 'login' ? 'Bienvenido de nuevo' : 'Crear cuenta'}
        </Modal.Title>
      </Modal.Header>
      <Modal.Body className="px-4 pb-4 pt-2">
        {/* Tabs para Login y Registro */}
        <Nav variant="pills" className="mb-4 d-flex gap-2">
          <Nav.Item className="flex-grow-1">
            <Nav.Link
              active={activeTab === 'login'}
              onClick={() => {
                setActiveTab('login');
                setError('');
                setSuccess('');
              }}
              className={`text-center py-2 ${activeTab === 'login' ? 'bg-primary' : 'bg-secondary'}`}
            >
              Iniciar sesión
            </Nav.Link>
          </Nav.Item>
          <Nav.Item className="flex-grow-1">
            <Nav.Link
              active={activeTab === 'register'}
              onClick={() => {
                setActiveTab('register');
                setError('');
                setSuccess('');
              }}
              className={`text-center py-2 ${activeTab === 'register' ? 'bg-primary' : 'bg-secondary'}`}
            >
              Registrarse
            </Nav.Link>
          </Nav.Item>
        </Nav>

        {/* Login Form */}
        {activeTab === 'login' && (
          <>
            <p className="text-white-50 mb-4">Ingresa con tu cuenta para acceder a Subastas JOEE.</p>
            {error && <Alert variant="danger" className="rounded-4 border-0">{error}</Alert>}
            {success && <Alert variant="success" className="rounded-4 border-0">{success}</Alert>}
            <Form onSubmit={handleLogin}>
              <Form.Group className="mb-4" controlId="formLoginEmail">
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

              <Form.Group className="mb-4" controlId="formLoginPassword">
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
          </>
        )}

        {/* Register Form */}
        {activeTab === 'register' && (
          <>
            <p className="text-white-50 mb-4">Crea una cuenta para acceder a Subastas JOEE.</p>
            {error && <Alert variant="danger" className="rounded-4 border-0">{error}</Alert>}
            {success && <Alert variant="success" className="rounded-4 border-0">{success}</Alert>}
            <Form onSubmit={handleRegister}>
              <Form.Group className="mb-4" controlId="formRegisterName">
                <Form.Label className="text-white-50 ms-2 mb-2 small fw-semibold text-uppercase tracking-wide">Nombre</Form.Label>
                <Form.Control
                  type="text"
                  placeholder="Tu nombre"
                  value={name}
                  onChange={(e) => setName(e.target.value)}
                  required
                  className="form-control-custom"
                />
              </Form.Group>

              <Form.Group className="mb-4" controlId="formRegisterApellidos">
                <Form.Label className="text-white-50 ms-2 mb-2 small fw-semibold text-uppercase tracking-wide">Apellidos</Form.Label>
                <Form.Control
                  type="text"
                  placeholder="Tus apellidos"
                  value={apellidos}
                  onChange={(e) => setApellidos(e.target.value)}
                  required
                  className="form-control-custom"
                />
              </Form.Group>

              <Form.Group className="mb-4" controlId="formRegisterEmail">
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

              <Form.Group className="mb-4" controlId="formRegisterRole">
                <Form.Label className="text-white-50 ms-2 mb-2 small fw-semibold text-uppercase tracking-wide">Tipo de usuario</Form.Label>
                <Form.Select
                  value={rol}
                  onChange={(e) => setRol(e.target.value as 'vendedor' | 'comprador')}
                  required
                  className="form-control-custom"
                >
                  <option value="comprador">Comprador</option>
                  <option value="vendedor">Vendedor</option>
                </Form.Select>
              </Form.Group>

              <Form.Group className="mb-4" controlId="formRegisterTipoUsuario">
                <Form.Label className="text-white-50 ms-2 mb-2 small fw-semibold text-uppercase tracking-wide">Tipo de negocio</Form.Label>
                <Form.Select
                  value={tipoUsuario}
                  onChange={(e) => setTipoUsuario(e.target.value as 'taller' | 'refaccionaria' | 'flotilla' | 'usuario')}
                  required
                  className="form-control-custom"
                >
                  <option value="usuario">Usuario</option>
                  <option value="taller">Taller</option>
                  <option value="refaccionaria">Refaccionaria</option>
                  <option value="flotilla">Flotilla</option>
                </Form.Select>
              </Form.Group>

              <Form.Group className="mb-4" controlId="formRegisterTelefono">
                <Form.Label className="text-white-50 ms-2 mb-2 small fw-semibold text-uppercase tracking-wide">Teléfono</Form.Label>
                <Form.Control
                  type="tel"
                  placeholder="### ### ####"
                  value={telefono}
                  onChange={(e) => setTelefono(e.target.value)}
                  required
                  className="form-control-custom"
                />
              </Form.Group>

              <Form.Group className="mb-4" controlId="formRegisterPassword">
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

              <Form.Group className="mb-4" controlId="formRegisterConfirmPassword">
                <Form.Label className="text-white-50 ms-2 mb-2 small fw-semibold text-uppercase tracking-wide">Confirmar Contraseña</Form.Label>
                <Form.Control
                  type="password"
                  placeholder="••••••••"
                  value={confirmPassword}
                  onChange={(e) => setConfirmPassword(e.target.value)}
                  required
                  className="form-control-custom"
                />
              </Form.Group>

              <Button variant="primary" type="submit" className="btn-primary-custom w-100 py-3 mt-2 fs-5" disabled={loading}>
                {loading ? (
                  <>
                    <span className="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    Creando cuenta...
                  </>
                ) : 'Crear cuenta'}
              </Button>
            </Form>
          </>
        )}
      </Modal.Body>
    </Modal>
  );
}