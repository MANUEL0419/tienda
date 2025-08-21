<?php session_start();
require_once '../conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$precios = $_POST['precio'];
$cantidades = $_POST['cantidad'];
$proveedor =$_POST['proveedor_id'];

$detalle = [];
$total = 0;

foreach ($cantidades as $id => $cantidad) {
    $cantidad = intval($cantidad);
    $precio = floatval($precios[$id]);

    if ($cantidad > 0 && $precio > 0) {
        $subtotal = $cantidad * $precio;
        $detalle[] = [
            'producto_id' => $id,
            'cantidad' => $cantidad,
            'precio_unitario' => $precio,
            'proveedor_id' => $proveedor
        ];
        $total += $subtotal;
    }
}

if (empty($detalle)) {
    echo "No se ingresaron productos válidos para la compra.";
    exit;
}

// Registrar compra
$stmt = $conn->prepare("INSERT INTO compras (usuario_id, total,proveedor_id) VALUES (?, ?, ?)");
$stmt->bind_param("ids", $usuario_id, $total, $proveedor);
$stmt->execute();
$compra_id = $stmt->insert_id;

// Insertar detalles y actualizar stock
foreach ($detalle as $item) {
    // detalle compra
    $stmt = $conn->prepare("INSERT INTO detalle_compras (compra_id, producto_id, cantidad, precio_unitario,proveedor_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiids", $compra_id, $item['producto_id'], $item['cantidad'], $item['precio_unitario'], $item['proveedor_id']);
    $stmt->execute();

    // actualizar stock
    $stmt = $conn->prepare("UPDATE productos SET stock = stock + ? WHERE id = ?");
    $stmt->bind_param("ii", $item['cantidad'], $item['producto_id']);
    $stmt->execute();
}

echo "Compra registrada correctamente.<br><a href='registrar_compra.php'>Registrar otra compra</a>";