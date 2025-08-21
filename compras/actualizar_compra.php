<?php
require_once '../conexion.php';
require_once '../auth.php';
requiereRol('administrador');

$compra_id = $_POST['compra_id'];
$fecha = $_POST['fecha'];
$proveedor_id = $_POST['proveedor_id'];

$detalle_ids = $_POST['detalle_id'];
$cantidades = $_POST['cantidad'];
$precios = $_POST['precio'];

$total = 0;

// Actualizar detalles
for ($i = 0; $i < count($detalle_ids); $i++) {
    $detalle_id = $detalle_ids[$i];
    $cantidad = $cantidades[$i];
    $precio = $precios[$i];
    $subtotal = $cantidad * $precio;
    $total += $subtotal;

    $stmt = $conn->prepare("UPDATE detalle_compras SET cantidad = ?, precio_unitario = ? WHERE id = ?");
    $stmt->bind_param("idd", $cantidad, $precio, $detalle_id);
    $stmt->execute();
}

// Actualizar compra
$stmt = $conn->prepare("UPDATE compras SET fecha = ?, proveedor_id = ?, total = ? WHERE id = ?");
$stmt->bind_param("sidi", $fecha, $proveedor_id, $total, $compra_id);
$stmt->execute();

header("Location: detalle_compra.php?id=$compra_id&mensaje=Compra actualizada");