<?php
session_start();
require_once '../conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$productos = $_POST['cantidad'];

$total = 0;
$detalle = [];

// Recorremos los productos seleccionados
foreach ($productos as $id => $cant) {
    $cant = intval($cant);
    if ($cant > 0) {
        $stmt = $conn->prepare("SELECT precio, stock FROM productos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();

        if ($cant <= $res['stock']) {
            $precio_unitario = $res['precio'];
            $subtotal = $cant * $precio_unitario;
            $total += $subtotal;
            $detalle[] = [
                'producto_id' => $id,
                'cantidad' => $cant,
                'precio_unitario' => $precio_unitario
            ];
        } else {
            echo "Cantidad solicitada supera el stock disponible para el producto ID $id.";
            exit;
        }
    }
}

if (empty($detalle)) {
    echo "No se seleccionaron productos válidos.";
    exit;
}

// Registrar la venta
$stmt = $conn->prepare("INSERT INTO ventas (usuario_id, total) VALUES (?, ?)");
$stmt->bind_param("id", $usuario_id, $total);
$stmt->execute();
$venta_id = $stmt->insert_id;

// Insertar detalles y actualizar stock
foreach ($detalle as $item) {
    $stmt = $conn->prepare("INSERT INTO detalle_ventas (venta_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $venta_id, $item['producto_id'], $item['cantidad'], $item['precio_unitario']);
    $stmt->execute();

    // Actualizar stock
    $stmt = $conn->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
    $stmt->bind_param("ii", $item['cantidad'], $item['producto_id']);
    $stmt->execute();
}
?>
<script>
alert('Venta registrada Exitosamente!');
window.location.href=('../ventas/registrar_venta.php');
</script>


