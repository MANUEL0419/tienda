<?php
$titulo="Editar Producto | Servitec";
include '../includes/header.php';
include '../includes/navbar.php';

?>
<main class="container py-5">
  <div class="text-center mb-4">
    <h1 class="display-5">ACTAULIZAR PRODUCTO</h1>
    <p class="lead">Gestiona tus productos, ventas y compras fácilmente.</p>
  </div>
</main>

<?php
require_once '../conexion.php';
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$producto = $stmt->get_result()->fetch_assoc();
?>

<h2>Editar producto</h2>
<form action="actualizar_producto.php" method="POST">
    <input type="hidden" name="id" value="<?= $producto['id'] ?>">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" value="<?= $producto['nombre'] ?>" required><br><br>

    <label>Descripción:</label><br>
    <textarea name="descripcion"><?= $producto['descripcion'] ?></textarea><br><br>

    <label>Precio:</label><br>
    <input type="number" step="0.01" name="precio" value="<?= $producto['precio'] ?>" required><br><br>

    <label>Stock:</label><br>
    <input type="number" name="stock" value="<?= $producto['stock'] ?>" required><br><br>

    <button type="submit">Actualizar</button>
</form>
<?php include '../includes/footer.php';?>