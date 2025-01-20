<?php
session_start();
$error_message = '';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (isset($_SESSION['register_error'])) {
    $error_message = $_SESSION['register_error'];
    unset($_SESSION['register_error']); // Clear the error message after displaying
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
    <link rel="stylesheet" href="css/registo.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" type="image/x-icon" href="./assets/.ico">
    <title>Avós D'Aluguer | Registo</title>
</head>

<body>
    <!-- Navbar fora da .hero -->
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
        <section class="registo">
            <div class="registo-container">
                <h2>Registo</h2>
                <form action="services/register.php" method="POST" enctype="multipart/form-data">
                    <label>Nome</label>
                    <input type="text" name="first_name" placeholder="Digite o seu Nome" required>

                    <label for="last_name">Apelido</label>
                    <input type="text" name="last_name" placeholder="Digite o seu Apelido" required>

                    <label for="age">Idade</label>
                    <input type="number" name="age" placeholder="Digite a sua Idade" required>

                    <label>Género</label>
                    <select name="genre" required>
                        <option value="">Selecione</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Feminino">Feminino</option>
                        <option value="Outro">Outro</option>
                    </select>

                    <label>Número de Estudante</label>
                    <input type="text" name="student_number" placeholder="Digite o seu Número de Estudante" required>

                    <label>Ano Curricular</label>
                    <select name="curricular_year" required>
                        <option value="">Selecione</option>
                        <option value=1>1º Ano Licenciatura</option>
                        <option value=2>2º Ano Licenciatura</option>
                        <option value=3>3º Ano Licenciatura</option>
                        <option value=4>1º Ano Mestrado</option>
                        <option value=5>2º Ano Mestrado</option>
                        <option value=6>Doutoramento</option>
                    </select>

                    <label>Email</label>
                    <input type="email" name="email" placeholder="Digite o seu Email" required>

                    <label>Palavra-passe</label>
                    <input type="password" name="user_password" placeholder="Digite a sua palavra-passe" required>

                    <label>Contato Telefónico</label>
                    <input type="text" name="phone_number" placeholder="Digite o seu Contato Telefónico" required>

                    <label>Imagem</label>
                    <input type="file" id="image" name="image">

                    <!-- Mensagem de erro -->
                    <?php if (!empty($error_message)): ?>
                        <p style="color: red; font-weight: bold;"><?php echo htmlspecialchars($error_message); ?></p>
                    <?php endif; ?>

                    <button type="submit">Registar</button>
                </form>
            </div>
        </section>
    </div>
</body>
</html>