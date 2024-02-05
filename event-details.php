<?php
session_start();
include 'conn.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid event ID');
}

$id = $_GET['id'];
$query = $conn->prepare("SELECT * FROM Events WHERE id_event = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();

if ($result === false) {
    die('Error executing query: ' . $conn->error);
}

$event = $result->fetch_assoc();

if ($event === null) {
    die('No event found with ID ' . $id);
}

$id = $_GET['id'];
$query = "SELECT events.*, ingressos.*, lotes.* 
          FROM events 
          LEFT JOIN ingressos ON events.id_event = ingressos.id_evento 
          LEFT JOIN lotes ON ingressos.id_ingresso = lotes.id_ingresso 
          WHERE events.id_event = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$rows = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row; // Adicione cada linha ao array $rows
    }
} else {
    echo "0 results";
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>White Label Marker</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <!-- Add Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />

    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="css/slick.css" />
    <link type="text/css" rel="stylesheet" href="css/slick-theme.css" />

    <!-- nouislider -->
    <link type="text/css" rel="stylesheet" href="css/nouislider.min.css" />

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.min.css">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="css/style.css" />
    <link type="text/css" rel="stylesheet" href="css/map.css" />

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
    <script src="js/getTicket.js"></script>
</head>

<body>

    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.html">
                <img src="img/logo/logo_brasuca-removebg-preview.png" alt="Logo" width="100">
                <label style="color: #484848;">Brasuca</label>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <!-- Botões de login e meus ingressos (para mobile) -->
                <form class="d-flex d-lg-none mb-2">
                    <button class="btn btn-outline-dark me-2 shadow-lg " type="submit">
                        <i class="bi bi-person-fill"></i>
                        Login
                    </button>

                    <button class="btn btn-outline-dark" type="button" onclick="window.location.href='login.html'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-ticket-perforated-fill" viewBox="0 0 16 16">
                            <path d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6zm4-1v1h1v-1zm1 3v-1H4v1zm7 0v-1h-1v1zm-1-2h1v-1h-1zm-6 3H4v1h1zm7 1v-1h-1v1zm-7 1H4v1h1zm7 1v-1h-1v1zm-8 1v1h1v-1zm7 1h1v-1h-1z" />
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

                    <button class="btn btn-outline-dark ms-auto" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-ticket-perforated-fill" viewBox="0 0 16 16">
                            <path d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6zm4-1v1h1v-1zm1 3v-1H4v1zm7 0v-1h-1v1zm-1-2h1v-1h-1zm-6 3H4v1h1zm7 1v-1h-1v1zm-7 1H4v1h1zm7 1v-1h-1v1zm-8 1v1h1v-1zm7 1h1v-1h-1z" />
                        </svg>
                        Ingressos
                        <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                    </button>

                    </button>
                </form>
            </div>
        </div>
    </nav>




    <!-- Header -->
    <header class="bg-dark py-1 shadow-lg">
        <div class="container px-4 px-lg- my-4 text-center">
            <img src="data:*/*;base64,<?php echo $event['image_event']; ?>" class="img-fluid" style="border-radius: 10px; max-height: 200px; max-width: 400px;">
        </div>
    </header>
    <!-- Section dos produtos -->
    <section class="py-5">

        <div class="container">
            <div class="row justify-content-center">
                <h5 class="fw-bolder"><?php echo $event['title']; ?> </h5>
                <p style="font-size: smaller;"><?php echo $event['local_city'] . '-' . $event['local_uf']; ?><br>
                    <?php echo $event['local_street'] . ', ' . $event['local_neighborhood'] . ', ' . $event['local_number'] . '- ' . $event['local_cep']; ?></p>

                <div class="container" style="margin-bottom: 20px;">
                    <div class="row justify-content-center">
                        <div class="btn btn-outline-light ms-auto" style="background-color: #ffffff; padding: 8px; border-radius: 10px; margin-bottom: 20px;">
                            <button class="btn btn-outline-dark me-3" onclick="mostrarIngressos()">Ingressos</button>
                            <button class="btn btn-outline-dark me-3" onclick="mostrarInformacoes()">Informações</button>
                        </div>
                    </div>
                </div>

                <div class="container" id="ingressos-container" style="display: none;">
                    <div class="row justify-content-center">
                        <div class="btn btn-outline-light ms-auto" style="background-color: #212529; padding: 8px; border-radius: 10px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-calendar text-white" style="font-size: smaller;"></i>
                                    <label id="date" class="text-white" style="font-size: smaller;"></label>
                                </div>
                                <div>
                                    <i class="fas fa-clock text-white" style="font-size: smaller;"></i>
                                    <label id="hour" class="text-white" style="font-size: smaller;"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                    <?php foreach ($rows as $row) : ?>
                        <div class="container shadow-lg" style="margin-top: 20px; background-color: #dadada;">
                            <div class="row justify-content-center shadow-lg" style="margin-bottom: 20px;">
                                <div class="p-4 btn-outline-light ms-auto d-flex align-items-center" style="background-color: #212529; padding: 8px; border-radius: 10px 10px 0 0;">
                                    <h5 class="fw-bolder text-white"><?= $row['nome_ingresso'] ?></h5>
                                    <i class="fas fa-chevron-down text-white ms-auto" style="margin-left: 10px;" onclick="toggleIngressos('pista-details-<?= $row['id_ingresso'] ?>')"></i>
                                    <i class="fas fa-chevron-up text-white ms-auto" style="margin-left: 10px; display: none;" onclick="toggleIngressos('pista-details-<?= $row['id_ingresso'] ?>')"></i>
                                </div>
                                <div id="pista-details-<?= $row['id_ingresso'] ?>" class="p-4 ms-auto" style="background-color: #dedede; padding: 8px; border-radius: 0 0 10px 10px; border: 1px solid black; display: none;">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <ul style="list-style-type: none; padding: 0;">
                                            <li style="font-size: small;">Classificação: Maiores de <?= $row['category'] ?> anos</li>
                                            <li><?= $row['nome_lote'] ?></li>
                                            <?php
                                            $valor_ingresso = $row['valor_ingresso'];
                                            $taxa_valor_ingresso = $row['taxa_valor_ingresso'];

                                            // Calcular o valor total
                                            $valor_total = $valor_ingresso + ($valor_ingresso * $taxa_valor_ingresso / 100);
                                            $valor_total_formatted = number_format($valor_total, 2, ',', '.');
                                            ?>
                                            <li class="preco-ingresso">R$ <?= $valor_total_formatted ?></li>
                                            <li style="color: green;">Valor + Taxa. Pague em até 12x</li>
                                            <li><i class="fas fa-info-circle" style="color: green;"></i> Kit camisa + copo incluso</li>
                                        </ul>
                                        <div class="d-flex align-items-center">
                                            <button onclick="alterarQuantidade(-1, 'quantidade<?= $row['id_ingresso'] ?>', 'pista')" class="btn btn-secondary">-</button>
                                            <span id="quantidade<?= $row['id_ingresso'] ?>" class="mx-2">0</span>
                                            <button onclick="alterarQuantidade(1, 'quantidade<?= $row['id_ingresso'] ?>', 'frontstage')" class="btn btn-secondary">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                
            </div>
        </div>
        </div>
        </div>
    </section>

    <!-- Nessa seção fica a descrição do evento -->
    <div class="container" id="informacoes-container" style="display: none;">
        <div class="row justify-content-center">
            <div class="btn btn-outline-light ms-auto" style="background-color: #212529; padding: 8px; border-radius: 10px;">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bolder text-white">Informações sobre este evento!</h5>
                </div>
            </div>
            <p style="margin-top: 20px;">O bloco foi criado por amigos moradores da Av. Beira Rio, com cunho
                carnavalesco e ecológico em defesa
                das Capivaras,
                esses animais são moradores das margens do Rio Capibaribe a muito tempo, que recebeu esse nome em
                homenagem as capivaras, que habitavam em grandes quantidades,
                esse será o primeiro ano de desfile do bloco, que pretende realizar a festa com 02 trios elétricos
                e um espaço kids para as crianças e um espaço indoor na quadra ao lado da praça Jose Sales Filho onde o
                desfile se encerrará,
                teremos também campanhas de conscientização para preservação do meio ambiente e das Capivaras</p>

        </div>
    </div>
    </div>

    <!-- Nessa seção fica o valor do ingresso e o botão de comprar -->
    <section id="sticky-section" class="py-2" style="position: fixed; bottom: 0; width: 100%; background-color: #dedede; z-index: 9999; border-top: 5px solid #212529;">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <!-- Contador -->
                <div class="col-12 text-center" style="background-color: gray; color: white; margin-bottom: 10px; border-radius: 10px;">
                    <strong id="counter"></strong>
                </div>
                <div class="col-md-6 text-center">
                    <ul class="mb-0 text-center">
                        <li id="total-ingressos">0 Ingresso por</li>
                        <li id="total-price" style="color: black; font-size: 30px;">R$ 0,00</li>
                        <li style="color: green;"><strong>Pague em até 12x</strong></li>
                    </ul>
                </div>
                <div class="col-md-6 text-center">
                    <button onclick="window.location.href = 'paymentWay.html';" class="btn btn-outline-dark ms-auto rounded-pill btn-lg" style="width: 200px; background-color: #fff; border-width: 3px;">Comprar</button>
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

                            Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script> Todos direitos reservados por
                            Marco Nascimento

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/jquery.zoom.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/app.js"></script>
    <script src="js/map.js"></script>
    <script src="js/countTicket.js"></script>
    <script src="js/getTicket.js"></script>
    <script src="js/zoom.js"></script>

    <script>
        window.onload = function() {
            var dateHour = "<?php echo $event['date_hour']; ?>";
            var eventDate = new Date(dateHour);

            // Formatação da data
            var optionsDate = {
                day: '2-digit',
                month: 'short'
            };
            var formattedDate = eventDate.toLocaleDateString('pt-BR', optionsDate);

            // Formatação da hora
            var optionsTime = {
                hour: 'numeric',
                minute: '2-digit'
            };
            var formattedTime = eventDate.toLocaleTimeString('pt-BR', optionsTime);

            // Preencher os elementos HTML
            document.getElementById('date').textContent = formattedDate;
            document.getElementById('hour').textContent = formattedTime;
        };
    </script>





</body>

</html>