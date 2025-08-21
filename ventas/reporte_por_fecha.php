<?php
require_once '../conexion.php';
require_once '../auth.php';
$titulo = "Reporte | Servitec";
include '../includes/header.php';
include '../includes/navbar.php';

?>
<main class="container py-5">
  <div class="text-center mb-4">
    <h1 class="display-5">LISTADO DE VENTAS</h1>
    <p class="lead">Gestiona tus productos, ventas y compras fácilmente.</p>
  </div>
</main>



<?php 


//requiereLogin();

$desde = $_GET['desde'] ?? date('Y-m-01');
$hasta = $_GET['hasta'] ?? date('Y-m-d');

$stmt = $conn->prepare("SELECT v.*, u.nombre AS vendedor 
                        FROM ventas v 
                        JOIN usuarios u ON v.usuario_id = u.id 
                        WHERE v.fecha BETWEEN ? AND ?");
$stmt->bind_param("ss", $desde, $hasta);
$stmt->execute();
$resultado = $stmt->get_result();
?>
<div class="container-lg">

    <form method="GET">
        Desde: <input type="date" name="desde" value="<?= $desde ?>">
        Hasta: <input type="date" name="hasta" value="<?= $hasta ?>">
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <div class="table-responsive mt-5">
        <table class="table table-striper table-hover ">
            <tr>
                <th>ID</th><th>Fecha</th><th>Total</th><th>Vendedor</th>
            </tr>
            <?php
            $total_general = 0;

            while($row = $resultado->fetch_assoc()): 
            
                $total_general=$total_general+$row['total'];
            ?>    
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['fecha'] ?></td>
                    <td>$<?= number_format($row['total'], 2) ?></td>
                    <td><?= $row['vendedor'] ?></td>
                </tr>
            
            <?php endwhile; ?>
            <tr>
                    <td colspan="2"><strong>Total General</strong></td>
                    <td><strong>$<?= number_format($total_general, 2) ?></strong></td>
                    <td></td>
            </tr>


        </table>
    </div>

    <br>
    <!-- boton imprimir -->
    <form method="GET" action="reporte_fecha_pdf.php" target="_blank">
        <input type="hidden" name="desde" value="<?= $desde ?>">
        <input type="hidden" name="hasta" value="<?= $hasta ?>">
        <button type="submit" class="btn btn-primary">Imprimir PDF</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>