<?php
//session_start();

require_once '../conexion.php';
require_once '../auth.php';

$titulo = "Compras | Servitec";
include '../includes/header.php';
include '../includes/navbar.php';

?>

<main class="container py-5">
  <div class="text-center mb-4">
    <h1 class="display-5">LISTADO DE COMPRAS</h1>
    <p class="lead">Gestiona tus productos, ventas y compras fácilmente.</p>
  </div>
</main>

<?php

$sql = "
    SELECT c.id, c.fecha, c.total, u.nombre AS usuario, p.nombre AS proveedor
    FROM compras c
    JOIN usuarios u ON c.usuario_id = u.id
    LEFT JOIN proveedores p ON c.proveedor_id= p.id
    ORDER BY c.fecha DESC
";

$resultado = $conn->query($sql);
?>

<div class="container-lg">
  <!-- Botón para agregar nueva venta -->
  <div class="mb-3">
    <a href="registrar_compra.php" class="btn btn-primary">Registrar nueva compra</a>
  </div>

<div class="table-responsive">

    <table class="table table-striper table-hover">
        <tr>
            <th>ID</th><th>Fecha</th><th>Usuario</th><th>Total</th><th>Acciones</th>
        </tr>
        <?php while ($compra = $resultado->fetch_assoc()): ?>
        <tr>
            <td><?= $compra['id'] ?></td>
            <td><?= $compra['fecha'] ?></td>
            <td><?= $compra['usuario'] ?></td>
            <td><?= $compra['proveedor'] ?></td>
            
            <td>$<?= number_format($compra['total'], 2) ?></td>
            <td><a href="detalle_compra.php?id=<?= $compra['id'] ?>" class="btn btn-sm btn-outline-info">Ver Detalle</a>
            
            
    <?php if ($_SESSION['rol'] === 'administrador'): ?>
         <a href="eliminar_compra.php?id=<?= $compra['id'] ?>" onclick="return confirm('¿Estás seguro de eliminar esta compra?');" class="btn btn-sm btn-outline-warning">Eliminar</a>
    <?php endif; ?>
            

            
                <?php if ($_SESSION['rol'] === 'administrador'): ?>
         <a href="editar_compra.php?id=<?= $compra['id'] ?>" class="btn btn-sm btn-outline-danger">Editar</a>
    <?php endif; ?>
            </td>
                    
        </tr>
        
        <?php endwhile; ?>
    </table>
</div>
</div>



<br>
<a href="registrar_compra.php">Registrar nueva compra</a>

<?php include '../includes/footer.php'; ?>