<?php
require_once '../conexion.php';
require_once '../auth.php';
requiereRol('administrador');

$venta_id = $_POST['venta_id'];
$fecha = $_POST['fecha'];

$total = 0;
for ($i = 0; $i < count($_POST['detalle_id']); $i++) {
    $detalle_id = $_POST['detalle_id'][$i];
    $cantidad = $_POST['cantidad'][$i];
    $precio = $_POST['precio'][$i];
    $subtotal = $cantidad * $precio;
    $total += $subtotal;

    // 1. Obtener datos anteriores
    $stmt = $conn->prepare("SELECT cantidad, producto_id FROM detalle_ventas WHERE id = ?");
    $stmt->bind_param("i", $detalle_id);
    $stmt->execute();
    $anterior = $stmt->get_result()->fetch_assoc();
    $cantidad_anterior = $anterior['cantidad'];
    $producto_id = $anterior['producto_id'];

    // 2. Revertir el stock anterior
    $stmt = $conn->prepare("UPDATE productos SET stock = stock + ? WHERE id = ?");
    $stmt->bind_param("ii", $cantidad_anterior, $producto_id);
    $stmt->execute();

    // 3. Aplicar nuevo descuento de stock
    $stmt = $conn->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
    $stmt->bind_param("ii", $cantidad, $producto_id);
    $stmt->execute();

    // Actualizar la tabla de ventas
    $stmt = $conn->prepare("UPDATE detalle_ventas SET cantidad = ?, precio_unitario = ? WHERE id = ?");
    $stmt->bind_param("idi", $cantidad, $precio, $detalle_id);
    $stmt->execute();

    // actualizar también la tabla de ventas
    $stmt = $conn->prepare("UPDATE ventas SET fecha = ?, total = ? WHERE id = ?");
    $stmt->bind_param("sdi", $fecha, $total, $venta_id);
    $stmt->execute();


    header("location: lista_ventas.php");
}