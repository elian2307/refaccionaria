import { useState } from 'react';
import { Outlet } from 'react-router-dom';

import Header from './Header.tsx';
import Footer from './Footer.tsx';
import LoginModal from '../../components/LoginModal.tsx';

export default function Layout() {
  //const navigate = useNavigate();

  const [showLogin, setShowLogin] = useState(false);

  const handleShow = () => setShowLogin(true);
  const handleHideLogin = () => setShowLogin(false);

  return (
    <>
      <Header buttonFunction={handleShow} />

        {/* Aqui va todo el contenido de los demas paginas*/}

        <main className="main-content">
          <Outlet context={{ handleShowLogin: handleShow }} />
        </main>

      <Footer />

      <LoginModal show={showLogin} onHide={handleHideLogin} />
    </>
  );
}
