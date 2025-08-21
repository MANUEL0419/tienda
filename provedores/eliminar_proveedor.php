<?php
require_once '../conexion.php';
require_once '../auth.php';
requiereRol('administrador');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: lista_proveedores.php?error=ID inválido");
    exit;
}

$id = intval($_GET['id']);

// Verificar si el proveedor tiene compras asociadas
$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM compras WHERE proveedor_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result()->fetch_assoc();

if ($resultado['total'] > 0) {
    // Bloquear eliminación
    header("Location: lista_proveedores.php?error=No se puede eliminar: hay compras registradas con este proveedor");
    exit;
}

// Si no tiene compras, eliminar
$stmt = $conn->prepare("DELETE FROM proveedores WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: lista_proveedores.php?mensaje=Proveedor eliminado");