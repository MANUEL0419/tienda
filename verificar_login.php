<?php
session_start();
require_once 'conexion.php';

$usuario = $_POST['usuario'];
$contrasena = $_POST['contraseña'];

$sql = "SELECT * FROM usuarios WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 1) {
    $usuario_data = $resultado->fetch_assoc();

    if (password_verify($contrasena, $usuario_data['contrasena'])) {
        $_SESSION['usuario_id'] = $usuario_data['id'];
        $_SESSION['rol'] = $usuario_data['rol'];
        $_SESSION['nombre'] = $usuario_data['nombre'];

        if ($usuario_data['rol'] == 'administrador') {
            header("Location:/index.php");
        } else {
            header("Location:/index.php");
        }
        exit;
    }
}


?>
<script>

    alert("Usuario o contraseña incorrectos.");
    window.location.href=('/login.php');
</script>