import { useEffect, useState } from 'react';
import { Alert, Badge, Card, Col, Container, ProgressBar, Row, Spinner } from 'react-bootstrap';
import { api } from '../../services/api';
import type { GamificacionData } from '../../interfaces/Gamificacion';

export default function NivelesJOEE() {
    const [gamificacion, setGamificacion] = useState<GamificacionData | null>(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState('');

    useEffect(() => {
        const fetchGamificacion = async () => {
            try {
                const token = localStorage.getItem('token');

                const response = await api.get('/gamificacion', {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                });

                if (response.data.success) {
                    setGamificacion(response.data.gamificacion);
                } else {
                    setError('No se pudieron cargar los Niveles JOEE.');
                }
            } catch (err: any) {
                const status = err.response?.status;
                const message = err.response?.data?.msg || err.response?.data?.message || '';

                if (status === 401 || message.toLowerCase().includes('token')) {
                    localStorage.removeItem('token');
                    localStorage.removeItem('user');
                    setError('Tu sesión expiró o el token ya no es válido. Vuelve a iniciar sesión.');
                } else {
                    setError('Error al cargar los Niveles JOEE.');
                }
            } finally {
                setLoading(false);
            }
        };

        fetchGamificacion();
    }, []);

    if (loading) {
        return (
            <div className="text-center py-5">
                <Spinner animation="border" variant="primary" />
                <p className="mt-3 text-white-50">Cargando progreso...</p>
            </div>
        );
    }

    if (error || !gamificacion) {
        return (
            <Alert variant="danger">
                {error || 'No se encontró información de Niveles JOEE.'}
            </Alert>
        );
    }

    return (
        <Container fluid className="gamification-view">
            <div className="gamification-heading mb-4">
                <div>
                    <p className="text-white-50 mb-1">Progreso del usuario</p>
                    <h2 className="fw-bold text-white mb-0">Niveles JOEE</h2>
                </div>

                <Badge bg="primary" className="px-3 py-2 rounded-pill">
                    Nivel {gamificacion.nivel}
                </Badge>
            </div>

            <Row className="g-4">
                <Col lg={8}>
                    <Card className="glass-panel text-white border-0 h-100">
                        <Card.Body className="p-4">
                            <div className="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
                                <div>
                                    <p className="text-white-50 mb-1">Nivel actual</p>
                                    <h2 className="fw-bold mb-0">{gamificacion.nombre_nivel}</h2>
                                </div>

                                <div className="text-md-end">
                                    <p className="text-white-50 mb-1">Puntos JOEE acumulados</p>
                                    <h2 className="fw-bold text-warning mb-0">{gamificacion.puntos}</h2>
                                </div>
                            </div>

                            <div className="gamification-badge-box mb-4">
                                <p className="text-white-50 mb-1">Insignia actual</p>
                                <h4 className="fw-bold mb-2">{gamificacion.insignia}</h4>
                                <p className="mb-0 text-white-50">{gamificacion.beneficio}</p>
                            </div>

                            <div>
                                <div className="d-flex justify-content-between mb-2">
                                    <span className="text-white-50">Progreso al siguiente nivel</span>
                                    <strong>{gamificacion.progreso}%</strong>
                                </div>

                                <ProgressBar now={gamificacion.progreso} className="gamification-progress" />

                                <p className="text-white-50 small mt-3 mb-0">
                                    {gamificacion.puntos_siguiente_nivel
                                        ? `Te faltan ${gamificacion.puntos_restantes} puntos JOEE para el siguiente nivel.`
                                        : 'Ya alcanzaste el nivel máximo disponible.'}
                                </p>
                            </div>
                        </Card.Body>
                    </Card>
                </Col>

                <Col lg={4}>
                    <Card className="glass-panel text-white border-0 h-100">
                        <Card.Body className="p-4">
                            <p className="text-white-50 mb-1">Beneficio activo</p>
                            <h4 className="fw-bold mb-3">Recompensa de nivel</h4>
                            <p className="text-white-50 mb-0">
                                {gamificacion.beneficio}
                            </p>
                        </Card.Body>
                    </Card>
                </Col>
            </Row>

            <Row className="g-4 mt-1">
                <Col>
                    <Card className="glass-panel text-white border-0">
                        <Card.Body className="p-4">
                            <h3 className="fw-bold mb-4">Logros</h3>

                            <Row className="g-3">
                                {gamificacion.logros.map((logro) => (
                                    <Col md={6} xl={4} key={logro.nombre}>
                                        <div className={`achievement-card ${logro.desbloqueado ? 'achievement-unlocked' : 'achievement-locked'}`}>
                                            <div className="d-flex justify-content-between align-items-start gap-3">
                                                <div>
                                                    <h5 className="fw-bold mb-2">{logro.nombre}</h5>
                                                    <p className="small mb-0">{logro.descripcion}</p>
                                                </div>

                                                <span className="achievement-status">
                                                    {logro.desbloqueado ? '✓' : '🔒'}
                                                </span>
                                            </div>
                                        </div>
                                    </Col>
                                ))}
                            </Row>
                        </Card.Body>
                    </Card>
                </Col>
            </Row>
        </Container>
    );
}