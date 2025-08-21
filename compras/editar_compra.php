<?php
require_once '../conexion.php';
require_once '../auth.php';
requiereRol('administrador');
$titulo='Editar Compra | Servitec';
include '../includes/header.php';
include '../includes/navbar.php';

?>

<main class="container py-5">
  <div class="text-center mb-4">
    <h1 class="display-5">ACTUALIZAR COMPRAS</h1>
    <p class="lead">Gestiona tus productos, ventas y compras fácilmente.</p>
  </div>
</main>

<?php
$id = $_GET['id'];

// Obtener info de la compra
$stmt = $conn->prepare("SELECT * FROM compras WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$compra = $stmt->get_result()->fetch_assoc();

// Obtener proveedores
$proveedores = $conn->query("SELECT id, nombre FROM proveedores");

// Obtener productos de la compra
$sql = "
    SELECT d.id AS detalle_id, d.producto_id, d.cantidad, d.precio_unitario, p.nombre
    FROM detalle_compras d
    JOIN productos p ON d.producto_id = p.id
    WHERE d.compra_id = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$detalles = $stmt->get_result();
?>

<h2>Editar Compra #<?= $id ?></h2>
<form action="actualizar_compra.php" method="POST">
    <input type="hidden" name="compra_id" value="<?= $id ?>">

    <label>Fecha:</label>
    <input type="date" name="fecha" value="<?= $compra['fecha'] ?>" required><br><br>

    <label>Proveedor:</label>
    <select name="proveedor_id" required>
        <option value="">-- Seleccione --</option>
        <?php while ($prov = $proveedores->fetch_assoc()): ?>
            <option value="<?= $prov['id'] ?>" <?= $prov['id'] == $compra['proveedor_id'] ? 'selected' : '' ?>>
                <?= $prov['nombre'] ?>
            </option>
        <?php endwhile; ?>
    </select><br><br>

    <h4>Productos</h4>
    <table border="1">
        <tr>
            <th>Producto</th><th>Cantidad</th><th>Precio Unitario</th>
        </tr>
        <?php while ($detalle = $detalles->fetch_assoc()): ?>
            <input type="hidden" name="detalle_id[]" value="<?= $detalle['detalle_id'] ?>">
            <tr>
                <td><?= $detalle['nombre'] ?></td>
                <td><input type="number" name="cantidad[]" value="<?= $detalle['cantidad'] ?>" required></td>
                <td><input type="number" step="0.01" name="precio[]" value="<?= $detalle['precio_unitario'] ?>" required></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <br>
    <button type="submit">Actualizar Todo</button>
    <a href="lista_compras.php">Cancelar</a>
</form>

<?php include '../includes/footer.php';?>