<?php
require_once '../conexion.php';
require_once '../auth.php';
requiereRol('administrador');

$id = $_GET['id'];

// Eliminar detalles primero (por integridad)
$stmt = $conn->prepare("DELETE FROM detalle_ventas WHERE venta_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

// Luego eliminar la venta
$stmt = $conn->prepare("DELETE FROM ventas WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: lista_ventas.php?mensaje=Venta eliminada");