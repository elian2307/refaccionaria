import { useState, useEffect, useMemo } from 'react';
import { Container, Row, Col, Spinner, Alert, Form, Badge, Button, Card } from 'react-bootstrap';
import AnAuction from '../components/AnAuction';
import type { Subasta } from '../interfaces/Subasta';
import { api } from '../services/api';

export default function Search() {
    const [subastas, setSubastas] = useState<Subasta[]>([]);
    const [searchTerm, setSearchTerm] = useState('');
    const [urgencyFilter, setUrgencyFilter] = useState('');
    const [statusFilter, setStatusFilter] = useState('');
    const [brandFilter, setBrandFilter] = useState('');
    const [modelFilter, setModelFilter] = useState('');
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState<string | null>(null);

    useEffect(() => {
        const fetchSubastas = async () => {
            try {
                const token = localStorage.getItem('token');
                const config = token ? {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                } : {};

                const response = await api.get('/subasta', config);
                if (response.data.success) {
                    setSubastas(response.data.subastas);
                } else {
                    setError('Error al obtener las subastas.');
                }
            } catch (err: any) {
                console.error('Error fetching subastas:', err);
                setError(err.response?.data?.message || 'Error de conexión con el servidor.');
            } finally {
                setLoading(false);
            }
        };

        fetchSubastas();
    }, []);

    const urgencyOptions = useMemo(
        () => [...new Set(subastas.map((subasta) => subasta.urgencia).filter(Boolean))],
        [subastas]
    );

    const statusOptions = useMemo(
        () => [...new Set(subastas.map((subasta) => subasta.estado).filter(Boolean))],
        [subastas]
    );

    const filteredSubastas = useMemo(() => {
        const term = searchTerm.trim().toLowerCase();

        return subastas.filter((subasta) => {
            const fields = [
                subasta.nombre_refaccion,
                subasta.marca_vehiculo,
                subasta.modelo_vehiculo,
                subasta.descripcion_problema,
                subasta.estado,
            ];

            const matchesSearch =
                !term || fields.some((field) => field?.toString().toLowerCase().includes(term));
            const matchesUrgency = !urgencyFilter || subasta.urgencia?.toLowerCase() === urgencyFilter;
            const matchesStatus = !statusFilter || subasta.estado?.toLowerCase() === statusFilter;
            const matchesBrand = !brandFilter || subasta.marca_vehiculo?.toLowerCase() === brandFilter;
            const matchesModel = !modelFilter || subasta.modelo_vehiculo?.toLowerCase() === modelFilter;

            return matchesSearch && matchesUrgency && matchesStatus && matchesBrand && matchesModel;
        });
    }, [searchTerm, subastas, urgencyFilter, statusFilter, brandFilter, modelFilter]);

    const hasActiveFilters = !!(
        searchTerm || urgencyFilter || statusFilter || brandFilter || modelFilter
    );

    const handleClearFilters = () => {
        setSearchTerm('');
        setUrgencyFilter('');
        setStatusFilter('');
        setBrandFilter('');
        setModelFilter('');
    };

    return (
        <Container className="py-5 my-5">
            <div className="d-flex flex-column flex-md-row justify-content-between align-items-start gap-4 mb-5">
                <div>
                    <h1 className="fw-bold mb-2 text-white">Buscar Subastas</h1>
                    <p className="text-white-50 mb-3">Encuentra subastas por nombre de refacción, marca, modelo, urgencia y estado.</p>
                </div>

                <div className="w-100 w-md-auto search-panel">
                    <Form.Control
                        type="text"
                        value={searchTerm}
                        onChange={(event) => setSearchTerm(event.target.value)}
                        placeholder="Buscar subastas..."
                        className="form-control-custom search-input"
                    />
                </div>
            </div>

            <Card className="search-card glass-panel border-0 mb-4">
                <Card.Body className="p-4">
                    <div className="d-flex flex-column flex-lg-row justify-content-between align-items-start gap-3 mb-4">
                        <div>
                            <h5 className="fw-semibold text-white mb-1">Filtros avanzados</h5>
                            <p className="text-white-50 mb-0">Refina tu búsqueda con urgencia, estado, marca y modelo.</p>
                        </div>
                        <Badge bg="secondary" className="px-3 py-2 fs-7 align-self-start">
                            {filteredSubastas.length} resultados
                        </Badge>
                    </div>

                    <Row className="g-3 align-items-end">
                        <Col xs={12} md={6} lg={3}>
                            <Form.Group className="filter-group">
                                <Form.Label className="text-white-50 small mb-2">Urgencia</Form.Label>
                                <Form.Select
                                    value={urgencyFilter}
                                    onChange={(event) => setUrgencyFilter(event.target.value.toLowerCase())}
                                    className="form-control-custom"
                                >
                                    <option value="">Todas</option>
                                    {urgencyOptions.map((urgencia) => (
                                        <option key={urgencia} value={urgencia.toLowerCase()}>
                                            {urgencia.charAt(0).toUpperCase() + urgencia.slice(1)}
                                        </option>
                                    ))}
                                </Form.Select>
                            </Form.Group>
                        </Col>

                        <Col xs={12} md={6} lg={3}>
                            <Form.Group className="filter-group">
                                <Form.Label className="text-white-50 small mb-2">Estado</Form.Label>
                                <Form.Select
                                    value={statusFilter}
                                    onChange={(event) => setStatusFilter(event.target.value.toLowerCase())}
                                    className="form-control-custom"
                                >
                                    <option value="">Todos</option>
                                    {statusOptions.map((status) => (
                                        <option key={status} value={status.toLowerCase()}>
                                            {status.charAt(0).toUpperCase() + status.slice(1)}
                                        </option>
                                    ))}
                                </Form.Select>
                            </Form.Group>
                        </Col> 

                        <Col xs={12} lg={3}>
                            <Button className="w-100 reset-filters-btn btn auction-action-btn auction-action-secondary" onClick={handleClearFilters}>
                                Limpiar filtros
                            </Button>
                        </Col>
                    </Row>
                </Card.Body>
            </Card>

            <div className="d-flex flex-column flex-lg-row justify-content-between align-items-start gap-3 mb-4">
                <Badge bg="primary" className="p-2 px-3 rounded-pill fs-6">
                    {filteredSubastas.length} resultados
                </Badge>
                {hasActiveFilters && (
                    <p className="text-white-50 mb-0">
                        Aplicando filtros{searchTerm ? ' y búsqueda' : ''}.
                    </p>
                )}
            </div>

            {loading && (
                <div className="text-center py-5">
                    <Spinner animation="border" variant="primary" />
                    <p className="mt-3 text-white-50">Cargando subastas...</p>
                </div>
            )}

            {error && (
                <Alert variant="danger">{error}</Alert>
            )}

            {!loading && !error && filteredSubastas.length === 0 && (
                <div className="text-center py-5">
                    <p className="text-white-50 fs-5">No se encontraron subastas con esa búsqueda.</p>
                    <p className="text-white-50">Prueba con otra palabra clave o revisa las subastas activas.</p>
                </div>
            )}

            <Row className="g-4">
                {filteredSubastas.map((subasta) => (
                    <AnAuction
                        key={subasta.id}
                        name={subasta.nombre_refaccion}
                        brand={subasta.marca_vehiculo}
                        model={subasta.modelo_vehiculo}
                        anio={subasta.anio_vehiculo}
                        description={subasta.descripcion_problema}
                        slug={subasta.slug}
                        urgency={subasta.urgencia}
                        status={subasta.estado}
                        offersCount={subasta.ofertas_count}
                        expirationDate={subasta.fecha_expiracion}
                        img_subastas={subasta.img_subastas}
                    />
                ))}
            </Row>
        </Container>
    );
}
