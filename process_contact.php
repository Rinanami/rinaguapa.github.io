<?php
// Conexión a la base de datos
$servername = "localhost";  // Cambia esto si tu servidor es diferente
$username = "root";         // Tu usuario de MySQL
$password = "";             // Tu contraseña de MySQL
$dbname = "rina";  // El nombre de tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del formulario
$nombre = $_POST['name'];
$email = $_POST['email'];
$telefono = $_POST['phone'];
$mensaje = $_POST['message'];

// Preparar la consulta SQL para insertar los datos
$stmt = $conn->prepare("INSERT INTO contacto (nombre, email, telefono, mensaje) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nombre, $email, $telefono, $mensaje);

// Ejecutar la consulta y verificar si fue exitosa
if ($stmt->execute()) {
    echo "Mensaje enviado correctamente.";
} else {
    echo "Error: " . $stmt->error;
}
// Incluir el script de log
include 'log_accesos.php';
// Cerrar la conexión
$stmt->close();
$conn->close();
?>
