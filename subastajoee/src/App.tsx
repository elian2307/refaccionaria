import { BrowserRouter, Routes, Route, Navigate } from "react-router-dom";
import Layout from "./layouts/mainwebsite/Layout";
import DashboardLayout from "./layouts/dashboard/DashboardLayout";
import ProtectedRoute from "./components/ProtectedRoute";
import Home from "./views/Home";
import Contact from "./views/Contact";
import Auctions from "./views/Auctions";
import Search from "./views/Search";

// Dashboard Views
import MisSubastas from "./views/dashboard/MisSubastas";
import MisOfertas from "./views/dashboard/MisOfertas";
import MisPedidos from "./views/dashboard/MisPedidos";
import MisResenas from "./views/dashboard/MisResenas";
import AuctionDetail from "./views/AuctionDetail";
import NivelesJOEE from "./views/dashboard/Gamificacion";

function App() {
  return (
    <BrowserRouter>
      <Routes>
        {/* Public Routes with Main Layout */}
        <Route path="/" element={<Layout />}>
          <Route index element={<Home />} />
          <Route path="auctions" element={<Auctions />} />
          <Route path="contact" element={<Contact />} />
          <Route path="search" element={<Search />} />
          <Route path="auctions/:slug" element={<AuctionDetail />} />
        </Route>

        {/* Protected Dashboard Routes with Dashboard Layout */}
        <Route element={<ProtectedRoute />}>
          <Route path="/dashboard" element={<DashboardLayout />}>
            <Route index element={<Navigate to="subastas" replace />} />
            <Route path="subastas" element={<MisSubastas />} />
            <Route path="ofertas" element={<MisOfertas />} />
            <Route path="pedidos" element={<MisPedidos />} />
            <Route path="resenas" element={<MisResenas />} />
            <Route path="niveles" element={<NivelesJOEE />} />
          </Route>
        </Route>
      </Routes>
    </BrowserRouter>
  );
}

export default App;
