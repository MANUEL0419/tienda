<?php
require_once '../conexion.php';
$titulo="Detalle Venta | Servitec";
include '../includes/header.php';
include '../includes/navbar.php';

?>
<main class="container py-5">
  <div class="text-center mb-4">
    <h1 class="display-5">DETALLE DE VENTA</h1>
    <p class="lead">Gestiona tus productos, ventas y compras fácilmente.</p>
  </div>
</main>
<?php

$venta_id = $_GET['id'];

// Obtener cabecera de venta
$sql = "
    SELECT v.id, v.total, v.fecha, u.nombre AS vendedor
    FROM ventas v
    JOIN usuarios u ON v.usuario_id = u.id
    WHERE v.id = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $venta_id);
$stmt->execute();
$venta = $stmt->get_result()->fetch_assoc();

if (!$venta) {
    echo "Venta no encontrada.";
    exit;
}

// Obtener detalles
$sql = "
    SELECT p.nombre, dv.cantidad, dv.precio_unitario, (dv.cantidad * dv.precio_unitario) AS subtotal
    FROM detalle_ventas dv
    JOIN productos p ON dv.producto_id = p.id
    WHERE dv.venta_id = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $venta_id);
$stmt->execute();
$detalles = $stmt->get_result();
?>

<h2>Detalle de la Venta #<?= $venta['id'] ?></h2>
<p><strong>Fecha:</strong> <?= $venta['fecha'] ?></p>
<p><strong>Vendedor:</strong> <?= $venta['vendedor'] ?></p>
<p><strong>Total:</strong> $<?= number_format($venta['total'], 2) ?></p>

<table border="1">
    <tr>
        <th>Producto</th><th>Cantidad</th><th>Precio Unitario</th><th>Subtotal</th>
    </tr>
    <?php while ($d = $detalles->fetch_assoc()): ?>
    <tr>
        <td><?= $d['nombre'] ?></td>
        <td><?= $d['cantidad'] ?></td>
        <td>$<?= number_format($d['precio_unitario'], 2) ?></td>
        <td>$<?= number_format($d['subtotal'], 2) ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<br>
<a href="lista_ventas.php">← Volver a listado de ventas</a>
<?php include '../includes/footer.php'; ?>