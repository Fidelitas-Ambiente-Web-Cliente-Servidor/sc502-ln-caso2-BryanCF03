<!DOCTYPE html>
<html>

<head>
    <title>Listado Talleres</title>
    <link rel="stylesheet" href="./public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="public/js/jquery-4.0.0.min.js"></script>
    <script src="public/js/taller.js"></script>
    <script src="public/js/logout.js"></script>
</head>

<body class="container mt-5">
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Talleres</a>
            <div class="navbar-nav">
                <a class="nav-link active" href="index.php?page=talleres">Talleres</a>
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                    <a class="nav-link" href="index.php?page=admin">Gestionar Solicitudes</a>
                <?php endif; ?>
            </div>
            <div class="d-flex">
                <span class="navbar-text me-3"><?= htmlspecialchars($_SESSION['user'] ?? 'Usuario') ?></span>
                <button id="btnLogout" class="btn btn-outline-danger btn-sm">Cerrar sesión</button>
            </div>
        </div>
    </nav>

    <main>
        <h3>Talleres disponibles</h3>
        <div id="mensaje" class="alert alert-info" style="display:none;"></div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Cupo máximo</th>
                    <th>Cupo disponible</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="talleres-body">
                <tr><td colspan="6" class="text-center">Cargando talleres...</td></tr>
            </tbody>
        </table>
    </main>
</body>
</html>