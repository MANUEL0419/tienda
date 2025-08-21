<?php
require_once '../conexion.php';
require_once '../auth.php';
$titulo="Editar Venta | Servitec";
include '../includes/header.php';
include '../includes/navbar.php';

requiereRol('administrador');

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM ventas WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$venta = $stmt->get_result()->fetch_assoc();

$detalles = $conn->prepare("
    SELECT dv.id as detalle_id, dv.producto_id, dv.cantidad, dv.precio_unitario, p.nombre
    FROM detalle_ventas dv
    JOIN productos p ON dv.producto_id = p.id
    WHERE dv.venta_id = ?
");
$detalles->bind_param("i", $id);
$detalles->execute();
$detalles_result = $detalles->get_result();
?>

<h2>Editar Venta #<?= $id ?></h2>
<form action="actualizar_venta.php" method="POST">
    <input type="hidden" name="venta_id" value="<?= $id ?>">
    <label>Fecha:</label>
    <input type="datetime-local" name="fecha" value="<?= $venta['fecha'] ?>" required><br><br>

    <h4>Productos</h4>
    <table border="1">
        <tr>
            <th>Producto</th><th>Cantidad</th><th>Precio</th>
        </tr>
        <?php while ($det = $detalles_result->fetch_assoc()): ?>
            <input type="hidden" name="detalle_id[]" value="<?= $det['detalle_id'] ?>">
            <tr>
                <td><?= $det['nombre'] ?></td>
                <td><input type="number" name="cantidad[]" value="<?= $det['cantidad'] ?>" required></td>
                <td><input type="number" step="0.01" name="precio[]" value="<?= $det['precio_unitario'] ?>" required></td>
            </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <button type="submit">Actualizar</button>
</form>
<?php include '../includes/footer.php'; ?>