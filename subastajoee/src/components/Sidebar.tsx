import { NavLink, Link } from 'react-router-dom';

export default function Sidebar() {
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
                </ul>

                <ul className="sidebar-nav mb-4">
                    <li>
                        <Link to="/" className="sidebar-nav-link" style={{ color: 'var(--danger)' }}>
                            <i className="fa-solid fa-arrow-right-from-bracket"></i>
                            Cerrar Sesión
                        </Link>
                    </li>
                </ul>
            </nav>
        </aside>
    );
}
