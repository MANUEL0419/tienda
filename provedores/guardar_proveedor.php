<?php
require_once '../conexion.php';

$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$direccion = $_POST['direccion'];

$stmt = $conn->prepare("INSERT INTO proveedores (nombre, telefono, email, direccion) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nombre, $telefono, $email, $direccion);
$stmt->execute();

header("Location: lista_proveedores.php");