<?php
require_once '../conexion.php';
require_once '../auth.php';
require_once '../vendor/autoload.php'; // O libs/dompdf/autoload.inc.php si no usas Composer

use Dompdf\Dompdf;

$desde = $_GET['desde'] ?? date('Y-m-01');
$hasta = $_GET['hasta'] ?? date('Y-m-d');

// Consultar ventas
$stmt = $conn->prepare("SELECT v.*, u.nombre AS vendedor 
                        FROM ventas v 
                        JOIN usuarios u ON v.usuario_id = u.id 
                        WHERE v.fecha BETWEEN ? AND ?");
$stmt->bind_param("ss", $desde, $hasta);
$stmt->execute();
$resultado = $stmt->get_result();

// Crear HTML
$html = "<h2>Reporte de Ventas ($desde a $hasta)</h2>";
$html .= "<table border='1' width='100%' cellpadding='5' cellspacing='0'>";
$html .= "<tr><th>ID</th><th>Fecha</th><th>Total</th><th>Vendedor</th></tr>";

$total_general = 0;
while ($row = $resultado->fetch_assoc()) {
    $html .= "<tr>
                <td>{$row['id']}</td>
                <td>{$row['fecha']}</td>
                <td>$" . number_format($row['total'], 2) . "</td>
                <td>{$row['vendedor']}</td>
              </tr>";
    $total_general += $row['total'];
}

$html .= "<tr>
            <td colspan='2'><strong>Total General</strong></td>
            <td><strong>$" . number_format($total_general, 2) . "</strong></td>
            <td></td>
          </tr>";
$html .= "</table>";

// Generar PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("reporte_ventas_$desde-$hasta.pdf", ["Attachment" => false]);
exit;