<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Solicitudes pendientes</title>
    <link rel="stylesheet" href="./public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="public/js/jquery-4.0.0.min.js"></script>
    <script src="public/js/solicitud.js"></script>
    <script src="public/js/logout.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin</a>
            <div class="navbar-nav">
                <a class="nav-link" href="index.php?page=talleres">Talleres</a>
                <a class="nav-link active" href="index.php?page=admin">Gestionar Solicitudes</a>
            </div>
            <div class="d-flex">
                <span class="navbar-text me-3">Admin: <?= htmlspecialchars($_SESSION['user'] ?? 'Administrador') ?></span>
                <button id="btnLogout" class="btn btn-outline-danger btn-sm">Cerrar sesión</button>
            </div>
        </div>
    </nav>
    
    <main class="container">
        <h2>Solicitudes pendientes de aprobación</h2>
        <div id="mensaje" class="alert alert-info" style="display:none;"></div>
        <div class="table-container">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Taller</th>
                        <th>Solicitante</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="solicitudes-body">
                    <tr><td colspan="5" class="text-center">Cargando solicitudes...</td></tr>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>