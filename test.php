<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'conexion.php';

$usuario = 'manuel'; // pon un usuario real de tu tabla
$sql = "SELECT 'contraseña' FROM usuarios WHERE usuario = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error en prepare: " . $conn->error);
}

$stmt->bind_param("s", $usuario);

if (!$stmt->execute()) {
    die("Error en execute: " . $stmt->error);
}

$resultado = $stmt->get_result();

if ($row = $resultado->fetch_assoc()) {
    echo "Hash en BD: " . $row['contraseña'] . "<br>";

    $clavePrueba = '1234'; // la contraseña que usas al iniciar sesión
    var_dump(password_verify($clavePrueba, $row['contraseña']));
} else {
    echo "Usuario no encontrado";
}