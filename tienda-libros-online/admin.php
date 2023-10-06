<?php
session_start();

// Verificamos la autenticación del usuario
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit;
}

# Conexión con la base de datos
include "db_conexion.php";

# Incluir la función de los libros
include "php/func-libro.php";
$libros = get_all_books($conn);

# Incluir la función de los autores
include "php/func-autor.php";
$autores = get_all_author($conn);

# Incluir la función de las categorías
include "php/func-categoria.php";
$categorias = get_all_categories($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <!-- Enlace al archivo CSS de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Enlace al DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.10/css/jquery.dataTables.css">
    <!-- Enlace al archivo CSS personalizado -->
    <link href="css/estilos-admin.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Barra de navegación del admin -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="admin.php">Admin</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php">Tienda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Añadir Libro</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Añadir Categoría</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Añadir Autor</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Tabla para mostrar los libros -->

            <h4>Agregar Libros</h4>
            <table id="libros-table" class="table table-bordered shadow">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Portada</th>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($libros as $libro) { ?>
                        <tr>
                            <td>1</td>
                            <td>
                                <img width="100" src="archivos/cover/<?= $libro->portada ?>">
                            </td>
                            <td>
                                <?= htmlspecialchars($libro->titulo) ?>
                            </td>
                            <td>
                                <?php
                                    $autorNombre = "Undefined";
                                    foreach ($autores as $autor) {
                                     if ($autor->id == $libro->autor_id) {
                                    $autorNombre = htmlspecialchars($autor->nombre . ' ' . $autor->apellido);
                                     break;
                                    }
                                        }
                                    echo $autorNombre;
                                 ?>
                            </td>
                            <td><?= htmlspecialchars($libro->descripcion) ?></td>
                            <td>
                                <?php
                                $categoriaNombre = "Undefined";
                                foreach ($categorias as $categoria) {
                                    if ($categoria->id == $libro->categoria_id) {
                                        $categoriaNombre = htmlspecialchars($categoria->nombre);
                                        break;
                                    }
                                }
                                echo $categoriaNombre;
                                ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="#" class="btn btn-warning" style="margin-right: 5px;">Editar</a>
                                    <a href="#" class="btn btn-danger">Eliminar</a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        <!-- Tabla para mostrar las categorías -->

        <h4>Agregar Categorías</h4>
        <table id="categorias-table" class="table table-bordered shadow">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $categoria) { ?>
                    <tr>
                        <td><?= $categoria->id ?></td>
                        <td><?= htmlspecialchars($categoria->nombre) ?></td>
                        <td>
                            <a href="editar-categoria.php?id=<?= $categoria->id ?>" class="btn btn-warning">Editar</a>           <a href="eliminar-categoria.php?id=<?= $categoria->id ?>" class="btn btn-danger">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Tabla para mostrar los autores -->

        <h4>Agregar Autores</h4>
        <table id="autores-table" class="table table-bordered shadow">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre del Autor</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($autores as $autor) { ?>
                    <tr>
                        <td><?= $autor->id ?></td>
                        <td><?= htmlspecialchars($autor->nombre . ' ' . $autor->apellido) ?></td>
                        <td>
                            <a href="editar-autor.php?id=<?= $autor->id ?>" class="btn btn-warning">Editar</a>
                            <a href="eliminar-autor.php?id=<?= $autor->id ?>" class="btn btn-danger">Eliminar</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

  <!-- Enlaces a jQuery, Bootstrap, DataTables y tu archivo JavaScript personalizado -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+J5U2jzI5F9C0v3Uj5mI7CPGsoU8XCk5Bd5F5eO8f5r5OjqJ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.10/js/jquery.dataTables.js"></script>
    <script src="javascript/efectos-admin.js"></script>
</body>
</html>