<?php
require_once 'conexion.php';

$usuario = 'manuel'; // cámbialo por un usuario que exista en la tabla
$sql = "SELECT contraseña FROM usuarios WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($row = $resultado->fetch_assoc()) {
    echo "Hash en BD: " . $row['contraseña'] . "<br>";

    $clavePrueba = '1234'; // la que usas para iniciar sesión
    var_dump(password_verify($clavePrueba, $row['contraseña']));
} else {
    echo "Usuario no encontrado";
}
?>