<?php
include '../includes/header.php';
include '../includes/navbar.php';

session_start();    


// Verificar si la variable de sesión que indica que el usuario ha iniciado sesión NO existe
if (!isset($_SESSION['usuario_id'])) {
    // Redirigir al usuario a la página de inicio de sesión
    header("Location: ../login.php");
    exit(); // Asegúrate de detener la ejecución del script después de la redirección
}

?>

<main class="container py-5">
  <div class="text-center mb-4">
    <h1 class="display-5">LISTADO DE PROVEEDORES</h1>
    <p class="lead">Gestiona tus productos, ventas y compras fácilmente.</p>
  </div>
</main>

<?php if (isset($_GET['mensaje'])): ?>
    <div style="color: green"><?= htmlspecialchars($_GET['mensaje']) ?></div>
<?php elseif (isset($_GET['error'])): ?>
    <div style="color: red"><?= htmlspecialchars($_GET['error']) ?></div>
<?php endif; ?>


<?php
require_once '../conexion.php';




$resultado = $conn->query("SELECT * FROM proveedores");
?>

<div class="container-lg">
    <a href="registrar_proveedor.php" class="btn btn-primary">Registrar nuevo proveedor</a><br><br>

    <table class="table-responsive table table-striper table-hover">
        <tr><th>ID</th><th>Nombre</th><th>Teléfono</th><th>Email</th><th>Dirección</th></tr>
        <?php while ($p = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= $p['nombre'] ?></td>
                <td><?= $p['telefono'] ?></td>
                <td><?= $p['email'] ?></td>
                <td><?= $p['direccion'] ?></td>
                

                    <?php if ($_SESSION['rol'] === 'administrador'): ?>
                    <td>
                    <a href="editar_proveedor.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-info">Editar</a> 
                <a href="eliminar_proveedor.php?id=<?= $p['id'] ?>" onclick="return confirm('¿Eliminar este proveedor?')" class="btn btn-sm btn-outline-warning">Eliminar</a>
                    </td>
                    <?php endif; ?>

                
            </tr>
        <?php endwhile; ?>
    </table>
</div>
<?php include '../includes/footer.php'; ?>


