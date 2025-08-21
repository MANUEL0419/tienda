<?php
require_once 'conexion.php';

// Datos del nuevo usuario
$usuario = "admin"; // Cambia por el nombre de usuario que quieras
$nombre = "admin"; // Nombre completo
$rol = "administrador"; // Puede ser "administrador" o "vendedor"
$contrasena_plana = "1234"; // Cambia por la contraseña que quieras

// Generar el hash seguro
$hash = password_hash($contrasena_plana, PASSWORD_DEFAULT);

// Insertar en la base de datos
$sql = "INSERT INTO usuarios (usuario, nombre, rol, 'contraseña') VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $usuario, $nombre, $rol, $hash);

if ($stmt->execute()) {
    echo "✅ Usuario creado correctamente<br>";
    echo "Usuario: $usuario<br>";
    echo "Contraseña: $contrasena_plana<br>";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
