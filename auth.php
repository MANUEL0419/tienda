<?php
session_start();
// Verificar si la variable de sesión que indica que el usuario ha iniciado sesión NO existe
if (!isset($_SESSION['usuario_id'])) {
    // Redirigir al usuario a la página de inicio de sesión
    header("Location: ../login.php");
    exit(); // Asegúrate de detener la ejecución del script después de la redirección
}

function requiereRol($rol_requerido) {
    //session_start();
    if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== $rol_requerido) {
        header("Location: ../login.php?error=acceso_denegado");
        exit;
    }
}