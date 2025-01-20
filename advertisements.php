<?php
include 'services/config.php';
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    // Redireciona para o login se não estiver logado
    $isLoggedIn = false;
} else {
    // Pega os dados da sessão
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anúncios Disponíveis</title>
    <link rel="stylesheet" href="css/advertisements.css">
    <link rel="stylesheet" href="css/style.css">
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

    <div id="an-container"></div>

    <!-- Botão para exibir o formulário (apenas para admin) -->
    <?php if ($user_type == 1): ?>
        <button id="show-form-btn">Criar Novo Anúncio</button>

        <!-- Formulário de criação de anúncio -->
        <section id="admin-create-ad" class="hidden">
            <h2>Criar Novo Anúncio</h2>
            <form action="services/post_ad.php" method="POST" enctype="multipart/form-data">
                <label for="title">Título:</label>
                <input type="text" id="title" name="title" required>

                <label for="price">Preço (€):</label>
                <input type="number" id="price" name="price" required>

                <label for="description">Descrição:</label>
                <textarea id="description" name="description" required></textarea>

                <label for="address_street">Rua:</label>
                <input type="text" id="address_street" name="address_street" required>

                <label for="address_number">Número:</label>
                <input type="text" id="address_number" name="address_number" required>

                <label for="address_zip_code">Código Postal:</label>
                <input type="text" id="address_zip_code" name="address_zip_code" required>

                <label for="address_city">Cidade:</label>
                <input type="text" id="address_city" name="address_city" required>

                <label for="conditions">Condições:</label>
                <textarea id="conditions" name="conditions" required></textarea>

                <label for="an_images">Fotos:</label>
                <input type="file" id="an_images" name="an_images[]" multiple required>

                <label for="owner_name">Nome do Senhorio:</label>
                <input type="text" id="owner_name" name="owner_name" required>

                <label for="owner_description">Descrição do Senhorio:</label>
                <textarea id="owner_description" name="owner_description"></textarea>

                <label for="owner_image">Imagem do Senhorio:</label>
                <input type="file" id="owner_image" name="owner_image" required>

                <button type="submit">Publicar Anúncio</button>
            </form>
        </section>
    <?php endif; ?>



    <script src="js/get_ads.js"></script>

    <script>
        // Seleciona o botão e o formulário
        const showFormBtn = document.getElementById('show-form-btn');
        const createAdForm = document.getElementById('admin-create-ad');

        // Inicialmente, o formulário está oculto
        createAdForm.style.height = '0';
        createAdForm.style.overflow = 'hidden';
        createAdForm.style.transition = 'height 0.5s ease-in-out';

        // Evento para alternar a exibição do formulário
        showFormBtn.addEventListener('click', () => {
            if (createAdForm.style.height === '0px' || createAdForm.style.height === '0') {
                createAdForm.style.height = 'auto';
                showFormBtn.textContent = 'Fechar Formulário';
            } else {
                createAdForm.style.height = '0';
                showFormBtn.textContent = 'Criar Novo Anúncio';
            }
        });
    </script>


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

</html>