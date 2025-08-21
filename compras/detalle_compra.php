<?php
session_start();
require_once '../conexion.php';

$titulo="Detalle Compra | Servitec";
include '../includes/header.php';
include '../includes/navbar.php';

?>

<main class="container py-5">
  <div class="text-center mb-4">
    <h1 class="display-5">DETALLE DE COMPRA</h1>
    <p class="lead">Gestiona tus productos, ventas y compras fácilmente.</p>
  </div>
</main>

<?php

$compra_id = $_GET['id'] ?? 0;

// Cabecera de la compra
$sql = "
    SELECT c.id, c.fecha, c.total, u.nombre AS usuario
    FROM compras c
    JOIN usuarios u ON c.usuario_id = u.id
    WHERE c.id = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $compra_id);
$stmt->execute();
$compra = $stmt->get_result()->fetch_assoc();

if (!$compra) {
    echo "Compra no encontrada.";
    exit;
}

// Detalles de productos comprados
$sql = "
    SELECT p.nombre, dc.cantidad, dc.precio_unitario, (dc.cantidad * dc.precio_unitario) AS subtotal
    FROM detalle_compras dc
    JOIN productos p ON dc.producto_id = p.id
    WHERE dc.compra_id = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $compra_id);
$stmt->execute();
$detalles = $stmt->get_result();
?>

<h2>Detalle de la Compra #<?= $compra['id'] ?></h2>
<p><strong>Fecha:</strong> <?= $compra['fecha'] ?></p>
<p><strong>Registrada por:</strong> <?= $compra['usuario'] ?></p>
<p><strong>Total:</strong> $<?= number_format($compra['total'], 2) ?></p>

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

<a href="detalle_compra.php?id=<?= $compra['id'] ?>">Ver</a>

<?php if ($_SESSION['rol'] === 'administrador'): ?>
    | <a href="eliminar_compra.php?id=<?= $compra['id'] ?>" onclick="return confirm('¿Estás seguro de eliminar esta compra?');">Eliminar</a>
<?php endif; ?>

<br>
<a href="lista_compras.php">← Volver al listado de compras</a>