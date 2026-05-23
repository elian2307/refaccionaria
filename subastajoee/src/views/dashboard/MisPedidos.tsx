import { useEffect, useRef, useState } from 'react';
import { Alert, Badge, Button, Card, Col, Form, Row, Spinner } from 'react-bootstrap';
import { Link } from 'react-router-dom';
import { apiAuth } from '../../services/api';
import { getUser } from '../../services/auth';

interface Comprador {
    id: number;
    nombre?: string;
    apellidos?: string;
    email?: string;
    rol?: string;
}

interface Subasta {
    id: number;
    slug?: string;
    user_id: number;
    marca_vehiculo: string;
    modelo_vehiculo: string;
    anio_vehiculo: number;
    nombre_refaccion: string;
    estado: string;
}

interface Oferta {
    id: number;
    subasta_id: number;
    proveedor_id: number;
    precio_ofertado: number | string;
    es_aceptada?: boolean;
    proveedor?: Comprador;
}

interface Pedido {
    id: number;
    subasta_id: number;
    oferta_id: number;
    monto_total: number | string;
    monto_comision: number | string;
    estado_pago: string;
    estado_envio: string;
    numero_rastreo: string;
    fecha_pedido: string;
    created_at: string;
    paypal_order_id?: string | null;
    paypal_capture_id?: string | null;
    paypal_status?: string | null;
    paypal_payer_email?: string | null;
    fecha_pago?: string | null;
    subasta?: Subasta;
    oferta?: Oferta;
}

declare global {
    interface Window {
        paypal?: any;
    }
}

let paypalScriptPromise: Promise<void> | null = null;

const cargarScriptPaypal = () => {
    const clientId = import.meta.env.VITE_PAYPAL_CLIENT_ID;
    const currency = import.meta.env.VITE_PAYPAL_CURRENCY || 'MXN';

    if (!clientId) {
        return Promise.reject(new Error('Falta VITE_PAYPAL_CLIENT_ID en el .env de React'));
    }

    if (window.paypal) {
        return Promise.resolve();
    }

    if (paypalScriptPromise) {
        return paypalScriptPromise;
    }

    paypalScriptPromise = new Promise((resolve, reject) => {
        const script = document.createElement('script');
        script.src = `https://www.paypal.com/sdk/js?client-id=${clientId}&currency=${currency}&intent=capture`;
        script.async = true;
        script.onload = () => resolve();
        script.onerror = () => reject(new Error('No se pudo cargar el SDK de PayPal'));
        document.body.appendChild(script);
    });

    return paypalScriptPromise;
};

function PaypalPedidoButton({
    pedido,
    onSuccess,
    onError,
}: {
    pedido: Pedido;
    onSuccess: (mensaje: string) => void;
    onError: (mensaje: string) => void;
}) {
    const paypalContainerRef = useRef<HTMLDivElement | null>(null);
    const botonesRenderizadosRef = useRef(false);

    useEffect(() => {
        let cancelado = false;

        const renderizarBoton = async () => {
            try {
                await cargarScriptPaypal();

                if (cancelado || !paypalContainerRef.current || botonesRenderizadosRef.current) {
                    return;
                }

                botonesRenderizadosRef.current = true;
                paypalContainerRef.current.innerHTML = '';

                window.paypal.Buttons({
                    style: {
                        layout: 'vertical',
                        color: 'gold',
                        shape: 'rect',
                        label: 'pay',
                    },
                    createOrder: async () => {
                        const response = await apiAuth.post(`/paypal/pedido/${pedido.id}/create-order`);
                        const orderId = response.data?.paypal_order_id;

                        if (!orderId) {
                            throw new Error('Laravel no regresó el ID de la orden de PayPal');
                        }

                        return orderId;
                    },
                    onApprove: async (data: any) => {
                        await apiAuth.post(`/paypal/pedido/${pedido.id}/capture-order`, {
                            paypal_order_id: data.orderID,
                        });

                        onSuccess('Pago confirmado correctamente con PayPal.');
                    },
                    onCancel: () => {
                        onError('El pago fue cancelado antes de completarse.');
                    },
                    onError: (err: any) => {
                        console.error('PayPal error:', err);
                        onError('Ocurrió un error al procesar el pago con PayPal.');
                    },
                }).render(paypalContainerRef.current);
            } catch (err: any) {
                onError(err.message || 'No se pudo iniciar PayPal.');
            }
        };

        renderizarBoton();

        return () => {
            cancelado = true;

            if (paypalContainerRef.current) {
                paypalContainerRef.current.innerHTML = '';
            }
        };
    }, [pedido.id, onError, onSuccess]);

    return <div ref={paypalContainerRef} />;
}

export default function MisPedidos() {
    const [pedidos, setPedidos] = useState<Pedido[]>([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState<string | null>(null);
    const [success, setSuccess] = useState<string | null>(null);
    const [actualizandoPedidoId, setActualizandoPedidoId] = useState<number | null>(null);

    const user = getUser();

const puedeActualizarEnvio = user?.rol === 'vendedor' || user?.rol === 'admin';

const puedePagarPedido = (pedido: Pedido) => {
    const userId = Number(user?.id);
    const rol = String(user?.rol || '').toLowerCase();

    if (rol === 'admin') {
        return pedido.estado_pago === 'pendiente';
    }

    return (
        pedido.estado_pago === 'pendiente' &&
        Number(pedido.oferta?.proveedor_id) === userId
    );
};

    const cargarPedidos = async () => {
        try {
            setLoading(true);
            setError(null);

            const response = await apiAuth.get('/pedido');

            if (response.data.success) {
                setPedidos(response.data.pedidos || []);
            } else {
                setError('No se pudieron cargar tus órdenes.');
            }
        } catch (err: any) {
            setError(err.response?.data?.msg || 'No se pudieron cargar tus órdenes.');
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        cargarPedidos();
    }, []);

    const actualizarCampoPedido = (pedidoId: number, field: keyof Pedido, value: string) => {
        setPedidos((current) =>
            current.map((pedido) =>
                pedido.id === pedidoId
                    ? {
                        ...pedido,
                        [field]: value,
                    }
                    : pedido
            )
        );
    };

    const guardarCambiosPedido = async (pedido: Pedido) => {
        try {
            setActualizandoPedidoId(pedido.id);
            setError(null);
            setSuccess(null);

            await apiAuth.put(`/pedido/${pedido.id}`, {
                estado_envio: pedido.estado_envio,
                numero_rastreo: pedido.numero_rastreo || 'Pendiente',
            });

            setSuccess('Orden actualizada correctamente.');
            cargarPedidos();
        } catch (err: any) {
            setError(err.response?.data?.msg || 'No se pudo actualizar la orden.');
        } finally {
            setActualizandoPedidoId(null);
        }
    };

    const pagoExitoso = (mensaje: string) => {
        setSuccess(mensaje);
        setError(null);
        cargarPedidos();
    };

    const pagoConError = (mensaje: string) => {
        setError(mensaje);
        setSuccess(null);
    };

    const getEnvioBadge = (estado: string) => {
        switch (estado) {
            case 'entregado':
                return 'success';
            case 'enviado':
                return 'warning';
            case 'pendiente':
                return 'secondary';
            default:
                return 'secondary';
        }
    };

    const getPagoBadge = (estado: string) => {
        switch (estado) {
            case 'pagado':
                return 'success';
            case 'reembolsado':
                return 'danger';
            case 'pendiente':
                return 'warning';
            default:
                return 'secondary';
        }
    };

    const formatEstado = (estado: string) => {
        if (!estado) return 'NO DISPONIBLE';
        return estado.replace('_', ' ').toUpperCase();
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

    const formatFecha = (value?: string | null) => {
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

    const nombreComprador = (pedido: Pedido) => {
        const comprador = pedido.oferta?.proveedor;

        if (comprador?.nombre) {
            return `${comprador.nombre} ${comprador.apellidos || ''}`.trim();
        }

        if (comprador?.email) {
            return comprador.email;
        }

        return `Usuario #${pedido.oferta?.proveedor_id || 'N/A'}`;
    };

    if (loading) {
        return (
            <div className="text-center py-5">
                <Spinner animation="border" variant="primary" />
                <p className="text-white-50 mt-3">Cargando tus órdenes...</p>
            </div>
        );
    }

    return (
        <div>
            <div className="d-flex justify-content-between align-items-center mb-4">
                <h3 className="mb-0">Mis Órdenes</h3>

                <Button onClick={cargarPedidos} className="btn btn-outline-custom">
                    Actualizar
                </Button>
            </div>

            {success && <Alert variant="success">{success}</Alert>}
            {error && <Alert variant="danger">{error}</Alert>}

            {!error && pedidos.length === 0 && (
                <Alert variant="info">
                    Todavía no tienes órdenes. Las órdenes se generan cuando un vendedor acepta una puja.
                </Alert>
            )}

            <Row className="g-4">
                {pedidos.map((pedido) => (
                    <Col xs={12} key={pedido.id}>
                        <Card className="glass-panel text-white border-0 p-4">
                            <Row className="align-items-start g-3">
                                <Col md={2}>
                                    <small className="text-white-50 d-block">ID Orden</small>
                                    <strong className="text-primary">ORD-{pedido.id}</strong>
                                </Col>

                                <Col md={3}>
                                    <small className="text-white-50 d-block">Artículo</small>
                                    <strong>
                                        {pedido.subasta?.nombre_refaccion || `Subasta #${pedido.subasta_id}`}
                                    </strong>

                                    <p className="text-white-50 small mb-0 mt-1">
                                        {pedido.subasta
                                            ? `${pedido.subasta.marca_vehiculo} ${pedido.subasta.modelo_vehiculo} ${pedido.subasta.anio_vehiculo}`
                                            : 'Información no disponible'}
                                    </p>
                                </Col>

                                <Col md={2}>
                                    <small className="text-white-50 d-block">Comprador</small>
                                    <strong>{nombreComprador(pedido)}</strong>
                                    <p className="text-white-50 small mb-0 mt-1">
                                        {pedido.oferta?.proveedor?.email || 'Correo no disponible'}
                                    </p>
                                </Col>

                                <Col md={2}>
                                    <small className="text-white-50 d-block">Total</small>
                                    <strong className="text-primary fs-5">
                                        {formatCurrency(pedido.monto_total)}
                                    </strong>

                                    <p className="text-white-50 small mb-0 mt-1">
                                        Comisión: {formatCurrency(pedido.monto_comision)}
                                    </p>
                                </Col>

                                <Col md={3} className="text-md-end">
                                    <div className="mb-2">
                                        <Badge bg={getPagoBadge(pedido.estado_pago)} className="px-3 py-2 rounded-pill me-2">
                                            Pago: {formatEstado(pedido.estado_pago)}
                                        </Badge>

                                        <Badge bg={getEnvioBadge(pedido.estado_envio)} className="px-3 py-2 rounded-pill">
                                            Envío: {formatEstado(pedido.estado_envio)}
                                        </Badge>
                                    </div>

                                    <small className="text-white-50 d-block">Fecha de pedido</small>
                                    <strong>{formatFecha(pedido.fecha_pedido || pedido.created_at)}</strong>

                                    {pedido.fecha_pago && (
                                        <p className="text-white-50 small mb-0 mt-1">
                                            Pagado: {formatFecha(pedido.fecha_pago)}
                                        </p>
                                    )}
                                </Col>
                            </Row>

                            <hr className="border-secondary my-4" />

                            <Row className="align-items-end g-3">
                                <Col md={3}>
                                    <small className="text-white-50 d-block mb-1">Número de rastreo</small>

                                    {puedeActualizarEnvio ? (
                                        <Form.Control
                                            type="text"
                                            value={pedido.numero_rastreo || ''}
                                            onChange={(e) => actualizarCampoPedido(pedido.id, 'numero_rastreo', e.target.value)}
                                            className="form-control-custom"
                                            placeholder="Pendiente"
                                        />
                                    ) : (
                                        <strong>{pedido.numero_rastreo || 'Pendiente'}</strong>
                                    )}
                                </Col>

                                <Col md={3}>
                                    <small className="text-white-50 d-block mb-1">Estado de pago</small>
                                    <strong>{formatEstado(pedido.estado_pago)}</strong>

                                    {pedido.paypal_order_id && (
                                        <p className="text-white-50 small mb-0 mt-1">
                                            PayPal: {pedido.paypal_order_id}
                                        </p>
                                    )}
                                </Col>

                                <Col md={3}>
                                    <small className="text-white-50 d-block mb-1">Estado de envío</small>

                                    {puedeActualizarEnvio ? (
                                        <Form.Select
                                            value={pedido.estado_envio}
                                            onChange={(e) => actualizarCampoPedido(pedido.id, 'estado_envio', e.target.value)}
                                            className="form-control-custom"
                                        >
                                            <option value="pendiente">Pendiente</option>
                                            <option value="enviado">Enviado</option>
                                            <option value="entregado">Entregado</option>
                                        </Form.Select>
                                    ) : (
                                        <strong>{formatEstado(pedido.estado_envio)}</strong>
                                    )}
                                </Col>

                                <Col md={3} className="d-flex gap-2 flex-column">
                                    {pedido.subasta?.slug && (
                                        <Link
                                            to={`/auctions/${pedido.subasta.slug}`}
                                            className="btn btn-outline-custom w-100"
                                        >
                                            Ver subasta
                                        </Link>
                                    )}

                                    {puedeActualizarEnvio && (
                                        <Button
                                            className="btn-primary-custom w-100"
                                            onClick={() => guardarCambiosPedido(pedido)}
                                            disabled={actualizandoPedidoId === pedido.id}
                                        >
                                            {actualizandoPedidoId === pedido.id ? 'Guardando...' : 'Guardar envío'}
                                        </Button>
                                    )}

                                    {puedePagarPedido(pedido) && (
                                        <div className="bg-white rounded p-2">
                                            <PaypalPedidoButton
                                                pedido={pedido}
                                                onSuccess={pagoExitoso}
                                                onError={pagoConError}
                                            />
                                        </div>
                                    )}
                                </Col>
                            </Row>
                        </Card>
                    </Col>
                ))}
            </Row>
        </div>
    );
}