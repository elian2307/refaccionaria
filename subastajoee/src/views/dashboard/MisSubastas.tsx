import { useEffect, useState, type FormEvent } from 'react';
import { Alert, Badge, Button, Card, Col, Form, Modal, Row, Spinner, Table } from 'react-bootstrap';
import { Link } from 'react-router-dom';
import { apiAuth } from '../../services/api';

interface Comprador {
    id: number;
    nombre?: string;
    apellidos?: string;
    email?: string;
    rol?: string;
}

interface Oferta {
    id: number;
    subasta_id: number;
    proveedor_id: number;
    precio_ofertado: number | string;
    dias_entrega?: number;
    condicion_pieza?: string;
    meses_garantia?: number;
    es_aceptada?: boolean;
    fecha_oferta?: string;
    created_at?: string;
    proveedor?: Comprador;
}

interface Subasta {
    id: number;
    slug: string;
    user_id: number;
    marca_vehiculo: string;
    modelo_vehiculo: string;
    anio_vehiculo: number;
    nombre_refaccion: string;
    descripcion_problema: string;
    urgencia: string;
    estado: string;
    fecha_expiracion: string;
    created_at: string;
    ofertas_count?: number;
}
interface NuevaSubastaForm {
    marca_vehiculo: string;
    modelo_vehiculo: string;
    anio_vehiculo: string;
    nombre_refaccion: string;
    descripcion_problema: string;
    urgencia: string;
    fecha_expiracion: string;
}

const nuevaSubastaInicial: NuevaSubastaForm = {
    marca_vehiculo: '',
    modelo_vehiculo: '',
    anio_vehiculo: '',
    nombre_refaccion: '',
    descripcion_problema: '',
    urgencia: 'media',
    fecha_expiracion: '',
};
interface EditarSubastaForm {
    marca_vehiculo: string;
    modelo_vehiculo: string;
    anio_vehiculo: string;
    nombre_refaccion: string;
    descripcion_problema: string;
    urgencia: string;
    estado: string;
    fecha_expiracion: string;
}

const editarSubastaInicial: EditarSubastaForm = {
    marca_vehiculo: '',
    modelo_vehiculo: '',
    anio_vehiculo: '',
    nombre_refaccion: '',
    descripcion_problema: '',
    urgencia: 'media',
    estado: 'abierta',
    fecha_expiracion: '',
};

export default function MisSubastas() {
    const [misSubastas, setMisSubastas] = useState<Subasta[]>([]);
    const [ofertas, setOfertas] = useState<Oferta[]>([]);
    const [subastaSeleccionada, setSubastaSeleccionada] = useState<Subasta | null>(null);

    const [loading, setLoading] = useState(true);
    const [loadingOfertas, setLoadingOfertas] = useState(false);
    const [guardandoSubasta, setGuardandoSubasta] = useState(false);

    const [editandoSubasta, setEditandoSubasta] = useState(false);

    const [aceptandoOfertaId, setAceptandoOfertaId] = useState<number | null>(null);

    const [error, setError] = useState<string | null>(null);
    const [errorOfertas, setErrorOfertas] = useState<string | null>(null);
    const [errorCrear, setErrorCrear] = useState<string | null>(null);
    const [successCrear, setSuccessCrear] = useState<string | null>(null);

    const [errorEditar, setErrorEditar] = useState<string | null>(null);
    const [successEditar, setSuccessEditar] = useState<string | null>(null);

    const [showModal, setShowModal] = useState(false);
    const [showCrearModal, setShowCrearModal] = useState(false);

    const [showEditarModal, setShowEditarModal] = useState(false);

    const [nuevaSubasta, setNuevaSubasta] = useState<NuevaSubastaForm>(nuevaSubastaInicial);

    const [subastaEditando, setSubastaEditando] = useState<Subasta | null>(null);
    const [editarSubasta, setEditarSubasta] = useState<EditarSubastaForm>(editarSubastaInicial);

    const cargarSubastas = async () => {
        try {
            setLoading(true);
            setError(null);

            const response = await apiAuth.get('/mis-subastas');

            if (response.data.success) {
                setMisSubastas(response.data.subastas || []);
            } else {
                setError('No se pudieron cargar tus subastas.');
            }
        } catch (err: any) {
            setError(err.response?.data?.msg || 'No se pudieron cargar tus subastas.');
        } finally {
            setLoading(false);
        }
    };

    const cargarOfertas = async (subasta: Subasta) => {
        try {
            setSubastaSeleccionada(subasta);
            setShowModal(true);
            setLoadingOfertas(true);
            setErrorOfertas(null);
            setOfertas([]);

            const response = await apiAuth.get(`/subasta/${subasta.id}/ofertas`);

            if (response.data.success) {
                setOfertas(response.data.ofertas || []);
            } else {
                setErrorOfertas('No se pudieron cargar las pujas de esta subasta.');
            }
        } catch (err: any) {
            setErrorOfertas(err.response?.data?.msg || 'No se pudieron cargar las pujas de esta subasta.');
        } finally {
            setLoadingOfertas(false);
        }
    };

    useEffect(() => {
        cargarSubastas();
    }, []);

    const abrirModalCrear = () => {
        setNuevaSubasta(nuevaSubastaInicial);
        setErrorCrear(null);
        setSuccessCrear(null);
        setShowCrearModal(true);
    };

    const handleNuevaSubastaChange = (field: keyof NuevaSubastaForm, value: string) => {
        setNuevaSubasta((current) => ({
            ...current,
            [field]: value,
        }));
    };
    const formatearFechaInput = (value?: string) => {
        if (!value) return '';

        return value.slice(0, 10);
    };

    const abrirModalEditar = (subasta: Subasta) => {
        setSubastaEditando(subasta);
        setEditarSubasta({
            marca_vehiculo: subasta.marca_vehiculo || '',
            modelo_vehiculo: subasta.modelo_vehiculo || '',
            anio_vehiculo: String(subasta.anio_vehiculo || ''),
            nombre_refaccion: subasta.nombre_refaccion || '',
            descripcion_problema: subasta.descripcion_problema || '',
            urgencia: subasta.urgencia || 'media',
            estado: subasta.estado || 'abierta',
            fecha_expiracion: formatearFechaInput(subasta.fecha_expiracion),
        });
        setErrorEditar(null);
        setSuccessEditar(null);
        setShowEditarModal(true);
    };

    const handleEditarSubastaChange = (field: keyof EditarSubastaForm, value: string) => {
        setEditarSubasta((current) => ({
            ...current,
            [field]: value,
        }));
    };

    const actualizarSubasta = async (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        if (!subastaEditando) return;

        try {
            setEditandoSubasta(true);
            setErrorEditar(null);
            setSuccessEditar(null);

            await apiAuth.put(`/subasta/${subastaEditando.id}`, {
                marca_vehiculo: editarSubasta.marca_vehiculo,
                modelo_vehiculo: editarSubasta.modelo_vehiculo,
                anio_vehiculo: Number(editarSubasta.anio_vehiculo),
                nombre_refaccion: editarSubasta.nombre_refaccion,
                descripcion_problema: editarSubasta.descripcion_problema,
                urgencia: editarSubasta.urgencia,
                estado: editarSubasta.estado,
                fecha_expiracion: editarSubasta.fecha_expiracion,
            });

            setSuccessEditar('Subasta actualizada correctamente.');
            setShowEditarModal(false);
            setSubastaEditando(null);
            setEditarSubasta(editarSubastaInicial);
            cargarSubastas();
        } catch (err: any) {
            const data = err.response?.data;

            if (data?.msg) {
                setErrorEditar(data.msg);
            } else if (data?.message) {
                setErrorEditar(data.message);
            } else if (data?.errors) {
                const firstError = Object.values(data.errors)[0] as string[];
                setErrorEditar(firstError?.[0] || 'No se pudo actualizar la subasta.');
            } else {
                setErrorEditar('No se pudo actualizar la subasta.');
            }
        } finally {
            setEditandoSubasta(false);
        }
    };

    const crearSubasta = async (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        try {
            setGuardandoSubasta(true);
            setErrorCrear(null);
            setSuccessCrear(null);

            await apiAuth.post('/subasta', {
                marca_vehiculo: nuevaSubasta.marca_vehiculo,
                modelo_vehiculo: nuevaSubasta.modelo_vehiculo,
                anio_vehiculo: Number(nuevaSubasta.anio_vehiculo),
                nombre_refaccion: nuevaSubasta.nombre_refaccion,
                descripcion_problema: nuevaSubasta.descripcion_problema,
                urgencia: nuevaSubasta.urgencia,
                estado: 'abierta',
                fecha_expiracion: nuevaSubasta.fecha_expiracion,
            });

            setSuccessCrear('Subasta creada correctamente.');
            setNuevaSubasta(nuevaSubastaInicial);
            setShowCrearModal(false);
            cargarSubastas();
        } catch (err: any) {
            console.log('ERROR CREAR SUBASTA:', err.response?.data);

            const data = err.response?.data;

            if (data?.msg) {
                setErrorCrear(data.msg);
            } else if (data?.message) {
                setErrorCrear(data.message);
            } else if (data?.errors) {
                const firstError = Object.values(data.errors)[0] as string[];
                setErrorCrear(firstError?.[0] || 'No se pudo crear la subasta.');
            } else {
                setErrorCrear('No se pudo crear la subasta.');
            }
        } finally {
            setGuardandoSubasta(false);
        }
    };

    const getEstadoBadge = (estado: string) => {
        switch (estado) {
            case 'abierta':
                return 'info';
            case 'cerrada':
                return 'secondary';
            case 'cancelada':
                return 'danger';
            case 'finalizada':
                return 'success';
            default:
                return 'secondary';
        }
    };

    const formatCurrency = (value: number | string) => {
        const amount = Number(value);

        if (Number.isNaN(amount)) {
            return `$${value} MXN`;
        }

        return amount.toLocaleString('es-MX', {
            style: 'currency',
            currency: 'MXN',
        });
    };

    const formatFecha = (value?: string) => {
        if (!value) return 'No disponible';

        const date = new Date(value);

        if (Number.isNaN(date.getTime())) {
            return value;
        }

        return date.toLocaleDateString('es-MX', {
            day: '2-digit',
            month: 'long',
            year: 'numeric',
        });
    };

    const aceptarPuja = async (oferta: Oferta) => {
        if (!subastaSeleccionada) return;

        try {
            setAceptandoOfertaId(oferta.id);
            setErrorOfertas(null);

            await apiAuth.patch(`/oferta/${oferta.id}/aceptar`);

            await cargarOfertas(subastaSeleccionada);
            await cargarSubastas();
        } catch (err: any) {
            const data = err.response?.data;

            if (data?.msg) {
                setErrorOfertas(data.msg);
            } else if (data?.message) {
                setErrorOfertas(data.message);
            } else {
                setErrorOfertas('No se pudo aceptar la puja.');
            }
        } finally {
            setAceptandoOfertaId(null);
        }
    };

    const nombreComprador = (oferta: Oferta) => {
        if (oferta.proveedor?.nombre) {
            return `${oferta.proveedor.nombre} ${oferta.proveedor.apellidos || ''}`.trim();
        }

        if (oferta.proveedor?.email) {
            return oferta.proveedor.email;
        }

        return `Usuario #${oferta.proveedor_id}`;
    };

    if (loading) {
        return (
            <div className="text-center py-5">
                <Spinner animation="border" variant="primary" />
                <p className="text-white-50 mt-3">Cargando tus subastas...</p>
            </div>
        );
    }

    return (
        <div>
            <div className="d-flex justify-content-between align-items-center mb-4">
                <h3 className="mb-0">Mis Subastas Publicadas</h3>

                <div className="d-flex gap-2">
                    <Button onClick={abrirModalCrear} className="btn-primary-custom">
                        Crear Subasta
                    </Button>

                    <Button onClick={cargarSubastas} className="btn btn-outline-custom">
                        Actualizar
                    </Button>
                </div>
            </div>

            {successCrear && <Alert variant="success">{successCrear}</Alert>}

            {successEditar && <Alert variant="success">{successEditar}</Alert>}

            {error && <Alert variant="danger">{error}</Alert>}

            {!error && misSubastas.length === 0 && (
                <Alert variant="info">
                    Todavía no has publicado subastas.
                </Alert>
            )}

            <Row className="g-4">
                {misSubastas.map((subasta) => (
                    <Col xs={12} lg={6} key={subasta.id}>
                        <Card className="glass-panel text-white border-0 p-4 h-100">
                            <div className="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h4 className="text-primary mb-1">{subasta.nombre_refaccion}</h4>
                                    <p className="text-white-50 mb-0">
                                        {subasta.marca_vehiculo} {subasta.modelo_vehiculo} {subasta.anio_vehiculo}
                                    </p>
                                </div>

                                <Badge bg={getEstadoBadge(subasta.estado)} className="px-3 py-2 rounded-pill fs-6">
                                    {subasta.estado.toUpperCase()}
                                </Badge>
                            </div>

                            <div
                                className="d-flex justify-content-between mt-auto pt-3 border-top"
                                style={{ borderColor: 'rgba(255,255,255,0.1) !important' }}
                            >
                                <div>
                                    <small className="text-white-50 d-block">Publicada</small>
                                    <strong>{formatFecha(subasta.created_at)}</strong>
                                </div>

                                <div className="text-end">
                                    <small className="text-white-50 d-block">Pujas Recibidas</small>
                                    <strong className="text-primary fs-5">{subasta.ofertas_count || 0}</strong>
                                </div>
                            </div>

                            <div className="d-flex gap-2 mt-4">
                                <Button
                                    onClick={() => cargarOfertas(subasta)}
                                    className="btn btn-outline-custom w-100"
                                >
                                    Ver Pujas
                                </Button>

                                <Button
                                    onClick={() => abrirModalEditar(subasta)}
                                    className="btn btn-outline-custom w-100"
                                >
                                    Editar
                                </Button>

                                {subasta.slug && (
                                    <Link to={`/auctions/${subasta.slug}`} className="btn btn-outline-custom w-100">
                                        Ver Detalle
                                    </Link>
                                )}
                            </div>
                        </Card>
                    </Col>
                ))}
            </Row>

            <Modal
                show={showCrearModal}
                onHide={() => setShowCrearModal(false)}
                centered
                size="lg"
                contentClassName="bg-dark text-white border-0 shadow-lg"
            >
                <Modal.Header closeButton closeVariant="white" className="border-0 px-4 pt-4">
                    <Modal.Title className="fw-bold">Crear nueva subasta</Modal.Title>
                </Modal.Header>

                <Modal.Body className="px-4 pb-4">
                    {errorCrear && <Alert variant="danger">{errorCrear}</Alert>}

                    <Form onSubmit={crearSubasta}>
                        <Row className="g-3">
                            <Col md={6}>
                                <Form.Group>
                                    <Form.Label>Marca del vehículo</Form.Label>
                                    <Form.Control
                                        type="text"
                                        value={nuevaSubasta.marca_vehiculo}
                                        onChange={(e) => handleNuevaSubastaChange('marca_vehiculo', e.target.value)}
                                        required
                                        className="form-control-custom"
                                        placeholder="Ejemplo: Honda"
                                    />
                                </Form.Group>
                            </Col>

                            <Col md={6}>
                                <Form.Group>
                                    <Form.Label>Modelo del vehículo</Form.Label>
                                    <Form.Control
                                        type="text"
                                        value={nuevaSubasta.modelo_vehiculo}
                                        onChange={(e) => handleNuevaSubastaChange('modelo_vehiculo', e.target.value)}
                                        required
                                        className="form-control-custom"
                                        placeholder="Ejemplo: Civic"
                                    />
                                </Form.Group>
                            </Col>

                            <Col md={6}>
                                <Form.Group>
                                    <Form.Label>Año del vehículo</Form.Label>
                                    <Form.Control
                                        type="number"
                                        value={nuevaSubasta.anio_vehiculo}
                                        onChange={(e) => handleNuevaSubastaChange('anio_vehiculo', e.target.value)}
                                        required
                                        className="form-control-custom"
                                        placeholder="Ejemplo: 2018"
                                    />
                                </Form.Group>
                            </Col>

                            <Col md={6}>
                                <Form.Group>
                                    <Form.Label>Nombre de la refacción</Form.Label>
                                    <Form.Control
                                        type="text"
                                        value={nuevaSubasta.nombre_refaccion}
                                        onChange={(e) => handleNuevaSubastaChange('nombre_refaccion', e.target.value)}
                                        required
                                        className="form-control-custom"
                                        placeholder="Ejemplo: Bomba de agua"
                                    />
                                </Form.Group>
                            </Col>

                            <Col md={6}>
                                <Form.Group>
                                    <Form.Label>Urgencia</Form.Label>
                                    <Form.Select
                                        value={nuevaSubasta.urgencia}
                                        onChange={(e) => handleNuevaSubastaChange('urgencia', e.target.value)}
                                        required
                                        className="form-control-custom"
                                    >
                                        <option value="baja">Baja</option>
                                        <option value="media">Media</option>
                                        <option value="alta">Alta</option>
                                    </Form.Select>
                                </Form.Group>
                            </Col>

                            <Col md={6}>
                                <Form.Group>
                                    <Form.Label>Fecha de expiración</Form.Label>
                                    <Form.Control
                                        type="date"
                                        value={nuevaSubasta.fecha_expiracion}
                                        onChange={(e) => handleNuevaSubastaChange('fecha_expiracion', e.target.value)}
                                        required
                                        className="form-control-custom"
                                    />
                                </Form.Group>
                            </Col>

                            <Col xs={12}>
                                <Form.Group>
                                    <Form.Label>Descripción del problema o refacción</Form.Label>
                                    <Form.Control
                                        as="textarea"
                                        rows={4}
                                        value={nuevaSubasta.descripcion_problema}
                                        onChange={(e) => handleNuevaSubastaChange('descripcion_problema', e.target.value)}
                                        required
                                        className="form-control-custom"
                                        placeholder="Describe qué refacción necesitas o qué problema tiene el vehículo"
                                    />
                                </Form.Group>
                            </Col>
                        </Row>

                        <div className="d-flex gap-2 mt-4">
                            <Button
                                type="button"
                                className="btn btn-outline-custom w-100"
                                onClick={() => setShowCrearModal(false)}
                                disabled={guardandoSubasta}
                            >
                                Cancelar
                            </Button>

                            <Button
                                type="submit"
                                className="btn-primary-custom w-100"
                                disabled={guardandoSubasta}
                            >
                                {guardandoSubasta ? 'Guardando...' : 'Guardar Subasta'}
                            </Button>
                        </div>
                    </Form>
                </Modal.Body>
            </Modal>
            <Modal
                show={showEditarModal}
                onHide={() => setShowEditarModal(false)}
                centered
                size="lg"
                contentClassName="bg-dark text-white border-0 shadow-lg"
            >
                <Modal.Header closeButton closeVariant="white" className="border-0 px-4 pt-4">
                    <Modal.Title className="fw-bold">Editar subasta</Modal.Title>
                </Modal.Header>

                <Modal.Body className="px-4 pb-4">
                    {errorEditar && <Alert variant="danger">{errorEditar}</Alert>}

                    <Form onSubmit={actualizarSubasta}>
                        <Row className="g-3">
                            <Col md={6}>
                                <Form.Group>
                                    <Form.Label>Marca del vehículo</Form.Label>
                                    <Form.Control
                                        type="text"
                                        value={editarSubasta.marca_vehiculo}
                                        onChange={(e) => handleEditarSubastaChange('marca_vehiculo', e.target.value)}
                                        required
                                        className="form-control-custom"
                                    />
                                </Form.Group>
                            </Col>

                            <Col md={6}>
                                <Form.Group>
                                    <Form.Label>Modelo del vehículo</Form.Label>
                                    <Form.Control
                                        type="text"
                                        value={editarSubasta.modelo_vehiculo}
                                        onChange={(e) => handleEditarSubastaChange('modelo_vehiculo', e.target.value)}
                                        required
                                        className="form-control-custom"
                                    />
                                </Form.Group>
                            </Col>

                            <Col md={6}>
                                <Form.Group>
                                    <Form.Label>Año del vehículo</Form.Label>
                                    <Form.Control
                                        type="number"
                                        value={editarSubasta.anio_vehiculo}
                                        onChange={(e) => handleEditarSubastaChange('anio_vehiculo', e.target.value)}
                                        required
                                        className="form-control-custom"
                                    />
                                </Form.Group>
                            </Col>

                            <Col md={6}>
                                <Form.Group>
                                    <Form.Label>Nombre de la refacción</Form.Label>
                                    <Form.Control
                                        type="text"
                                        value={editarSubasta.nombre_refaccion}
                                        onChange={(e) => handleEditarSubastaChange('nombre_refaccion', e.target.value)}
                                        required
                                        className="form-control-custom"
                                    />
                                </Form.Group>
                            </Col>

                            <Col md={6}>
                                <Form.Group>
                                    <Form.Label>Urgencia</Form.Label>
                                    <Form.Select
                                        value={editarSubasta.urgencia}
                                        onChange={(e) => handleEditarSubastaChange('urgencia', e.target.value)}
                                        required
                                        className="form-control-custom"
                                    >
                                        <option value="baja">Baja</option>
                                        <option value="media">Media</option>
                                        <option value="alta">Alta</option>
                                    </Form.Select>
                                </Form.Group>
                            </Col>

                            <Col md={6}>
                                <Form.Group>
                                    <Form.Label>Estado</Form.Label>
                                    <Form.Select
                                        value={editarSubasta.estado}
                                        onChange={(e) => handleEditarSubastaChange('estado', e.target.value)}
                                        required
                                        className="form-control-custom"
                                    >
                                        <option value="abierta">Abierta</option>
                                        <option value="cerrada">Cerrada</option>
                                        <option value="cancelada">Cancelada</option>
                                        <option value="finalizada">Finalizada</option>
                                    </Form.Select>
                                </Form.Group>
                            </Col>

                            <Col md={6}>
                                <Form.Group>
                                    <Form.Label>Fecha de expiración</Form.Label>
                                    <Form.Control
                                        type="date"
                                        value={editarSubasta.fecha_expiracion}
                                        onChange={(e) => handleEditarSubastaChange('fecha_expiracion', e.target.value)}
                                        required
                                        className="form-control-custom"
                                    />
                                </Form.Group>
                            </Col>

                            <Col xs={12}>
                                <Form.Group>
                                    <Form.Label>Descripción del problema o refacción</Form.Label>
                                    <Form.Control
                                        as="textarea"
                                        rows={4}
                                        value={editarSubasta.descripcion_problema}
                                        onChange={(e) => handleEditarSubastaChange('descripcion_problema', e.target.value)}
                                        required
                                        className="form-control-custom"
                                    />
                                </Form.Group>
                            </Col>
                        </Row>

                        <div className="d-flex gap-2 mt-4">
                            <Button
                                type="button"
                                className="btn btn-outline-custom w-100"
                                onClick={() => setShowEditarModal(false)}
                                disabled={editandoSubasta}
                            >
                                Cancelar
                            </Button>

                            <Button
                                type="submit"
                                className="btn-primary-custom w-100"
                                disabled={editandoSubasta}
                            >
                                {editandoSubasta ? 'Guardando...' : 'Guardar cambios'}
                            </Button>
                        </div>
                    </Form>
                </Modal.Body>
            </Modal>
            <Modal
                show={showModal}
                onHide={() => setShowModal(false)}
                size="lg"
                centered
                contentClassName="bg-dark text-white border-0 shadow-lg"
            >
                <Modal.Header closeButton closeVariant="white" className="border-0 px-4 pt-4">
                    <Modal.Title className="fw-bold">
                        Pujas recibidas
                    </Modal.Title>
                </Modal.Header>

                <Modal.Body className="px-4 pb-4">
                    {subastaSeleccionada && (
                        <div className="mb-4">
                            <h5 className="text-primary mb-1">{subastaSeleccionada.nombre_refaccion}</h5>
                            <p className="text-white-50 mb-0">
                                {subastaSeleccionada.marca_vehiculo} {subastaSeleccionada.modelo_vehiculo} {subastaSeleccionada.anio_vehiculo}
                            </p>
                        </div>
                    )}

                    {loadingOfertas && (
                        <div className="text-center py-4">
                            <Spinner animation="border" variant="primary" />
                            <p className="text-white-50 mt-3">Cargando pujas...</p>
                        </div>
                    )}

                    {errorOfertas && <Alert variant="danger">{errorOfertas}</Alert>}

                    {!loadingOfertas && !errorOfertas && ofertas.length === 0 && (
                        <Alert variant="info">
                            Esta subasta todavía no tiene pujas.
                        </Alert>
                    )}

                    {!loadingOfertas && !errorOfertas && ofertas.length > 0 && (
                        <Table responsive bordered hover variant="dark" className="align-middle">
                            <thead>
                                <tr>
                                    <th>Comprador</th>
                                    <th>Correo</th>
                                    <th>Oferta</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>

                            <tbody>
                                {ofertas.map((oferta) => (
                                    <tr key={oferta.id}>
                                        <td>{nombreComprador(oferta)}</td>
                                        <td>{oferta.proveedor?.email || 'No disponible'}</td>
                                        <td>
                                            <strong className="text-primary">
                                                {formatCurrency(oferta.precio_ofertado)}
                                            </strong>
                                        </td>
                                        <td>{formatFecha(oferta.fecha_oferta || oferta.created_at)}</td>
                                        <td>
                                            <Badge bg={oferta.es_aceptada ? 'success' : 'warning'}>
                                                {oferta.es_aceptada ? 'ACEPTADA' : 'PENDIENTE'}
                                            </Badge>
                                        </td>
                                        <td>
                                            {oferta.es_aceptada ? (
                                                <Button className="btn btn-success btn-sm" disabled>
                                                    Aceptada
                                                </Button>
                                            ) : (
                                                <Button
                                                    className="btn btn-outline-custom btn-sm"
                                                    onClick={() => aceptarPuja(oferta)}
                                                    disabled={aceptandoOfertaId === oferta.id}
                                                >
                                                    {aceptandoOfertaId === oferta.id ? 'Aceptando...' : 'Aceptar'}
                                                </Button>
                                            )}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </Table>
                    )}
                </Modal.Body>
            </Modal>
        </div>
    );
}
