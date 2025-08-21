<?php
require_once '../conexion.php';

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];

$sql = "UPDATE productos SET nombre=?, descripcion=?, precio=?, stock=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdii", $nombre, $descripcion, $precio, $stock, $id);

if ($stmt->execute()) {
    header("Location: lista_productos.php");
} else {
    echo "Error: " . $stmt->error;
}
?>