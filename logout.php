<?php
session_start();
session_destroy();
header("Location:/tienda/login.php");
exit;
?>