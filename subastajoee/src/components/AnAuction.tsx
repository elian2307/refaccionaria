import { Col, Card, Badge } from 'react-bootstrap';
import { Link, useNavigate, useOutletContext } from 'react-router-dom';
import { getToken, getUser } from '../services/auth';

interface ImgSubasta {
    id?: number;
    subasta_id: number;
    url: string;
}

interface AuctionProps {
    name: string;
    brand: string;
    model: string;
    slug: string;
    anio: string | number;
    description: string;
    urgency: string;
    status: string;
    offersCount?: number;
    expirationDate: string;
    img_subastas?: ImgSubasta[];
}

const getUrgencyColor = (urgency: string) => {
    switch (urgency) {
        case 'alta': return 'danger';
        case 'media': return 'warning';
        case 'baja': return 'info';
        default: return 'secondary';
    }
};

const getStatusColor = (status: string) => {
    switch (status) {
        case 'abierta': return 'success';
        case 'cerrada': return 'secondary';
        case 'cancelada': return 'danger';
        case 'finalizada': return 'primary';
        default: return 'secondary';
    }
};

const formatText = (value: string) => {
    if (!value) return 'No especificado';
    return value.charAt(0).toUpperCase() + value.slice(1);
};

const formatDate = (value: string) => {
    if (!value) return 'No especificada';

    const date = new Date(value);

    if (Number.isNaN(date.getTime())) return value;

    return date.toLocaleDateString('es-MX', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    });
};

const shortDescription = (value: string) => {
    if (!value) return 'Sin descripción disponible.';
    return value.length > 115 ? `${value.slice(0, 115)}...` : value;
};

export default function AnAuction({
    name,
    brand,
    model,
    anio,
    description,
    slug,
    urgency,
    status,
    offersCount,
    expirationDate,
    img_subastas
}: AuctionProps) {
    const navigate = useNavigate();

    const context = useOutletContext<{ handleShowLogin?: () => void }>();
    const handleShowLogin = context?.handleShowLogin;

    const handleMakeOfferClick = () => {
        const token = getToken();

        if (!token) {
            if (handleShowLogin) {
                handleShowLogin();
            }

            return;
        }

        const user = getUser();

        if (user?.rol !== 'comprador' && user?.rol !== 'admin') {
            alert('Solo los compradores pueden hacer pujas.');
            return;
        }

        if (status !== 'abierta') {
            alert('Esta subasta no está abierta, por eso no se puede hacer una puja.');
            return;
        }

        navigate(`/auctions/${slug}`);
    };

    return (
        <Col xs={12} md={6} lg={4}>
            <Card className="glass-panel h-100 text-white border-0 auction-card">
                <Card.Header className="bg-transparent border-bottom border-secondary pt-4 pb-3">
                    <div className="d-flex justify-content-between align-items-start gap-3">
                        <div>
                            <h5 className="fw-bold text-primary mb-2">{name}</h5>
                            <p className="text-white-50 small mb-0">
                                {brand} {model} {anio}
                            </p>
                        </div>

                        <Badge bg={getUrgencyColor(urgency)} className="rounded-pill px-3 py-2">
                            {formatText(urgency)}
                        </Badge>
                    </div>
                </Card.Header>

                <Card.Body className="d-flex flex-column p-4">
                    {img_subastas && img_subastas.length > 0 ? (
                        <img
                            src={img_subastas[0].url}
                            alt={name}
                            className="img-fluid rounded mb-3 auction-card-img"
                            style={{ height: '180px', width: '100%', objectFit: 'cover' }}
                        />
                    ) : (
                        <div
                            className="d-flex align-items-center justify-content-center bg-dark rounded mb-3 text-white-50 border border-secondary"
                            style={{ height: '180px', width: '100%' }}
                        >
                            <span className="small">Sin imagen disponible</span>
                        </div>
                    )}

                    <div className="mb-3">
                        <Badge bg={getStatusColor(status)} className="rounded-pill px-3 py-2">
                            Estado: {formatText(status)}
                        </Badge>
                    </div>

                    <p className="mb-4 small text-white-50 auction-card-description">
                        {shortDescription(description)}
                    </p>

                    <div className="auction-card-info mt-auto">
                        <div className="auction-card-info-item">
                            <span>Pujas recibidas</span>
                            <strong>{offersCount || 0}</strong>
                        </div>

                        <div className="auction-card-info-item">
                            <span>Fecha límite</span>
                            <strong>{formatDate(expirationDate)}</strong>
                        </div>
                    </div>

                    <hr className="my-3 border-secondary" />

                    <div className="auction-actions">
                        <Link to={`/auctions/${slug}`} className="btn auction-action-btn auction-action-secondary">
                            Ver detalles
                        </Link>

                        <button onClick={handleMakeOfferClick} className="btn auction-action-btn auction-action-primary">
                            Pujar / Hacer Oferta
                        </button>
                    </div>
                </Card.Body>
            </Card>
        </Col>
    );
}