import { Outlet } from 'react-router-dom';
import Sidebar from './Sidebar';

export default function DashboardLayout() {
    return (
        <div className="dashboard-wrapper">
            <Sidebar />
            <main className="dashboard-main">
                <header className="dashboard-header">
                    <div>
                        <h1>Dashboard</h1>
                        <p>Gestiona tus subastas publicadas y pujas</p>
                    </div>
                    {/* Replicating the search bar pattern from Laravel dashboard */}
                    <div className="search" style={{ 
                        background: 'var(--card-bg)', 
                        border: '1px solid rgba(255,255,255,0.1)', 
                        padding: '1rem 1.5rem', 
                        borderRadius: '50px', 
                        display: 'flex', 
                        gap: '1rem', 
                        alignItems: 'center',
                        width: '300px'
                    }}>
                        <i className="fa-solid fa-magnifying-glass"></i>
                        <input 
                            type="text" 
                            placeholder="Buscar..." 
                            style={{ 
                                border: 'none', 
                                background: 'transparent', 
                                outline: 'none', 
                                color: 'var(--text-main)', 
                                width: '100%' 
                            }} 
                        />
                    </div>
                </header>
                <div className="cont">
                    <Outlet />
                </div>
            </main>
        </div>
    );
}
