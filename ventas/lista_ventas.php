<?php
require_once '../conexion.php';

$titulo = "Ventas | Servitec";
include '../includes/header.php';
include '../includes/navbar.php';

?>



<main class="container py-5">
  <div class="text-center mb-4">
    <h1 class="display-5">LISTADO DE VENTAS</h1>
    <p class="lead">Gestiona tus productos, ventas y compras fácilmente.</p>
  </div>
</main>

<?php

session_start();    


// Verificar si la variable de sesión que indica que el usuario ha iniciado sesión NO existe
if (!isset($_SESSION['usuario_id'])) {
    // Redirigir al usuario a la página de inicio de sesión
    header("Location: ../login.php");
    exit(); // Asegúrate de detener la ejecución del script después de la redirección
}

$sql = "
    SELECT v.id, v.total, v.fecha, u.nombre AS vendedor
    FROM ventas v
    JOIN usuarios u ON v.usuario_id = u.id
    ORDER BY v.fecha DESC
";

$resultado = $conn->query($sql);
?>

<div class="container-lg">
  <!-- Botón para agregar nueva venta -->
  <div class="mb-3">
    <a href="registrar_venta.php" class="btn btn-primary">Registrar nueva venta</a>
  </div>

<!--tabla de ventas -->

<div class="table-responsive">
    <table class="table table-striper table-hover">
        <tr>
            <th>ID Venta</th><th>Fecha</th><th>Vendedor</th><th>Total</th><th>Acciones</th>
        </tr>
        <?php while ($venta = $resultado->fetch_assoc()): ?>
        <tr>
            <td><?= $venta['id'] ?></td>
            <td><?= $venta['fecha'] ?></td>
            <td><?= $venta['vendedor'] ?></td>
            <td>$<?= number_format($venta['total'], 2) ?></td>
            <td>
                <a href="detalle_venta.php?id=<?= $venta['id'] ?>" class="btn btn-sm btn-outline-info">Ver Detalle</a>
            
            
                <?php if ($_SESSION['rol'] === 'administrador'): ?> 
          
                <a href="editar_venta.php?id=<?= $venta['id'] ?>" class="btn btn-sm btn-outline-warning">Editar</a> 
           
           
                <a href="eliminar_venta.php?id=<?= $venta['id'] ?>" onclick="return confirm('¿Eliminar esta venta?')" class="btn btn-sm btn-outline-danger">Eliminar</a>
            </td>
                    <?php endif; ?>
            
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</div>
<br>
<a href="registrar_venta.php">Registrar nueva venta</a>

<?php include '../includes/footer.php'; ?>