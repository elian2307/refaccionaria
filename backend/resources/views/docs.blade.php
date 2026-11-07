<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refaccionaria API | Documentación Oficial</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet" />

    <style>
        :root {
            --primary-color: #6366f1;
            --sidebar-bg: #ffffff;
            --content-bg: #f8fafc;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--content-bg);
            color: var(--text-main);
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            width: 280px;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .brand-logo {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .nav-links {
            padding: 1.5rem 0;
        }

        .nav-link {
            padding: 0.75rem 1.5rem;
            color: var(--text-muted);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-left: 3px solid transparent;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-color);
            background-color: #eef2ff;
            border-left-color: var(--primary-color);
        }

        main {
            margin-left: 280px;
            padding: 2rem 3rem;
            min-height: 100vh;
        }

        .doc-section {
            padding-top: 4rem;
            margin-top: -2rem;
            margin-bottom: 4rem;
        }

        .section-title {
            font-weight: 700;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .badge-method {
            padding: 0.4rem 0.8rem;
            font-weight: 700;
            font-size: 0.75rem;
            border-radius: 6px;
            text-transform: uppercase;
            min-width: 70px;
            text-align: center;
        }

        .badge-get { background-color: #dcfce7; color: #166534; }
        .badge-post { background-color: #dbeafe; color: #1e40af; }
        .badge-put { background-color: #fef9c3; color: #854d0e; }
        .badge-delete { background-color: #fee2e2; color: #991b1b; }

        .api-card {
            background: #fff;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        .api-header {
            padding: 1.25rem 1.5rem;
            background-color: #fff;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .api-endpoint {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            color: var(--text-main);
            font-size: 0.95rem;
        }

        .api-body {
            padding: 1.5rem;
        }

        .code-block-header {
            background: #2d2d2d;
            padding: 0.5rem 1rem;
            border-radius: 8px 8px 0 0;
            color: #ccc;
            font-size: 0.8rem;
            font-weight: 500;
        }

        pre[class*="language-"] {
            margin-top: 0 !important;
            border-radius: 0 0 8px 8px !important;
            font-size: 0.85rem !important;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
        }

        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                overflow: hidden;
            }

            .sidebar:hover {
                width: 280px;
            }

            main {
                margin-left: 70px;
                padding: 2rem 1.5rem;
            }

            .nav-link span {
                display: none;
            }

            .sidebar:hover .nav-link span {
                display: inline;
            }
        }
    </style>
</head>
<body>

<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="brand-logo">
            <i class="bi bi-car-front-fill"></i>
            <span>Refaccionaria API</span>
        </a>
    </div>

    <div class="nav-links">
        <a href="#intro" class="nav-link active"><i class="bi bi-house-door"></i><span>Introducción</span></a>

        <div class="px-4 py-2 small text-uppercase text-muted fw-bold">JWT</div>
        <a href="#login" class="nav-link"><i class="bi bi-shield-lock"></i><span>Login JWT</span></a>
        <a href="#user" class="nav-link"><i class="bi bi-person-badge"></i><span>Usuario autenticado</span></a>
        <a href="#logout" class="nav-link"><i class="bi bi-box-arrow-right"></i><span>Logout</span></a>

        <div class="px-4 py-2 mt-3 small text-uppercase text-muted fw-bold">CRUDS</div>
        <a href="#users" class="nav-link"><i class="bi bi-people"></i><span>Users</span></a>
        <a href="#direccion" class="nav-link"><i class="bi bi-geo-alt"></i><span>Direcciones</span></a>
        <a href="#subasta" class="nav-link"><i class="bi bi-hammer"></i><span>Subastas</span></a>
        <a href="#oferta" class="nav-link"><i class="bi bi-tags"></i><span>Ofertas</span></a>
        <a href="#pedido" class="nav-link"><i class="bi bi-receipt"></i><span>Pedidos</span></a>
        <a href="#resena" class="nav-link"><i class="bi bi-star"></i><span>Reseñas</span></a>
        <a href="#imgSubasta" class="nav-link"><i class="bi bi-image"></i><span>Imágenes</span></a>

        <div class="px-4 py-2 mt-3 small text-uppercase text-muted fw-bold">Errores</div>
        <a href="#errors" class="nav-link"><i class="bi bi-exclamation-triangle"></i><span>Errores</span></a>
    </div>
</nav>

<main>
<div class="container-fluid">

<section id="intro" class="doc-section">
    <h1 class="display-6 fw-bold mb-4">Documentación de la API</h1>
    <p class="lead text-muted">
        API REST desarrollada en Laravel para un sistema de refaccionaria con usuarios, direcciones, subastas, ofertas, pedidos, reseñas e imágenes de subastas.
        La autenticación se realiza mediante JWT y las respuestas se manejan en formato JSON.
    </p>

    <div class="alert alert-info border-0 shadow-sm glass">
        <i class="bi bi-info-circle-fill me-2"></i>
        Base URL local: <code>http://127.0.0.1:8000/api</code>
    </div>

    <div class="alert alert-warning border-0 shadow-sm glass">
        <i class="bi bi-lock-fill me-2"></i>
        Las rutas CRUD están protegidas. Deben incluir los headers:
        <code>Authorization: Bearer TOKEN_GENERADO</code> y <code>Accept: application/json</code>.
    </div>
</section>

<hr class="my-5">

<section id="login" class="doc-section">
    <h2 class="section-title"><i class="bi bi-shield-lock-fill text-primary"></i>Login JWT</h2>

    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-post">POST</span>
            <span class="api-endpoint">/api/login</span>
        </div>
        <div class="api-body">
            <p>Permite iniciar sesión y obtener un token JWT.</p>

            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold">Request Body</h6>
                    <div class="code-block-header">JSON</div>
<pre><code class="language-json">{
  "email": "juan@example.com",
  "password": "12345678"
}</code></pre>
                </div>

                <div class="col-md-6">
                    <h6 class="fw-bold">Response 200 OK</h6>
                    <div class="code-block-header">JSON</div>
<pre><code class="language-json">{
  "success": true,
  "token": "TOKEN_GENERADO",
  "user": {
    "id": 9,
    "nombre": "Juan",
    "apellidos": "Perez",
    "email": "juan@example.com",
    "rol": "comprador",
    "tipo_usuario": "usuario"
  },
  "expires_in": 3600
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="user" class="doc-section">
    <h2 class="section-title"><i class="bi bi-person-badge-fill text-success"></i>Usuario autenticado</h2>

    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-get">GET</span>
            <span class="api-endpoint">/api/user</span>
        </div>
        <div class="api-body">
            <p>Obtiene la información del usuario autenticado mediante el token JWT.</p>
            <p><strong>Headers:</strong> <code>Authorization: Bearer TOKEN_GENERADO</code>, <code>Accept: application/json</code></p>

            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold">Request Body</h6>
                    <div class="code-block-header">Vacío</div>
<pre><code class="language-json">{}</code></pre>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold">Response 200 OK</h6>
                    <div class="code-block-header">JSON</div>
<pre><code class="language-json">{
  "success": true,
  "user": {
    "id": 9,
    "nombre": "Juan",
    "apellidos": "Perez",
    "email": "juan@example.com",
    "rol": "comprador",
    "tipo_usuario": "usuario"
  }
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="logout" class="doc-section">
    <h2 class="section-title"><i class="bi bi-box-arrow-right text-danger"></i>Logout JWT</h2>

    <div class="api-card">
        <div class="api-header">
            <span class="badge-method badge-post">POST</span>
            <span class="api-endpoint">/api/logout</span>
        </div>
        <div class="api-body">
            <p>Cierra sesión e invalida el token JWT.</p>
            <p><strong>Headers:</strong> <code>Authorization: Bearer TOKEN_GENERADO</code>, <code>Accept: application/json</code></p>

            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold">Request Body</h6>
                    <div class="code-block-header">Vacío</div>
<pre><code class="language-json">{}</code></pre>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold">Response 200 OK</h6>
                    <div class="code-block-header">JSON</div>
<pre><code class="language-json">{
  "success": true,
  "msg": "Successfully logged out"
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="users" class="doc-section">
    <h2 class="section-title"><i class="bi bi-people-fill text-primary"></i>CRUD Users</h2>

    <div class="api-card">
        <div class="api-header"><span class="badge-method badge-get">GET</span><span class="api-endpoint">/api/users</span></div>
        <div class="api-body">
            <p>Lista todos los usuarios registrados.</p>
            <div class="row">
                <div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">Vacío</div><pre><code class="language-json">{}</code></pre></div>
                <div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "users": [
    {
      "id": 9,
      "nombre": "Juan",
      "apellidos": "Perez",
      "email": "juan@example.com",
      "rol": "comprador",
      "tipo_usuario": "usuario"
    }
  ]
}</code></pre></div>
            </div>
        </div>
    </div>

    <div class="api-card">
        <div class="api-header"><span class="badge-method badge-post">POST</span><span class="api-endpoint">/api/users</span></div>
        <div class="api-body">
            <p>Crea un nuevo usuario.</p>
            <div class="row">
                <div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "nombre": "Juan",
  "apellidos": "Perez",
  "email": "juan@example.com",
  "password": "12345678",
  "rol": "comprador",
  "tipo_usuario": "usuario",
  "id_fiscal": "RFC123456",
  "telefono": "6141234567",
  "reputacion": 4.5,
  "is_premium": true,
  "fecha_registro": "2026-04-22",
  "foto_perfil": "foto.jpg",
  "is_active": true
}</code></pre></div>
                <div class="col-md-6"><h6 class="fw-bold">Response 201 Created</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "msg": "User created successfully",
  "user": {
    "id": 9,
    "nombre": "Juan",
    "email": "juan@example.com",
    "rol": "comprador"
  }
}</code></pre></div>
            </div>
        </div>
    </div>

    <div class="api-card">
        <div class="api-header"><span class="badge-method badge-get">GET</span><span class="api-endpoint">/api/users/{id}</span></div>
        <div class="api-body">
            <p>Consulta un usuario específico.</p>
            <div class="row">
                <div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">Vacío</div><pre><code class="language-json">{}</code></pre></div>
                <div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "user": {
    "id": 9,
    "nombre": "Juan",
    "apellidos": "Perez",
    "email": "juan@example.com"
  }
}</code></pre></div>
            </div>
        </div>
    </div>

    <div class="api-card">
        <div class="api-header"><span class="badge-method badge-put">PUT</span><span class="api-endpoint">/api/users/{id}</span></div>
        <div class="api-body">
            <p>Actualiza un usuario específico.</p>
            <div class="row">
                <div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "telefono": "6149999999",
  "is_premium": false
}</code></pre></div>
                <div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "msg": "User updated successfully",
  "user": {
    "id": 9,
    "telefono": "6149999999",
    "is_premium": false
  }
}</code></pre></div>
            </div>
        </div>
    </div>

    <div class="api-card">
        <div class="api-header"><span class="badge-method badge-delete">DELETE</span><span class="api-endpoint">/api/users/{id}</span></div>
        <div class="api-body">
            <p>Elimina un usuario específico.</p>
            <div class="row">
                <div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">Vacío</div><pre><code class="language-json">{}</code></pre></div>
                <div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "msg": "User deleted successfully"
}</code></pre></div>
            </div>
        </div>
    </div>
</section>

<section id="direccion" class="doc-section">
    <h2 class="section-title"><i class="bi bi-geo-alt-fill text-success"></i>CRUD Direcciones</h2>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-get">GET</span><span class="api-endpoint">/api/direccion</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">Vacío</div><pre><code class="language-json">{}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "message": "Addresses retrieved successfully",
  "direcciones": []
}</code></pre></div></div></div></div>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-post">POST</span><span class="api-endpoint">/api/direccion</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "user_id": 1,
  "calle": "Av. Tecnologico",
  "numero_exterior": "123",
  "numero_interior": "A",
  "colonia": "Centro",
  "municipio": "Chihuahua",
  "estado": "Chihuahua",
  "codigo_postal": "31000"
}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 201 Created</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "msg": "Address created successfully",
  "direccion": {
    "id": 1,
    "user_id": 1,
    "calle": "Av. Tecnologico"
  }
}</code></pre></div></div></div></div>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-get">GET</span><span class="api-endpoint">/api/direccion/{id}</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">Vacío</div><pre><code class="language-json">{}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "direccion": {
    "id": 1,
    "user_id": 1,
    "calle": "Av. Tecnologico"
  }
}</code></pre></div></div></div></div>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-put">PUT</span><span class="api-endpoint">/api/direccion/{id}</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "colonia": "San Felipe"
}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "msg": "Address updated successfully",
  "direccion": {
    "id": 1,
    "colonia": "San Felipe"
  }
}</code></pre></div></div></div></div>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-delete">DELETE</span><span class="api-endpoint">/api/direccion/{id}</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">Vacío</div><pre><code class="language-json">{}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "msg": "Address deleted successfully"
}</code></pre></div></div></div></div>
</section>

<section id="subasta" class="doc-section">
    <h2 class="section-title"><i class="bi bi-hammer text-warning"></i>CRUD Subastas</h2>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-get">GET</span><span class="api-endpoint">/api/subasta</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">Vacío</div><pre><code class="language-json">{}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "message": "Subastas retrieved successfully",
  "subastas": []
}</code></pre></div></div></div></div>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-post">POST</span><span class="api-endpoint">/api/subasta</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "user_id": 1,
  "marca_vehiculo": "Nissan",
  "modelo_vehiculo": "Versa",
  "anio_vehiculo": "2020",
  "nombre_refaccion": "Faro delantero",
  "descripcion_problema": "Necesito reemplazo del faro derecho",
  "urgencia": "alta",
  "estado": "abierta",
  "fecha_expiracion": "2026-05-01"
}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 201 Created</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "msg": "Subasta created successfully",
  "subasta": {
    "id": 1,
    "user_id": 1,
    "nombre_refaccion": "Faro delantero",
    "estado": "abierta"
  }
}</code></pre></div></div><p class="mt-3"><strong>Valores válidos:</strong> urgencia: baja, media, alta. estado: abierta, cerrada, cancelada, finalizada.</p></div></div>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-get">GET</span><span class="api-endpoint">/api/subasta/{id}</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">Vacío</div><pre><code class="language-json">{}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "subasta": {
    "id": 1,
    "marca_vehiculo": "Nissan",
    "nombre_refaccion": "Faro delantero"
  }
}</code></pre></div></div></div></div>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-put">PUT</span><span class="api-endpoint">/api/subasta/{id}</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "estado": "cerrada"
}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "msg": "Subasta updated successfully",
  "subasta": {
    "id": 1,
    "estado": "cerrada"
  }
}</code></pre></div></div></div></div>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-delete">DELETE</span><span class="api-endpoint">/api/subasta/{id}</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">Vacío</div><pre><code class="language-json">{}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "msg": "Subasta deleted successfully"
}</code></pre></div></div></div></div>
</section>

<section id="oferta" class="doc-section">
    <h2 class="section-title"><i class="bi bi-tags-fill text-info"></i>CRUD Ofertas</h2>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-get">GET</span><span class="api-endpoint">/api/oferta</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">Vacío</div><pre><code class="language-json">{}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "message": "Ofertas retrieved successfully",
  "ofertas": []
}</code></pre></div></div></div></div>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-post">POST</span><span class="api-endpoint">/api/oferta</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "subasta_id": 1,
  "proveedor_id": 2,
  "precio_ofertado": 2500.50,
  "dias_entrega": 3,
  "condicion_pieza": "nueva",
  "meses_garantia": 6,
  "es_aceptada": false,
  "fecha_oferta": "2026-04-22"
}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 201 Created</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "msg": "Oferta created successfully",
  "oferta": {
    "id": 1,
    "subasta_id": 1,
    "proveedor_id": 2,
    "precio_ofertado": 2500.50
  }
}</code></pre></div></div></div></div>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-get">GET</span><span class="api-endpoint">/api/oferta/{id}</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">Vacío</div><pre><code class="language-json">{}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "oferta": {
    "id": 1,
    "precio_ofertado": 2500.50,
    "es_aceptada": false
  }
}</code></pre></div></div></div></div>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-put">PUT</span><span class="api-endpoint">/api/oferta/{id}</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "es_aceptada": true
}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "msg": "Oferta updated successfully",
  "oferta": {
    "id": 1,
    "es_aceptada": true
  }
}</code></pre></div></div></div></div>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-delete">DELETE</span><span class="api-endpoint">/api/oferta/{id}</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">Vacío</div><pre><code class="language-json">{}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "msg": "Oferta deleted successfully"
}</code></pre></div></div></div></div>
</section>

<section id="pedido" class="doc-section">
    <h2 class="section-title"><i class="bi bi-receipt-cutoff text-secondary"></i>CRUD Pedidos</h2>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-get">GET</span><span class="api-endpoint">/api/pedido</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">Vacío</div><pre><code class="language-json">{}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "message": "Pedidos retrieved successfully",
  "pedidos": []
}</code></pre></div></div></div></div>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-post">POST</span><span class="api-endpoint">/api/pedido</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "subasta_id": 1,
  "oferta_id": 1,
  "monto_total": 2500.50,
  "monto_comision": 125.00,
  "estado_pago": "pendiente",
  "estado_envio": "pendiente",
  "numero_rastreo": "TRACK123456",
  "fecha_pedido": "2026-04-22 12:00:00"
}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 201 Created</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "msg": "Pedido created successfully",
  "pedido": {
    "id": 1,
    "subasta_id": 1,
    "oferta_id": 1,
    "estado_pago": "pendiente",
    "estado_envio": "pendiente"
  }
}</code></pre></div></div><p class="mt-3"><strong>Valores válidos:</strong> estado_pago: pendiente, pagado, reembolsado. estado_envio: pendiente, enviado, entregado.</p></div></div>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-get">GET</span><span class="api-endpoint">/api/pedido/{id}</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">Vacío</div><pre><code class="language-json">{}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "pedido": {
    "id": 1,
    "monto_total": 2500.50,
    "estado_pago": "pendiente"
  }
}</code></pre></div></div></div></div>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-put">PUT</span><span class="api-endpoint">/api/pedido/{id}</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "estado_pago": "pagado",
  "estado_envio": "enviado"
}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "msg": "Pedido updated successfully",
  "pedido": {
    "id": 1,
    "estado_pago": "pagado",
    "estado_envio": "enviado"
  }
}</code></pre></div></div></div></div>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-delete">DELETE</span><span class="api-endpoint">/api/pedido/{id}</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">Vacío</div><pre><code class="language-json">{}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "msg": "Pedido deleted successfully"
}</code></pre></div></div></div></div>
</section>

<section id="resena" class="doc-section">
    <h2 class="section-title"><i class="bi bi-star-fill text-warning"></i>CRUD Reseñas</h2>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-get">GET</span><span class="api-endpoint">/api/resena</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">Vacío</div><pre><code class="language-json">{}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "message": "Resenas retrieved successfully",
  "resenas": []
}</code></pre></div></div></div></div>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-post">POST</span><span class="api-endpoint">/api/resena</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "pedido_id": 1,
  "autor_id": 1,
  "receptor_id": 2,
  "calificacion": 5,
  "comentario": "Excelente servicio y entrega rapida",
  "fecha_resena": "2026-04-22"
}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 201 Created</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "msg": "Resena created successfully",
  "resena": {
    "id": 1,
    "pedido_id": 1,
    "calificacion": 5
  }
}</code></pre></div></div></div></div>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-get">GET</span><span class="api-endpoint">/api/resena/{id}</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">Vacío</div><pre><code class="language-json">{}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "resena": {
    "id": 1,
    "comentario": "Excelente servicio y entrega rapida"
  }
}</code></pre></div></div></div></div>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-put">PUT</span><span class="api-endpoint">/api/resena/{id}</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "comentario": "Excelente servicio y entrega muy rapida"
}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "msg": "Resena updated successfully",
  "resena": {
    "id": 1,
    "comentario": "Excelente servicio y entrega muy rapida"
  }
}</code></pre></div></div></div></div>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-delete">DELETE</span><span class="api-endpoint">/api/resena/{id}</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">Vacío</div><pre><code class="language-json">{}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "msg": "Resena deleted successfully"
}</code></pre></div></div></div></div>
</section>

<section id="imgSubasta" class="doc-section">
    <h2 class="section-title"><i class="bi bi-image-fill text-primary"></i>CRUD Imágenes de Subastas</h2>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-get">GET</span><span class="api-endpoint">/api/imgSubasta</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">Vacío</div><pre><code class="language-json">{}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "imagenes": []
}</code></pre></div></div></div></div>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-post">POST</span><span class="api-endpoint">/api/imgSubasta</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "subasta_id": 1,
  "url": "faro1.jpg"
}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 201 Created</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "msg": "Imagen agregada correctamente",
  "img": {
    "id": 1,
    "subasta_id": 1,
    "url": "faro1.jpg"
  }
}</code></pre></div></div><p class="mt-3">Si no se envía <code>url</code>, la base de datos guarda automáticamente <code>default.png</code>.</p></div></div>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-get">GET</span><span class="api-endpoint">/api/imgSubasta/{id}</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">Vacío</div><pre><code class="language-json">{}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "img": {
    "id": 1,
    "subasta_id": 1,
    "url": "faro1.jpg"
  }
}</code></pre></div></div></div></div>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-put">PUT</span><span class="api-endpoint">/api/imgSubasta/{id}</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "url": "faro_actualizado.jpg"
}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "msg": "Imagen actualizada",
  "img": {
    "id": 1,
    "url": "faro_actualizado.jpg"
  }
}</code></pre></div></div></div></div>

    <div class="api-card"><div class="api-header"><span class="badge-method badge-delete">DELETE</span><span class="api-endpoint">/api/imgSubasta/{id}</span></div><div class="api-body"><div class="row"><div class="col-md-6"><h6 class="fw-bold">Request Body</h6><div class="code-block-header">Vacío</div><pre><code class="language-json">{}</code></pre></div><div class="col-md-6"><h6 class="fw-bold">Response 200 OK</h6><div class="code-block-header">JSON</div><pre><code class="language-json">{
  "success": true,
  "msg": "Imagen eliminada"
}</code></pre></div></div></div></div>
</section>

<section id="errors" class="doc-section">
    <h2 class="section-title"><i class="bi bi-exclamation-triangle-fill text-danger"></i>Errores y protección JWT</h2>

    <div class="api-card">
        <div class="api-header">
            <span class="fw-bold">Errores comunes</span>
        </div>
        <div class="api-body">

            <h6 class="fw-bold">Token requerido</h6>
            <div class="code-block-header">401 Unauthorized</div>
<pre><code class="language-json">{
  "success": false,
  "msg": "Token requerido"
}</code></pre>

            <h6 class="fw-bold mt-4">Token inválido</h6>
            <div class="code-block-header">401 Unauthorized</div>
<pre><code class="language-json">{
  "success": false,
  "msg": "Token inválido"
}</code></pre>

            <h6 class="fw-bold mt-4">Registro no encontrado</h6>
            <div class="code-block-header">404 Not Found</div>
<pre><code class="language-json">{
  "success": false,
  "msg": "User not found"
}</code></pre>

            <h6 class="fw-bold mt-4">Validación fallida</h6>
            <div class="code-block-header">422 Unprocessable Entity</div>
<pre><code class="language-json">{
  "error": "Validación fallida",
  "message": "Los datos enviados no son correctos para los estándares de BitCorp.",
  "details": {
    "email": [
      "El correo electrónico ya ha sido registrado."
    ]
  }
}</code></pre>
        </div>
    </div>
</section>

<footer class="mt-5 py-4 border-top text-center text-muted small">
    &copy; {{ date('Y') }} Refaccionaria API System. Todos los derechos reservados.
</footer>

</div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-json.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sections = document.querySelectorAll('.doc-section');
    const navLinks = document.querySelectorAll('.nav-link');

    window.addEventListener('scroll', () => {
        let current = '';

        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            if (pageYOffset >= sectionTop - 100) {
                current = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href').includes(current)) {
                link.classList.add('active');
            }
        });
    });
});
</script>

</body>
</html>