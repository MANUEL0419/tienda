<?php
session_start();

// Título de la página
$titulo = "Inicio | Servitec";

// Incluir archivos de cabecera y navegación
// Asumimos que 'includes' está en la misma carpeta que index.php
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/navbar.php';

// Verificar si el usuario NO ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    // Redirigir usando ruta relativa para evitar 404
    header("Location:login.php");
    // header("Location: tienda/login.php");
    exit(); // Detener ejecución después de redirigir
}
?>

<main class="container py-5">
    <div class="text-center mb-4">
        <h1 class="display-5">Bienvenido al Sistema de Tienda</h1>
        <p class="lead">Gestiona tus productos, ventas y compras fácilmente.</p>
    </div>
</main>

<?php
// Incluir pie de página
require __DIR__ . '/includes/footer.php';
?>
