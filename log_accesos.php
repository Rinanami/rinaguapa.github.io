<?php
// log_accesos.php

// Iniciar la sesión solo si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Obtener la IP del usuario
$user_ip = $_SERVER['REMOTE_ADDR'];

// Obtener la fecha y hora actuales
$access_time = date('Y-m-d H:i:s');

// Obtener el nombre de usuario si está logueado (en este ejemplo se usa una variable de sesión)
$user = isset($_SESSION['username']) ? $_SESSION['username'] : 'Anónimo';

// Obtener la ubicación usando una API
$location_data = file_get_contents("https://ipinfo.io/$user_ip/json");
$location_info = json_decode($location_data, true);
$location = isset($location_info['city']) ? $location_info['city'] : 'Desconocida';

// Formatear la línea para el log
$log_message = "Usuario: $user | IP: $user_ip | Ubicación: $location | Fecha y hora: $access_time" . PHP_EOL;

// Escribir el log en un archivo
file_put_contents('access_log.txt', $log_message, FILE_APPEND);
?>
