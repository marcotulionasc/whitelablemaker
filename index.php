<?php
session_start();
require_once('conn.php');

$tenant_id = 1; // You need to set this value according to your application logic

$sql = "SELECT * FROM Events WHERE tenant_id = ? AND events_active = 1";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Erro na preparação da consulta: " . $conn->error);
}

$stmt->bind_param("i", $tenant_id);
$stmt->execute();
$result = $stmt->get_result();
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Brasuca Multicultural</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <!-- Add Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="/css/bootstrap.min.css" />

    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="css/slick.css" />
    <link type="text/css" rel="stylesheet" href="css/slick-theme.css" />

    <!-- nouislider -->
    <link type="text/css" rel="stylesheet" href="css/nouislider.min.css" />

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.min.css">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="css/style.css" />

    <style>
        .carousel-image {
            width: 100%;
            height: auto;
            max-width: 300px;
            max-height: 450px;
            object-fit: cover;
        }

        @media (max-width: 768px) {
            .carousel-only-mobile {
                display: block;
            }

            .carousel-only-desktop {
                display: none;
            }
        }

        @media (min-width: 769px) {
            .carousel-only-mobile {
                display: none;
            }

            .carousel-only-desktop {
                display: block;
            }
        }
    </style>

</head>

<body>

    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container px-4 px-lg-5">
    
            <a class="navbar-brand" href="index.php">
                <img src="img/logo/logo_brasuca-removebg-preview.png" alt="Logo" width="100" class="colored-logo" style="border-radius: 50%;">
            </a>
             
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <!-- Botões de login e meus ingressos (para mobile) -->
                <form class="d-flex d-lg-none mb-2">
                    <button class="btn btn-outline-dark me-2 shadow-lg " type="button" onclick="window.location.href='login.html'">
                        <i class="bi bi-person-fill"></i>
                        Login
                    </button>

                    <button class="btn btn-outline-dark" type="submit" onclick="window.location.href='ticket.html'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-ticket-perforated-fill" viewBox="0 0 16 16">
                            <path d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6zm4-1v1h1v-1zm1 3v-1H4v1zm7 0v-1h-1v1zm-1-2h1v-1h-1zm-6 3H4v1h1zm7 1v-1h-1v1zm-7 1H4v1h1zm7 1v-1h-1v1zm-8 1v1h1v-1zm7 1h1v-1h-1z"/>
                          </svg>
                        Ingressos
                        <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                    </button>
                </form>

                                <!-- Barra de pesquisa de eventos -->
                                <form class="d-flex">
                                    <input class="form-control me-1" type="search" placeholder="Pesquisar eventos" aria-label="Search">
                                    <!-- Input nativo de data -->
                                    <input class="form-control me-2" type="date" class="form-control" id="datePicker">
                
                                    <button class="btn btn-outline-dark me-2" type="button">
                                        <i class="bi bi-search me-1"></i>
                                    </button>
                                </form>

                <!-- Botões de login e meus ingressos (para desktop) -->
                <form class="d-none d-lg-flex ms-auto">
                    <button class="btn btn-outline-dark me-3" type="button" onclick="window.location.href='login.html'">
                        <i class="bi bi-person-fill"></i>
                        Login
                    </button>

                    <button class="btn btn-outline-dark ms-auto" type="submit" onclick="window.location.href='ticket.html'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-ticket-perforated-fill" viewBox="0 0 16 16">
                            <path d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6zm4-1v1h1v-1zm1 3v-1H4v1zm7 0v-1h-1v1zm-1-2h1v-1h-1zm-6 3H4v1h1zm7 1v-1h-1v1zm-7 1H4v1h1zm7 1v-1h-1v1zm-8 1v1h1v-1zm7 1h1v-1h-1z"/>
                          </svg> <!-- Arrumar isso aqui -->
                       Ingressos
                        <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                    </button>

                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Header-->
    <header class="bg-dark py-1 shadow-lg">
        <div class="container px-4 px-lg- my-4">
            <!-- Carrossel Mobile -->
            <div id="carouselHeaderMobile" class="carousel-only-mobile carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="img/banners/banner1.webp"
                            class="d-block mx-auto carousel-image" alt="Banner 1" style="border-radius: 10px;">
                    </div>
                    <div class="carousel-item">
                        <img src="img/banners/banner2.webp"
                            class="d-block mx-auto carousel-image" alt="Banner 2" style="border-radius: 10px;">
                    </div>
                    <div class="carousel-item">
                        <img src="img/banners/banner3.webp"
                            class="d-block mx-auto carousel-image" alt="Banner 3" style="border-radius: 10px;">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselHeaderMobile"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselHeaderMobile"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Próximo</span>
                </button>
            </div>

            <!-- Banners Desktop -->
            <div class="text-center text-white mt-4 carousel-only-desktop">
                <div class="row justify-content-center mt-5">
                    <div class="col-3">
                        <img src="img/banners/banner1.webp" alt="Banner 1" class="img-fluid"
                            style="width: 280px; height: 300px; border-radius: 10px;">
                    </div>
                    <div class="col-3">
                        <img src="img/banners/banner2.webp" alt="Banner 2" class="img-fluid"
                            style="width: 280px; height: 300px; border-radius: 10px;">
                    </div>
                    <div class="col-3">
                        <img src="img/banners/banner3.webp" alt="Banner 3" class="img-fluid"
                            style="width: 280px; height: 300px; border-radius: 10px;">
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Eventos -->
    <section class="py-5">

        <div class="container">
            <div class="row justify-content-center align-items-center">

                <!-- Filtro Desktop -->
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="btn-group">
                        <button class="btn btn-outline-dark me-3">Todos os eventos</button>
                        <button class="btn btn-outline-dark me-3">Mais recentes</button>
                        <button class="btn btn-outline-dark me-3">Mais populares</button>
                        <button class="btn btn-outline-dark me-3">Carnaval</button>
                        <button class="btn btn-outline-dark me-3">Forró</button>
                    </div>
                </div>

                <!-- Filtro Mobile -->
                <div class="col-12 d-lg-none mt-3">
                    <div class="input-group">
                        <select class="form-select" id="mobileSortingDropdown">
                            <option selected>Ordenar por...</option>
                            <option value="recentes">Mais Recentes</option>
                            <option value="populares">Mais Populares</option>
                            <option value="preco-baixo-alto">Carnaval</option>
                            <option value="preco-alto-baixo">Forró</option>
                            <option value="a-z">Todos eventos</option>
                        </select>
                    </div>
                </div>

            </div>
        </div>

        <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-4 row-cols-xl-4 justify-content-center">
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <div class="col mb-5">
                                <div class="card h-100 shadow-lg shadow-lg">
                                    <!-- Imagem evento
                                    <input type="hidden" name="image_event" value="<?php echo $row['id_event']; ?>">-->
                                    <img class="card-img-top" src="data:*/*;base64,<?php echo $row['image_event']; ?>" alt="..." style="max-width: 450px; max-height: 300px;" />
                                    <!-- Detalhe do evento-->
                                    <div class="card-body p-4">
                                        <div class="text-center">
                                            <h5 class="fw-bolder">
                                                <?php echo $row['title']; ?>
                                            </h5>
                                            <i class="fas fa-calendar" style="font-size: smaller;"></i>
                                            <label style="font-size: smaller;">
                                                <?php echo $row['date_hour']; ?>
                                            </label> <br>

                                            <label style="font-size: smaller;">
                                                <i class="fas fa-map-marker-alt" style="font-size: smaller;"></i> <?php echo $row['local_name']; ?>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="event-details.php?id=<?php echo $row['id_event']; ?>">Ver mais</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>


                <div class="row justify-content-center align-items-center">
                    <ul class="pagination mx-auto text-center justify-content-center">
                        <li class="page-item text-center">
                            <button class="btn btn-outline-dark me-3" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </button>
                        </li>
                        <li class="page-item"><a class="btn btn-outline-dark me-3" href="index.html">1</a></li>
                        <li class="page-item"><a class="btn btn-outline-dark me-3" href="page2.html">2</a></li>
                        <li class="page-item"><a class="btn btn-outline-dark me-3" href="#">3</a></li>
                        <li class="page-item">
                            <button class="btn btn-outline-dark me-3" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer id="footer">
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="footer">
                            <h3 class="footer-title">Localização</h3>
                            <ul class="footer-links">
                                <li><a href="#" class="custom-link"><i class="fa fa-map-marker"></i>Rua ABC, 123, Parque
                                        Does not Exist, São Paulo</a></li>
                                <li><a href="#" class="custom-link"><i class="fa fa-phone"></i>+55 (12) 3456-7890</a>
                                </li>
                                <li><a href="#" class="custom-link"><i class="fas fa-envelope"></i>teste@example.com</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col">
                        <div class="footer">
                            <h3 class="footer-title">Filtros</h3>
                            <ul class="footer-links">
                                <li><a href="#" class="custom-link">Todos eventos</a></li>
                                <li><a href="#" class="custom-link">Festival</a></li>
                                <li><a href="#" class="custom-link">Carnaval</a></li>
                                <li><a href="#" class="custom-link">Outros filtros</a></li>
                                <li><a href="#" class="custom-link">Outros filtros</a></li>
                            </ul>
                        </div>
                    </div>



                    <div class="col">
                        <div class="footer">
                            <h3 class="footer-title">Informação</h3>
                            <ul class="footer-links">
                                <li><a href="#" class="custom-link">Sobre nós</a></li>
                                <li><a href="#" class="custom-link">Contato</a></li>
                                <li><a href="#" class="custom-link">Politicas de privacidade</a></li>
                                <li><a href="#" class="custom-link">Site oficial</a></li>
                                <li><a href="#" class="custom-link">Termos e condições</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col">
                        <div class="footer">
                            <h3 class="footer-title">Navegação</h3>
                            <ul class="footer-links">
                                <li><a href="#" class="custom-link">Minha Conta</a></li>
                                <li><a href="#" class="custom-link">Meus ingressos</a></li>
                                <li><a href="#" class="custom-link">FAQ</a></li>
                                <li><a href="#" class="custom-link">Ajuda</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- bottom footer -->
        <div id="bottom-footer" class="section">
            <div class="container">
                <!-- row -->
                <div class="row">
                    <div class="col-md-12 text-center">
                        <!-- <ul class="footer-payments">
                            <li><a href="#"><i class="fa fa-cc-visa"></i></a></li>
                            <li><a href="#"><i class="fa fa-credit-card"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-discover"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-amex"></i></a></li>
                        </ul> -->
                        <span class="copyright">
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;
                            <script>document.write(new Date().getFullYear());</script> Todos direitos reservados por
                            Marco Nascimento
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        </span>
                    </div>
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /bottom footer -->
    </footer>
    <!-- /FOOTER -->




    <!-- Footer
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Marco Nascimento 2024</p>
        </div>
    </footer> -->




    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <!-- jQuery Plugins -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/jquery.zoom.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>