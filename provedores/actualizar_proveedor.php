<?php
require_once '../conexion.php';
require_once '../auth.php';


$id = $_POST['id'];
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];

$stmt = $conn->prepare("UPDATE proveedores SET nombre = ?, telefono = ?, email = ? WHERE id = ?");
$stmt->bind_param("sssi", $nombre, $telefono, $email, $id);
$stmt->execute();

header("Location: lista_proveedores.php?mensaje=Proveedor_actualizado");

// agrego un comentario de prueba para ver cambios en git con el comando git diff --name-only HEAD~1 HEAD
?>
