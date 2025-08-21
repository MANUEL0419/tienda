<?php
require_once '../conexion.php';

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];

$sql = "INSERT INTO productos (nombre, descripcion, precio, stock) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $stock);

if ($stmt->execute()) {
    echo "Producto guardado correctamente.<br><a href='lista_productos.php'>Ver productos</a>";
} else {
    echo "Error: " . $stmt->error;
}
?>