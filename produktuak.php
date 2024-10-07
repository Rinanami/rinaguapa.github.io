<?php
session_start(); // Asegúrate de que la sesión esté iniciada
// Incluir el script de log
include 'log_accesos.php';
// Conexión a la base de datos
$servername = "localhost"; // Cambia esto si tu servidor es diferente
$username = "root"; // Tu usuario de MySQL
$password = ""; // Tu contraseña de MySQL
$dbname = "rina"; // El nombre de tu base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar los registros de la tabla de productos
$sql = "SELECT id, izena, prezioa, deskribapena, imagen FROM artikuluak"; // Asegúrate de que 'imagen' sea el nombre de la columna con la ruta de la imagen
$result = $conn->query($sql);

// Manejo de formularios (agregar, actualizar y eliminar productos)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Agregar un nuevo producto
    if (isset($_POST['add_product']) && $_SESSION['user'] === 'rina') {
        $izena = $_POST['izena'];
        $prezioa = $_POST['prezioa'];
        $deskribapena = $_POST['deskribapena'];
        $imagen = $_FILES['imagen']['name'];

        // Verificar si el archivo es una imagen
        $target_file = "uploads/" . basename($imagen);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES['imagen']['tmp_name']);

        if($check !== false && in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            // Mover la imagen a la carpeta uploads
            move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file);

            // Insertar el producto en la base de datos
            $sql = "INSERT INTO artikuluak (izena, prezioa, deskribapena, imagen) VALUES ('$izena', '$prezioa', '$deskribapena', '$target_file')";
            $conn->query($sql);
        } else {
            echo "El archivo no es una imagen o el formato no es permitido.";
        }
    }


    // Actualizar un producto
    if (isset($_POST['update_product']) && $_SESSION['user'] === 'rina') {
        $product_id = $_POST['product_id'];
        $izena = $_POST['izena'];
        $prezioa = $_POST['prezioa'];
        $deskribapena = $_POST['deskribapena'];

        // Comprobar si se subió una nueva imagen
        if (!empty($_FILES['imagen']['name'])) {
            $imagen = $_FILES['imagen']['name'];
            move_uploaded_file($_FILES['imagen']['tmp_name'], "uploads/" . $imagen);
            $sql = "UPDATE artikuluak SET izena='$izena', prezioa='$prezioa', deskribapena='$deskribapena', imagen='uploads/$imagen' WHERE id='$product_id'";
        } else {
            $sql = "UPDATE artikuluak SET izena='$izena', prezioa='$prezioa', deskribapena='$deskribapena' WHERE id='$product_id'";
        }
        $conn->query($sql);
    }

    // Eliminar un producto
    if (isset($_POST['delete_product']) && $_SESSION['user'] === 'rina') {
        $product_id = $_POST['product_id'];
        $sql = "DELETE FROM artikuluak WHERE id='$product_id'";
        $conn->query($sql);
    }
}

// Cerrar sesión
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Rina - Productos</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body class="d-flex flex-column h-100 bg-light">
    <main class="flex-shrink-0">
        <!-- Navigation-->
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
                            <li class="nav-item"><span class="navbar-text">Hola, <?php echo htmlspecialchars($_SESSION['user']); ?>!</span></li>
                            <li class="nav-item"><a class="nav-link" href="logout.php">Irten</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link" href="login.php">Saioa hasi</a></li>
                            <li class="nav-item"><a class="nav-link" href="registro.php">Erregistratu</a></li> <!-- Enlace para registrarse -->
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page Content-->
        <div class="container px-5 my-5">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bolder mb-0"><span class="text-gradient d-inline">Gure Produktuak</span></h1>
            </div>
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-11 col-xl-9 col-xxl-8">
                    <!-- Product Management Section-->
                    <section>
                        <?php if (isset($_SESSION['user']) && $_SESSION['user'] === 'rina'): ?>
                            <button class="btn btn-primary" onclick="document.getElementById('addForm').style.display='block'">Añadir Producto</button>
                            <div id="addForm" style="display: none;">
                                <form action="produktuak.php" method="post" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="izena" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" name="izena" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="prezioa" class="form-label">Precio</label>
                                        <input type="number" class="form-control" name="prezioa" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="deskribapena" class="form-label">Descripción</label>
                                        <textarea class="form-control" name="deskribapena" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="imagen" class="form-label">Imagen</label>
                                        <input type="file" class="form-control" name="imagen" required>
                                    </div>
                                    <button type="submit" class="btn btn-success" name="add_product">Agregar Producto</button>
                                </form>
                            </div>
                        <?php endif; ?>

                        <section>
                            <!-- Mostrar los productos -->
                            <?php if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) { ?>
                                    <div class="card shadow border-0 rounded-4 mb-5">
                                        <div class="card-body p-5">
                                            <div class="row align-items-center gx-5">
                                                <div class="col text-center text-lg-start mb-4 mb-lg-0">
                                                    <img src="<?php echo htmlspecialchars($row['imagen']); ?>" alt="" style="max-width: 200px; height: auto; border-radius: 20px; border: 2px dotted #f3c2be;">
                                                </div>
                                                <div class="col-lg-8">
                                                    <div>
                                                        <p><h3><?php echo htmlspecialchars($row['izena']); ?></h3></p>
                                                        <p><?php echo htmlspecialchars($row['prezioa']); ?> €</p>
                                                        <p><?php echo htmlspecialchars($row['deskribapena']); ?></p>
                                                    </div>
                                                    <?php if (isset($_SESSION['user']) && $_SESSION['user'] === 'rina'): ?>
                                                        <form action="produktuak.php" method="post" class="d-inline">
                                                            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                                            <button type="submit" class="btn btn-warning" name="update_product">Modificar</button>
                                                        </form>
                                                        <form action="produktuak.php" method="post" class="d-inline">
                                                            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                                            <button type="submit" class="btn btn-danger" name="delete_product">Eliminar</button>
                                                        </form>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            } else {
                                echo "<p>No hay productos disponibles.</p>";
                            } ?>
                        </section>
                    </section>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
