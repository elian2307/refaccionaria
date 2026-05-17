import { Navigate, Outlet } from 'react-router-dom';

export default function ProtectedRoute() {
    const token = localStorage.getItem('token');
    
    // Si no hay token, lo redirigimos al inicio
    if (!token) {
        return <Navigate to="/" replace />;
    }

    // Si sí hay token, renderizamos las rutas hijas
    return <Outlet />;
}
