
<?php 
$titulo='Registrar Productos | Servitec';
include '../includes/header.php';
include '../includes/navbar.php';
?>

<main class="container py-5">
  <div class="text-center mb-4">
    <h1 class="display-5">REGISTRAR NUEVO PRODUCTO</h1>
    <p class="lead">Gestiona tus productos, ventas y compras fácilmente.</p>
  </div>
</main>


<body>
    <h2>Registrar nuevo producto</h2>
    <form action="guardar_producto.php" method="POST">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion"></textarea><br><br>

        <label>Precio:</label><br>
        <input type="number" step="0.01" name="precio" required><br><br>

        <label>Stock:</label><br>
        <input type="number" name="stock" required><br><br>

        <button type="submit">Guardar</button>
    </form>
    <br>
    <a href="lista_productos.php">Ver productos</a>

    <?php include '../includes/footer.php'; ?>
