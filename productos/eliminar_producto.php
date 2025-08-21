<?php
require_once '../conexion.php';
$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: lista_productos.php");
?>