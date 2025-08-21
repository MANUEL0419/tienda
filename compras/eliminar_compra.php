<?php
//session_start();
require_once '../conexion.php';

require_once '../auth.php';
requiereRol('administrador'); // Solo admins pueden eliminar 


// Verificar si se recibió un ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: lista_compras.php?error=ID inválido");
    exit;
}

$id = intval($_GET['id']);

// Eliminar detalles de la compra (si tienes tabla detalles_compra)
$conn->query("DELETE FROM detalle_compras WHERE compra_id = $id");

// Eliminar la compra principal
$conn->query("DELETE FROM compras WHERE id = $id");

header("Location: lista_compras.php?mensaje=Compra eliminada");
exit;