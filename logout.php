<?php
// Incluir el script de log
include 'log_accesos.php';
session_start();
session_destroy(); // Destruye la sesión
header("Location: login.php"); // Redirige a la página de inicio de sesión
exit;
?>
