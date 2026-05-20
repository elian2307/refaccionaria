import { useState, useEffect } from 'react';
import { Container, Row, Badge, Spinner, Alert } from 'react-bootstrap';
import AnAuction from '../components/AnAuction';
import { api } from '../services/api';
import type { Subasta } from '../interfaces/Subasta';

export default function Auctions() {
    const [subastas, setSubastas] = useState<Subasta[]>([]);
    const [loading, setLoading] = useState<boolean>(true);
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
                    console.log('Subastas obtenidas:', response.data.subastas);
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


    return (
        <Container className="py-5 my-5">
            <div className="d-flex flex-wrap justify-content-between align-items-center mb-5 gap-4">
                <div>
                    <h1 className="fw-bold mb-2 text-white">Subastas de Refacciones</h1>
                    <p className="text-white-50 mb-0">Revisa las piezas publicadas y puja por ellas</p>
                </div>
                <div>
                    <Badge bg="primary" className="p-2 px-3 rounded-pill fs-6">
                        {subastas.length} Subastas Activas
                    </Badge>
                </div>
            </div>

            {loading && (
                <div className="text-center py-5">
                    <Spinner animation="border" variant="primary" />
                    <p className="mt-3 text-white-50">Cargando subastas...</p>
                </div>
            )}

            {error && (
                <Alert variant="danger">
                    {error}
                </Alert>
            )}

            {!loading && !error && subastas.length === 0 && (
                <div className="text-center py-5">
                    <p className="text-white-50 fs-5">No hay subastas activas en este momento.</p>
                </div>
            )}

            <Row className="g-4">
                {subastas.map((req) => (                                                                        
                    <AnAuction 
                        key={req.id}
                        name={req.nombre_refaccion} 
                        brand={req.marca_vehiculo} 
                        model={req.modelo_vehiculo} 
                        anio={req.anio_vehiculo} 
                        description={req.descripcion_problema} 
                        slug={req.slug}
                        urgency={req.urgencia} 
                        status={req.estado} 
                        offersCount={req.ofertas_count} 
                        expirationDate={req.fecha_expiracion}
                        img_subastas={req.img_subastas} 
                    />
                ))}
            </Row>
        </Container>
    );
}
