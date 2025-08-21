<?php
//require '../tienda/conexion.php';
require __DIR__ . '/conexion.php';

//require '../tienda/auth.php' ;
//session_start();
$titulo = "Iniciar Sesión | Servitec";
include 'includes/header.php';
?>
<div class="container">
    <div class="miizquerda">
        <div class=" d-flex justify-content-center align-items-center vh-100 bg-light">
        <div class="card shadow-sm" style="min-width: 350px; max-width: 420px; width: 100%;">
            <div class="card-body p-4">
            <h2 class="card-title text-center mb-4 text-primary">Iniciar Sesión</h2>

            <form action="verificar_login.php" method="POST" novalidate>
                <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" id="usuario" name="usuario" class="form-control" required autofocus>
                </div>

                <div class="mb-3">
                <label for="clave" class="form-label">Contraseña</label>
                <input type="password" id="clave" name="contraseña" class="form-control" required>
                </div>

                <div class="d-grid">
                <button type="submit" class="btn btn-primary">Ingresar</button>
                </div>
            </form>
            </div>
        </div>
        </div>
    </div>
</div>
<div class="footer">
    <?php include 'includes/footer.php'; ?>

</div>
