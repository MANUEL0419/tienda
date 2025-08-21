
<?php
require_once '../conexion.php';
require_once '../auth.php';
requiereRol('administrador');

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM proveedores WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$prov = $stmt->get_result()->fetch_assoc();
?>

<h2>Editar Proveedor</h2>
<form action="actualizar_proveedor.php" method="POST">
    <input type="hidden" name="id" value="<?= $prov['id'] ?>">
    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?= $prov['nombre'] ?>" required><br><br>
    <label>Teléfono:</label>
    <input type="text" name="telefono" value="<?= $prov['telefono'] ?>"><br><br>
    <label>Email:</label>
    <input type="email" name="email" value="<?= $prov['email'] ?>"><br><br>
    <button type="submit">Actualizar</button>
    <a href="lista_proveedores.php">Cancelar</a>
</form>
