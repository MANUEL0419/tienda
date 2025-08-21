<?php
session_start(); // Asegúrate de que la sesión esté iniciada
?>

<style>
nav {
    background-color: #f2f2f2;
    padding: 10px;
}
nav a {
    margin-right: 15px;
    text-decoration: none;
    color: #333;
    font-weight: bold;
}
</style>

<nav>
    <a href="/tienda/productos/lista_productos.php">Productos</a>
    <a href="/tienda/ventas/lista_ventas.php">Ventas</a>
    <a href="/tienda/ventas/registrar_venta.php">Registrar Venta</a>

    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'administrador'): ?>
        <a href="/tienda/compras/lista_compras.php">Compras</a>
        <a href="/tienda/compras/registrar_compra.php">Registrar Compra</a>
    <?php endif; ?>

    <span style="float:right;">
        <?= $_SESSION['usuario_nombre'] ?? 'Invitado' ?> |
        <a href="/tienda/logout.php">Cerrar sesión</a>
    </span>
</nav>