<?php
session_start();
// Incluir el script de log
include 'log_accesos.php';
// Cambia estos datos por los de tu base de datos
$host = 'localhost'; // o el nombre del servidor
$db = 'rina';
$user = 'root'; // tu usuario de base de datos
$pass = ''; // tu contraseña de base de datos

// Crear conexión
$conn = new mysqli($host, $user, $pass, $db);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    // Validación básica
    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error_message = "Todos los campos son obligatorios.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Las contraseñas no coinciden.";
    } else {
        // Verificar si el usuario ya existe
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = "El nombre de usuario ya está en uso.";
        } else {
            // Registrar nuevo usuario
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashed_password);

            if ($stmt->execute()) {
                $_SESSION["registered"] = true;
                header("Location: login.php");
                exit;
            } else {
                $error_message = "Error al registrar el usuario. Intenta de nuevo.";
            }
        }
        $stmt->close();
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - Rina</title>
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body class="d-flex flex-column h-100">
    <main class="flex-shrink-0">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
            <div class="container px-5">
                <a class="navbar-brand" href="index.php"><span class="fw-bolder text-primary">Rina</span></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 small fw-bolder">
                        <li class="nav-item"><a class="nav-link" href="index.php">Hasiera</a></li>
                        <li class="nav-item"><a class="nav-link" href="produktuak.php">Produktuak</a></li>
                        <li class="nav-item"><a class="nav-link" href="projects.html">Projects</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.php">Harremana</a></li>
                        <?php if (isset($_SESSION['user'])): ?>
                            <li class="nav-item"><a class="nav-link" href="logout.php">Irten</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link" href="login.php">Saioa hasi</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header -->
        <header class="py-5">
            <div class="container px-5 pb-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-xxl-5">
                        <div class="text-center text-xxl-start">
                            <h1 class="display-4 fw-bolder text-primary">Regístrate</h1>
                            <p class="lead fw-normal text-muted mb-4">Crea tu cuenta para comenzar a crecer con nosotros.</p>
                        </div>
                    </div>
                    <div class="col-xxl-7">
                        <form method="POST" action="" class="form-control p-4 shadow-lg rounded">
                            <?php if (!empty($error_message)): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $error_message; ?>
                                </div>
                            <?php endif; ?>
                            <div class="mb-3">
                                <label for="username" class="form-label">Nombre de usuario</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirmar contraseña</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Registrarse</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>
    </main>
    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <span class="text-muted">© 2024 Rina. Todos los derechos reservados.</span>
            <div class="text-muted small">
                <a href="index.php">Home</a> | 
                <a href="produktuak.php">Products</a> | 
                <a href="contact.php">Contact</a>
            </div>
            <div class="text-muted small">
                <a href="https://facebook.com">Facebook</a> | 
                <a href="https://twitter.com">Twitter</a> | 
                <a href="https://instagram.com">Instagram</a>
            </div>
        </div>
    </footer>
</body>
</html>
