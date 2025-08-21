<?php
require_once 'conexion.php';

$nombre = $_POST['nombre'];
$usuario = $_POST['usuario'];
$contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
$rol = $_POST['rol'];

$sql = "INSERT INTO usuarios (nombre, usuario, contrasena, rol) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nombre, $usuario, $contrasena, $rol);

if ($stmt->execute()) {
    echo "Usuario registrado correctamente.<br><a href='login.php'>Ir al login</a>";
} else {
    echo "Error: " . $stmt->error;
}
?>