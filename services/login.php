<?php
    session_start();
    include 'config.php'; // Incluindo as credenciais de banco de dados

    // Criando a conexão com o banco de dados
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Verificando se houve erro na conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    // Obtendo os dados do formulário
    $email = $_POST['email'];
    $password = $_POST['pass'];

    // Consultando o banco de dados para verificar o usuário
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificando se o usuário foi encontrado
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificando se a senha está correta
        if ($password === $user['user_password']) {
            $_SESSION['user_type'] = $user['user_type'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_name'] = $user['first_name'] . " " . $user['last_name'];
            
            header("Location: ../advertisements.php");
            exit();
        } else {
            $_SESSION['login_error'] = "Senha incorreta.";
            header("Location: ../login.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "Utilizador não encontrado.";
        header("Location: ../login.php");
        exit();
    }

    $stmt->close();
    $conn->close();
?>