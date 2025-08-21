<?php
/*$host = "localhost";
$db = "tienda";
$user = "root";
$pass = ""; */

$host = "sql307.infinityfree.com";
$db = "if0_39707602_tienda";
$user = "if0_39707602";
$pass = "OSZXaBQIK3Y";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>