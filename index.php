<?php
session_start(); // Asegúrate de que la sesión esté iniciada
?>
<?php
// Incluir el script de log
include 'log_accesos.php';

// Aquí va el resto del código de la página
?>
<!DOCTYPE html>
<html lang="eus">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Rina - Web Orria</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Custom Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body class="d-flex flex-column h-100">
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
        <!-- Header-->
        <header class="py-5">
            <div class="container px-5 pb-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-xxl-5">
                        <!-- Header text content-->
                        <div class="text-center text-xxl-start">
                            <div class="badge bg-gradient-primary-to-secondary text-white mb-4"><div class="text-uppercase">Design &middot; Development &middot; Marketing</div></div>
                            <div class="fs-3 fw-light text-muted">I can help your business to</div>
                            <h1 class="display-3 fw-bolder mb-5"><span class="text-gradient d-inline">Get online and grow fast</span></h1>
                            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xxl-start mb-3">
                                <a class="btn btn-primary btn-lg px-5 py-3 me-sm-3 fs-6 fw-bolder" href="produktuak.php">Produktuak</a>
                                <a class="btn btn-outline-dark btn-lg px-5 py-3 fs-6 fw-bolder" href="contact.php">Harremana</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-7">
                        <!-- Header profile picture-->
                        <div class="d-flex justify-content-center mt-5 mt-xxl-0">
                            <div class="profile bg-gradient-primary-to-secondary">
                                <img class="profile-img" src="assets/profile.png" alt="..." />
                                <div class="dots-1">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 191.6 1215.4" style="enable-background: new 0 0 191.6 1215.4" xml:space="preserve">
                                        <g transform="translate(0.000000,1280.000000) scale(0.100000,-0.100000)">
                                            <path d="M227.7,12788.6c-105-35-200-141-222-248c-43-206,163-412,369-369c155,32,275,190,260,339c-11,105-90,213-190,262 C383.7,12801.6,289.7,12808.6,227.7,12788.6z"></path>
                                            <path d="M1507.7,12788.6c-151-50-253-216-222-362c25-119,136-230,254-255c194-41,395,142,375,339c-11,105-90,213-190,262 C1663.7,12801.6,1569.7,12808.6,1507.7,12788.6z"></path>
                                            <!-- Otros elementos del SVG -->
                                        </g>
                                    </svg>
                                </div>
                                <div class="dots-2">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 191.6 1215.4" style="enable-background: new 0 0 191.6 1215.4" xml:space="preserve">
                                        <g transform="translate(0.000000,1280.000000) scale(0.100000,-0.100000)">
                                            <path d="M227.7,12788.6c-105-35-200-141-222-248c-43-206,163-412,369-369c155,32,275,190,260,339c-11,105-90,213-190,262 C383.7,12801.6,289.7,12808.6,227.7,12788.6z"></path>
                                            <path d="M1507.7,12788.6c-151-50-253-216-222-362c25-119,136-230,254-255c194-41,395,142,375,339c-11,105-90,213-190,262 C1663.7,12801.6,1569.7,12808.6,1507.7,12788.6z"></path>
                                            <!-- Otros elementos del SVG -->
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    </main>
    <!-- Footer-->
    <footer class="mt-auto bg-light py-4">
        <div class="container px-5"><div class="small text-center text-muted">Copyright &copy; Your Website 2024</div></div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>
</html>
