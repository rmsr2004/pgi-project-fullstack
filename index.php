<?php
include 'services/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    $isLoggedIn = false;
} else {
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
    $user_type = $_SESSION['user_type'];
    $isLoggedIn = true;
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/media.css">
    <link rel="icon" type="image/x-icon" href="./assets/.ico">
    <title>Avós D'Aluguer | Home</title>
    <style>
        /* Navbar style */
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
    <nav class="hero__nav">
        <a class="logo" href="#begin"><img src="./assets/logo.png"></a>
        <ul class="nav-list">
            <li><a href="#como-funciona">Como Funciona?</a></li>
            <li><a href="#quem-somos">Quem Somos?</a></li>
            <li><a href="#footer">Contactos</a></li>
        </ul>
        <?php if ($isLoggedIn): ?>
            <div class="user-info">
                <span>Olá, <?php echo htmlspecialchars($user_name); ?></span>
                <button class="logout-btn" onclick="window.location.href='advertisements.php';">DashBoard</button>
            </div>
        <?php else: ?>
            <button type="button" onclick="window.location.href='login.php';">Login</button>
        <?php endif; ?>
    </nav>

    <span id="sidebarToggle" onclick="toggleSidebar()">&#9776;</span>
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="toggleSidebar()"></a>
        <a class="logo" href="#begin" onclick="toggleSidebar()"><img src="./assets/logo.png" style="width: 180px;"></a>
        <a href="#como-funciona" onclick="toggleSidebar()">Como Funciona?</a>
        <a href="#quem-somos" onclick="toggleSidebar()">Quem Somos?</a>
        <a href="#footer" onclick="toggleSidebar()">Contactos</a>
        <?php if ($isLoggedIn): ?>
            <div class="user-info">
                <span>Olá, <?php echo htmlspecialchars($user_name); ?></span>
                <button class="logout-btn" onclick="window.location.href='advertisements.php';">DashBoard</button>
            </div>
        <?php else: ?>
            <button type="button" onclick="window.location.href='login.php';">Login</button>
        <?php endif; ?>
    </div>

    <!-- Div to scrool when the logo is pressed -->
    <div id="begin"></div>

    <!-- Hero Section -->
    <div class="hero">
        <div class="hero__background"></div>
        <div class="main__container">
            <div class="main__content">
                <h1>Mais poupança para os estudantes </h1>
                <h1>Menos solidão para os idosos</h1>
                <h2>
                    Avós D'Aluguer é uma plataforma que conecta estudantes e idosos, focada em aumentar a oferta de
                    quartos a
                    preços acessíveis e combater a solidão dos idosos.
                </h2>
                <a class="main__btn primary" role="button" id="btnQueroAlugar">Quero Alugar</a>
                <a class="main__btn secondary" role="button" id="btnQueroArrendar">Quero Arrendar</a>
            </div>
        </div>
    </div>

    <!-- Benefits Section -->

    <div class="benefits-section">
        <h1>Benefícios da nossa Plataforma</h1>
        <div class="benefits-grid" id="benefitsGrid">
            <!-- Os benefícios serão inseridos aqui dinamicamente -->
        </div>
        <button id="toggleButton" onclick="toggleBenefits()">Ver Benefícios para Idosos</button>
    </div>


    <!-- About Section -->
    <div class="about" id="como-funciona">
        <h1>Como Funciona?</h1>
        <div class="about__container">
            <div class="about__image">
                <img src="/assets/aboutimg.jpg" alt="img" />
            </div>
            <div class="about__content">
                <p>A nossa plataforma promove uma solução inovadora e colaborativa para dois públicos que podem se
                    beneficiar mutuamente: <strong>estudantes universitários</strong> à procura de alojamento acessível
                    e <strong>idosos</strong> que possuem quartos vagos e desejam companhia.</p>
                <p>Num momento em que encontrar <strong>habitação acessível</strong> nas grandes cidades tornou-se um
                    desafio para os jovens, e em que muitos idosos enfrentam a <strong>solidão</strong> de viver
                    sozinhos, a nossa plataforma surge como uma <strong>ponte entre gerações</strong>.</p>
                <p>Através desta iniciativa, os estudantes têm acesso a uma opção de <strong>moradia acolhedora e
                        económica</strong>, enquanto os idosos ganham novos companheiros que trazem <strong>energia e
                        interação</strong> ao dia a dia. Ao partilhar o mesmo teto, criam-se <strong>laços únicos e
                        valiosos</strong> entre gerações.</p>
            </div>
        </div>
    </div>

    <!-- Students Flow -->
    <div class="flows-wrapper">
        <div class="flow-container">
            <h2>Estudantes</h2>
            <div class="flow-step">
                <div class="step-number">1</div>
                <p><strong>Candidatam-se a um quarto</strong>:</p>
                <p>O estudante escolhe um quarto disponível e faz a sua
                    candidatura.</p>
            </div>
            <div class="flow-step">
                <div class="step-number">2</div>
                <p><strong>Entrevista</strong>: </p>
                <p>Caso a candidatura seja aprovada, é marcada uma entrevista com um
                    membro da nossa equipa.</p>
            </div>
            <div class="flow-step">
                <div class="step-number">3</div>
                <p><strong>Visita ao Quarto</strong>:</p>
                <p> Se o estudante cumprir os requisitos, é marcada uma visita ao
                    quarto com o senhorio.</p>
            </div>
        </div>

        <!-- Seniors flow -->
        <div class="flow-container">
            <h2>Senhorios</h2>
            <div class="flow-step">
                <div class="step-number">1</div>
                <p><strong>Publicam o Quarto</strong>:</p>
                <p> O idoso cria um anúncio do seu quarto na plataforma.
                </p>
            </div>
            <div class="flow-step">
                <div class="step-number">2</div>
                <p><strong>Esperam pela Visita</strong>:</p>
                <p> Após a publicação, os idosos aguardam as visitas agendadas
                    com os estudantes.</p>
            </div>
        </div>
    </div>

    <!-- Who we are section -->
    <div id="quem-somos" class="quem-somos">
        <h1>Quem somos?</h1>
        <div class="quem-somos__container">
            <div class="quem-somos__content">
                <p>
                    Somos um grupo de estudantes do 3º ano de Engenharia Informática da Universidade de Coimbra que quer
                    resgatar
                    uma prática tradicional de Coimbra: o alojamento estudantil com idosos ou famílias locais. A nossa
                    plataforma
                    visa facilitar essa conexão, oferecendo aos estudantes uma opção de moradia acessível e aos idosos
                    uma maneira de
                    rentabilizar quartos não utilizados, criando um ambiente de convivência inter-geracional e
                    enriquecedora.
                </p>
                <p>
                    Queremos devolver a essa prática o seu valor, proporcionando não só uma solução de alojamento, mas
                    também uma experiência
                    de comunidade, onde todos ganham: os estudantes com um lugar seguro e acolhedor para morar, e os
                    idosos com companhia
                    e a possibilidade de gerar uma renda extra.
                </p>
            </div>
            <div class="quem-somos__images">
                <div class="photo">
                    <img src="images/quem-somos/rr.jpg" alt="Rodrigo Rodrigues" />
                    <span>Rodrigo Rodrigues</span>
                </div>
                <div class="photo">
                    <img src="images/quem-somos/js.jpg" alt="João Simões" />
                    <span>João Simões</span>
                </div>
                <div class="photo">
                    <img src="images/quem-somos/gs.jpg" alt="Gonçalo Silva" />
                    <span>Gonçalo Silva</span>
                </div>
                <div class="photo">
                    <img src="images/quem-somos/jm.jpg" alt="João Marques" />
                    <span>João Marques</span>
                </div>
                <div class="photo">
                    <img src="images/quem-somos/sc.jpg" alt="Simão Campanudo" />
                    <span>Simão Campanudo</span>
                </div>
                <div class="photo">
                    <img src="images/quem-somos/rm.jpg" alt="Renato Marques" />
                    <span>Renato Marques</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div id="formContainer">
        <h2>Interessado em Arrendar?</h2>
        <h3>Contacte-nos já!</h3>
        <form id="userForm">
            <label for="name">Nome:</label>
            <input type="text" id="name" name="name" required>

            <label for="phone">Contacto Telefónico:</label>
            <input type="text" id="phone" name="phone" required>

            <label for="userType">Sou:</label>
            <select id="userType" name="userType" required>
                <option value="senhorio">Senhorio</option>
            </select>
            <script>
                document.getElementById('userForm').addEventListener('submit', function (event) {
                    event.preventDefault();
                    const name = document.getElementById('name').value;
                    const phone = document.getElementById('phone').value;
                    send_email(name, phone);
                });
            </script>
            <button id="sendEmailButton" type="submit" class="main__btn primary">Enviar</button>
        </form>
    </div>

    <!-- Modal de Confirmação -->
    <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Contacto Guardado!</h2>
            <p>A sua candidatura foi enviada com sucesso.</p>
            <p>Aguarde o nosso contacto</p>
        </div>
    </div>


    <!-- Login para interessados em alugar -->
    <div id="redirectToLogin">
        <h2>Interessado em Alugar?</h2>
        <h3>Visite os anúncios disponíveis!</h3>
        <button class="main__btn primary" onclick="window.location.href='login.php';">Login</button>
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
<script>
    function openNav() {
        document.getElementById("sidebar").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("sidebar").style.width = "0";
    }

    function scrollToForm() {
        const form = document.querySelector("#formContainer");
        const offset = 100;
        const top = form.getBoundingClientRect().top + window.pageYOffset - offset;

        // Smooth scroll
        window.scrollTo({
            top: top,
            behavior: "smooth"
        });

        history.replaceState(null, null, ' ');
    }
</script>
<script src="js/sidebar.js"></script>
<script src="js/scrollbar.js"></script>
<script src="js/benefits.js"></script>
<script src="js/modal2.js"></script>
<script text="text/javascript">
    // Inicialização do EmailJS
    (function () {
        emailjs.init("Q8bxFfcqlkR3eRvt6");
    })();

    // Função de envio de e-mail
    function send_email(nome, phone) {
        const templateParams = {
            to_email: "avosdaluguer@gmail.com",
            subject: "Candidatura a senhorio " + nome,
            message: "Recebida candidatura de " + nome + " (" + phone + ")."
        };

        emailjs.send("service_br5vcp7", "template_t10rlrr", templateParams)
            .then(function (response) {
                document.getElementById("confirmationModal").style.display = "block";
            }, function (error) {
                console.error("Falha no envio do e-mail. Erro: " + JSON.stringify(error));
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
</html>