<?php
require_once '../conexion.php';
require_once '../auth.php';
include '../includes/header.php';
include '../includes/navbar.php';

$resultado = $conn->query("SELECT * FROM productos");
?>
<main class="container py-5">
  <div class="text-center mb-4">
    <h1 class="display-5">LISTADO DE PRODUCTOS</h1>
    <p class="lead">Gestiona tus productos, ventas y compras fácilmente.</p>
  </div>
</main>


<div class="container-lg">
<a href="registrar_producto.php" class="btn btn-primary">Registrar nuevo producto</a><br><br>
<div class="table-responsive">
    <table class="table table-striper table-hover">
        <tr>
            <th>ID</th><th>Nombre</th><th>Precio</th><th>Stock</th><th>Acciones</th>
        </tr>
        <?php while($producto = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= $producto['id'] ?></td>
                <td><?= $producto['nombre'] ?></td>
                <td><?= $producto['precio'] ?></td>
                <td><?= $producto['stock'] ?></td>
                <td>
                    <a href="editar_producto.php?id=<?= $producto['id'] ?>" class="btn btn-sm btn-outline-info">Editar</a> 
                    <a href="eliminar_producto.php?id=<?= $producto['id'] ?>" onclick="return confirm('¿Eliminar producto?')" class="btn btn-sm btn-outline-warning">Eliminar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
</div>
<?php include '../includes/footer.php'; ?>