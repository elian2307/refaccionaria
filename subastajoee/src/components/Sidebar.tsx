import { NavLink, Link, useNavigate } from 'react-router-dom';

export default function Sidebar() {
    const navigate = useNavigate();

    const handleLogout = () => {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        navigate('/');
    };
    return (
        <aside className="dashboard-sidebar">
            <Link to="/" className="sidebar-logo">
                <i className="fa-solid fa-car"></i>
                <span>Subastas JOEE</span>
            </Link>

            <nav style={{ flex: 1, display: 'flex', flexDirection: 'column', justifyContent: 'space-between' }}>
                <ul className="sidebar-nav">
                    <li>
                        <NavLink to="/dashboard/subastas" className={({ isActive }) => isActive ? "sidebar-nav-link active" : "sidebar-nav-link"}>
                            <i className="fa-solid fa-list-check"></i>
                            Mis Subastas
                        </NavLink>
                    </li>
                    <li>
                        <NavLink to="/dashboard/ofertas" className={({ isActive }) => isActive ? "sidebar-nav-link active" : "sidebar-nav-link"}>
                            <i className="fa-solid fa-hand-holding-dollar"></i>
                            Mis Ofertas
                        </NavLink>
                    </li>
                    <li>
                        <NavLink to="/dashboard/pedidos" className={({ isActive }) => isActive ? "sidebar-nav-link active" : "sidebar-nav-link"}>
                            <i className="fa-solid fa-box-open"></i>
                            Órdenes
                        </NavLink>
                    </li>
                    <li>
                        <NavLink to="/dashboard/resenas" className={({ isActive }) => isActive ? "sidebar-nav-link active" : "sidebar-nav-link"}>
                            <i className="fa-solid fa-star"></i>
                            Reseñas
                        </NavLink>
                    </li>
                    <li>
                        <NavLink to="/dashboard/gamificacion" className={({ isActive }) => isActive ? "sidebar-nav-link active" : "sidebar-nav-link"}>
                            <i className="fa-solid fa-trophy"></i>
                            Gamificación
                        </NavLink>
                    </li>
                </ul>

                <ul className="sidebar-nav mb-4">
                    <li>
                        <button
                            type="button"
                            onClick={handleLogout}
                            className="sidebar-nav-link sidebar-logout-button"
                            style={{ color: 'var(--danger)' }}
                        >
                            <i className="fa-solid fa-arrow-right-from-bracket"></i>
                            Cerrar Sesión
                        </button>
                    </li>
                </ul>
            </nav>
        </aside>
    );
}
