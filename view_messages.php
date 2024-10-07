<?php
// Incluir el script de log
include 'log_accesos.php';
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

// Consultar los registros de la tabla contacto
$sql = "SELECT id, nombre, email, telefono, mensaje FROM contacto";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes Recibidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <main class="flex-shrink-0">
        <section class="py-5">
            <div class="container px-5">
                <div class="bg-light rounded-4 py-5 px-4 px-md-5">
                    <div class="text-center mb-5">
                        <h1 class="fw-bolder">Mensajes Recibidos</h1>
                    </div>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Mensaje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                // Mostrar los datos de cada fila
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["id"] . "</td>";
                                    echo "<td>" . $row["nombre"] . "</td>";
                                    echo "<td>" . $row["email"] . "</td>";
                                    echo "<td>" . $row["telefono"] . "</td>";
                                    echo "<td>" . $row["mensaje"] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center'>No hay mensajes</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="d-grid">
                        <a href="contact.php" class="btn btn-primary btn-lg">Volver</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
