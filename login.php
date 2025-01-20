<?php
session_start();
$error_message = '';
if (isset($_SESSION['login_error'])) {
    $error_message = $_SESSION['login_error'];
    unset($_SESSION['login_error']); // Limpa a mensagem após exibição
}

$register_success_message = '';
if (isset($_SESSION['register_success'])) {
    $register_success_message = $_SESSION['register_success'];
    unset($_SESSION['register_success']); // Limpa a mensagem após exibição
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
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" type="image/x-icon" href="./assets/.ico">
    <title>Avós D'Aluguer | Login</title>
</head>

<body>
    <!-- Navbar fora da .hero -->
    <nav class="hero__nav">
        <a class="logo" href="index.php#begin"><img src="./assets/logo.png" style="width: 300px;"></a>
        <ul class="nav-list">
            <li><a href="index.php#como-funciona">Como Funciona?</a></li>
            <li><a href="index.php#quem-somos">Quem Somos?</a></li>
            <li><a href="index.php#footer">Contactos</a></li>
        </ul>
        <button type="button" onclick="window.location.href='login.php'">Login</button>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="hero__background"></div>
        <!--Formulário de login dentro da hero -->
        <nav class="login">
            <div class="login-container">
                <section>
                    <h2>Login</h2>
                    <form action="services/login.php" method="post">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="Digite o seu Email" required>
                        <label>Password</label>
                        <input type="password" name="pass" placeholder="Digite a sua password" required>

                        <!-- Mensagem de erro -->
                        <?php if (!empty($error_message)): ?>
                            <p style="color: red; font-weight: bold;"><?php echo htmlspecialchars($error_message); ?></p>
                        <?php endif; ?>

                        <button type="submit">Login</button>
                        <label class="criar">Ainda não tem conta?<a href="registo.php">&nbsp&nbsp&nbsp&nbsp&nbsp Crie
                                uma!</a></label>
                    </form>
                </section>
            </div>
        </nav>
    </div>

    <script src="app.js"></script>
    <script>
        window.onload = function () {
            if ('<?php echo $register_success_message; ?>' !== '') {
                var alertMessage = document.createElement('div');
                alertMessage.className = 'alert show';
                alertMessage.innerText = '<?php echo $register_success_message; ?>';

                document.body.appendChild(alertMessage);

                setTimeout(function () {
                    alertMessage.style.top = '-50px';
                    alertMessage.style.opacity = '0';
                    setTimeout(function () {
                        alertMessage.remove();
                    }, 500);
                }, 3000);
            }
        }
    </script>
</body>
</html>