<?php

require_once '../conexion.php';

require_once '../auth.php';
requiereRol('administrador'); 

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

$productos = $conn->query("SELECT * FROM productos");

// Obtener lista de proveedores
$proveedores = $conn->query("SELECT id, nombre FROM proveedores");
?>

<h2>Registrar Compra</h2>

<form action="guardar_compra.php" method="POST">
    <table border="1">
        <tr>
            <th>Producto</th><th>Precio Compra</th><th>Cantidad</th>
        </tr>
        <?php while($prod = $productos->fetch_assoc()): ?>
        <tr>
            <td><?= $prod['nombre'] ?></td>
            <td><input type="number" step="0.01" name="precio[<?= $prod['id'] ?>]" value="0.00"></td>
            <td><input type="number" name="cantidad[<?= $prod['id'] ?>]" value="0" min="0"></td>
            
        </tr>

        <?php endwhile; ?>
    </table>

    <!-- campo proveedores -->
     <br>
    <label>Proveedor:</label>
<select name="proveedor_id" required>
    <option value="">-- Seleccione --</option>
    <?php while ($prov = $proveedores->fetch_assoc()): ?>
        <option value="<?= $prov['id'] ?>"><?= $prov['nombre'] ?></option>
    <?php endwhile; ?>
</select><br><br>

<!--  FIN campo proveedores -->


    <br><button type="submit">Registrar Compra</button>
</form>

<br><a href="../productos/lista_productos.php">Volver a productos</a>