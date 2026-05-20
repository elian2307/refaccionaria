import { useEffect, useState } from 'react';
import { Alert, Badge, Button, Card, Col, Row, Spinner } from 'react-bootstrap';
import { Link } from 'react-router-dom';
import { apiAuth } from '../../services/api';

interface Subasta {
    id: number;
    slug: string;
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
    dias_entrega: number;
    condicion_pieza: string;
    meses_garantia: number;
    es_aceptada: boolean;
    fecha_oferta: string;
    created_at: string;
    subasta?: Subasta;
}

export default function MisOfertas() {
    const [misOfertas, setMisOfertas] = useState<Oferta[]>([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState<string | null>(null);

    const cargarOfertas = async () => {
        try {
            setLoading(true);
            setError(null);

            const response = await apiAuth.get('/mis-ofertas');

            if (response.data.success) {
                setMisOfertas(response.data.ofertas || []);
            } else {
                setError('No se pudieron cargar tus pujas.');
            }
        } catch (err: any) {
            setError(err.response?.data?.msg || 'No se pudieron cargar tus pujas.');
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        cargarOfertas();
    }, []);

    const getEstadoBadge = (oferta: Oferta) => {
        if (oferta.es_aceptada) return 'success';
        return 'warning';
    };

    const getEstadoTexto = (oferta: Oferta) => {
        if (oferta.es_aceptada) return 'ACEPTADA';
        return 'PENDIENTE';
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

    if (loading) {
        return (
            <div className="text-center py-5">
                <Spinner animation="border" variant="primary" />
                <p className="text-white-50 mt-3">Cargando tus pujas...</p>
            </div>
        );
    }

    return (
        <div>
            <div className="d-flex justify-content-between align-items-center mb-4">
                <h3 className="mb-0">Mis Pujas Realizadas</h3>

                <Button onClick={cargarOfertas} className="btn btn-outline-custom">
                    Actualizar
                </Button>
            </div>

            {error && <Alert variant="danger">{error}</Alert>}

            {!error && misOfertas.length === 0 && (
                <Alert variant="info">
                    Todavía no has realizado ninguna puja.
                </Alert>
            )}

            <Row className="g-4">
                {misOfertas.map((oferta) => (
                    <Col xs={12} lg={4} key={oferta.id}>
                        <Card className="glass-panel text-white border-0 p-4 h-100">
                            <div className="d-flex justify-content-between align-items-center mb-3">
                                <h5 className="mb-0">
                                    {oferta.subasta?.nombre_refaccion || `Subasta #${oferta.subasta_id}`}
                                </h5>

                                <Badge bg={getEstadoBadge(oferta)} className="px-3 py-2 rounded-pill">
                                    {getEstadoTexto(oferta)}
                                </Badge>
                            </div>

                            <p className="text-muted mb-4">
                                {oferta.subasta
                                    ? `${oferta.subasta.marca_vehiculo} ${oferta.subasta.modelo_vehiculo} ${oferta.subasta.anio_vehiculo}`
                                    : 'Información de subasta no disponible'}
                            </p>

                            <div className="bg-dark p-3 rounded mb-4" style={{ backgroundColor: 'rgba(0,0,0,0.3) !important' }}>
                                <div className="d-flex justify-content-between mb-2">
                                    <span className="text-muted">Cantidad pujada:</span>
                                    <strong className="text-primary">{formatCurrency(oferta.precio_ofertado)}</strong>
                                </div>

                                <div className="d-flex justify-content-between">
                                    <span className="text-muted">Fecha de puja:</span>
                                    <strong>{formatFecha(oferta.fecha_oferta || oferta.created_at)}</strong>
                                </div>
                            </div>

                            {oferta.subasta?.slug ? (
                                <Link to={`/auctions/${oferta.subasta.slug}`} className="btn btn-outline-custom w-100 mt-auto">
                                    Ver Subasta Original
                                </Link>
                            ) : (
                                <button className="btn btn-outline-custom w-100 mt-auto" disabled>
                                    Subasta no disponible
                                </button>
                            )}
                        </Card>
                    </Col>
                ))}
            </Row>
        </div>
    );
}