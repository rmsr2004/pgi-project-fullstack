<?php
include 'services/config.php';

session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    // Redireciona para o login se não estiver logado
    header("Location: login.php");
    $isLoggedIn = false;
    exit();
} else {
    // Pega os dados da sessão
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
    $user_type = $_SESSION['user_type'];
    $isLoggedIn = true;
}

// Pega os dados da sessão
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Recebe o ID do anúncio via GET
$ad_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Conecta ao banco de dados
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Consulta SQL para obter os detalhes do anúncio
$sql = "
        SELECT a.*, i.link as image
        FROM advertisements a
        LEFT JOIN images i ON a.id = i.address_id
        WHERE a.id = $ad_id AND a.is_available = TRUE
    ";
$result = $conn->query($sql);

$images = [];
$ad = null;

// Verifica se o anúncio existe
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Salva as informações principais do anúncio na primeira iteração
        if (!$ad) {
            $ad = $row;
        }

        // Adiciona as imagens à lista, se houver
        if (!empty($row['image'])) {
            $images[] = $row['image'];
        }
    }

    // Remove "../" do caminho das imagens
    $images = array_map(function ($image) {
        return str_replace('../', '', $image);
    }, $images);

    // Remove "../" do caminho da imagem do proprietário
    if (!empty($ad['owner_image'])) {
        $ad['owner_image'] = str_replace('../', '', $ad['owner_image']);
    }
} else {
    echo "Anúncio não encontrado.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Anúncio</title>
    <link rel="stylesheet" href="css/ads_details.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
    <style>
        /* Aqui entra o seu estilo existente */
        /* Estilo da Navbar */
        .hero__nav button {
            background-color: #504949;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .hero__nav button:hover {
            background-color: white;
            color: black;
            border: 2px solid black;
        }

        .user-info {
            color: white;
            font-size: 1em;
        }

        .user-info span {
            margin-right: 10px;
        }

        .logout-btn {
            background-color: #504949;
        }

        .logout-btn:hover {
            background-color: white;
            color: black;
            border: 2px solid black;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="hero__nav">
        <a class="logo" href="https://avosdaluguer.dei.uc.pt/">
            <img src="./assets/logo.png" alt="Logo">
        </a>

        <?php if ($isLoggedIn): ?>
            <!-- Exibe se o usuário estiver logado -->
            <div class="user-info">
                <span>Olá, <?php echo htmlspecialchars($user_name); ?></span>
                <button class="logout-btn" onclick="window.location.href='logout.php';">Logout</button>
            </div>
        <?php else: ?>
            <!-- Exibe o botão Login se o usuário não estiver logado -->
            <button type="button" onclick="window.location.href='login.php';">Login</button>
        <?php endif; ?>
    </nav>

    <!-- Conteúdo Principal -->
    <div class="anuncio-container">
        <!-- Botão Voltar -->
        <div class="back-button-container">
            <button class="back-button" onclick="window.location.href='advertisements.php';">Voltar</button>
        </div>
        <div class="carousel">
            <!-- Carrossel de imagens -->
            <img id="carousel-image" src="<?php echo $images[0]; ?>" alt="Foto do Anúncio">
            <button id="prev-btn">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
            <button id="next-btn">
                <i class="fa-solid fa-arrow-right"></i>
            </button>
        </div>

        <div class="detalhes-container">
            <div class="info-detalhes">
                <h1 class="titulo"><?php echo $ad['title']; ?></h1>
                <p class="preco"><strong>Preço:</strong> <?php echo $ad['price']; ?>€</p>
                <p><strong>Descrição:</strong> <?php echo $ad['description']; ?></p>
                <p><strong>Condições:</strong> <?php echo $ad['conditions']; ?></p>
                <p><strong>Endereço:</strong> <?php echo $ad['address_street'] . ' ' . $ad['address_number']; ?>,
                    <?php echo $ad['address_city']; ?>, <?php echo $ad['address_zip_code']; ?>
                </p>
                <button class="candidatar-btn"
                    onclick="send_email('<?php echo $ad['title']; ?>', '<?php echo $ad['id']; ?>')">Candidatar-me</button>
            </div>
            <div class="anuncio-senhorio">
                <h2>Informações do Senhorio</h2>
                <div class="senhorio-info">
                    <img src="<?php echo $ad['owner_image']; ?>" alt="Imagem do Senhorio" class="senhorio-imagem">
                    <div class="senhorio-detalhes">
                        <p><strong>Nome:</strong> <?php echo $ad['owner_name']; ?></p>
                        <p><strong>Sobre:</strong> <?php echo $ad['owner_description']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação -->
    <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Candidatura Enviada!</h2>
            <p>A sua candidatura foi enviada com sucesso.</p>
        </div>
    </div>

    <!-- Footer Section -->
    <div class="footer" id="footer">
        <div class="footer-left">
            <h3>Contatos</h3>
            <p class="fa-solid fa-envelope">
                <a style="color: #fff; text-decoration: none;">
                    avosdaluguer@gmail.com
                </a>
            </p>
            <p></p>
            <p class="fa-brands fa-instagram">
                <a href="https://www.instagram.com/avosdaluguer/" target="_blank"
                    style="color: #fff; text-decoration: none;">
                    avosdaluguer
                </a>
            </p>
        </div>

        <div class="footer-middle">
            <h3>Política de Tratamento de Dados</h3>
            <p>Todos os dados coletados serão apagados em Janeiro de 2025. A utilização destes dados destina-se
                exclusivamente a fins estatísticos e académicos no contexto da disciplina de Processos de Gestão e de
                Inovação.</p>
        </div>

        <div class="footer-right">
            <h3>Aviso Legal</h3>
            <p>Os conteúdos constantes deste website foram realizados por alunos no âmbito de uma disciplina –
                Processos de Gestão e de Inovação - do 3º ano da Licenciatura em Engenharia Informática da Faculdade de
                Ciências e Tecnologia da Universidade de Coimbra (FCTUC), pelo que a FCTUC não se responsabiliza pelo
                seu conteúdo.</p>
        </div>
    </div>
</body>

<script type="text/javascript">
    // SEND EMAIL SCRIPT
    (function () {
        emailjs.init("Q8bxFfcqlkR3eRvt6");
    })();

    function send_email(nome, id_quarto) {
        const user_name = "<?php echo htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8'); ?>";
        const user_id = "<?php echo htmlspecialchars($user_id, ENT_QUOTES, 'UTF-8'); ?>";
        const templateParams = {
            to_email: "avosdaluguer@gmail.com",
            subject: "Candidatura ao quarto " + id_quarto + " [" + nome + "]",
            message: "Recebida candidatura de " + user_name + " (" + user_id + ")."
        };
        emailjs.send("service_br5vcp7", "template_t10rlrr", templateParams)
            .then(function (response) {
                document.getElementById("confirmationModal").style.display = "block";
            }, function (error) {
                alert("Falha no envio do e-mail. Erro: " + JSON.stringify(error));
            });
    }
    // Fecha o modal quando o botão de fechar for clicado
    document.querySelector('.close-btn').onclick = function () {
        document.getElementById("confirmationModal").style.display = "none";
    }

    // Fecha o modal quando o usuário clicar fora da caixa de conteúdo
    window.onclick = function (event) {
        if (event.target == document.getElementById("confirmationModal")) {
            document.getElementById("confirmationModal").style.display = "none";
        }
    }
</script>

<script>
    // Pega os elementos do DOM
    const carouselImage = document.getElementById('carousel-image');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');

    // Lista de imagens do PHP para o JavaScript
    const images = <?php echo json_encode($images); ?>;

    // Índice da imagem atual
    let currentIndex = 0;

    // Função para atualizar a imagem do carrossel
    function updateCarouselImage(index) {
        if (index >= 0 && index < images.length) {
            carouselImage.src = images[index];
        }
    }

    // Eventos dos botões
    prevBtn.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        updateCarouselImage(currentIndex);
    });

    nextBtn.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % images.length;
        updateCarouselImage(currentIndex);
    });

    // Inicializa com a primeira imagem
    updateCarouselImage(currentIndex);
</script>

</html>