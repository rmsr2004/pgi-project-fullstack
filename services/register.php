<?php
    session_start();
    include 'config.php';

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conn->connect_error) {
        $error_message = "Falha na conexão: " . $conn->connect_error;
        $_SESSION['register_error'] = $error_message;
        header("Location: ../registo.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $age = $_POST['age'];
        $genre = $_POST['genre'];
        if ($genre == "Masculino") {
            $genre = 1;
        } elseif ($genre == "Feminino") {
            $genre = 2;
        } else {
            $genre = 0;
        }
        $email = $_POST['email'];
        $user_password = $_POST['user_password'];
        $phone_number = $_POST['phone_number'];
        $student_number = $_POST['student_number'];
        $curricular_year = $_POST['curricular_year'];
        $image = "";

        // Check if email already exists
        $sql_check = "SELECT * FROM users WHERE email = ?";
        $stmt_check = $conn->prepare($sql_check);
        if (!$stmt_check) {
            $error_message = "Erro ao preparar a consulta: " . $conn->error;
            $_SESSION['register_error'] = $error_message;
            header("Location: ../registo.php");
            exit();
        }

        $stmt_check->bind_param("s", $email);
        if (!$stmt_check->execute()) {
            $error_message = "Erro ao executar a consulta: " . $stmt_check->error;
            $_SESSION['register_error'] = $error_message;
            header("Location: ../registo.php");
            exit();
        }

        $result_check = $stmt_check->get_result();
        if ($result_check->num_rows > 0) {
            $error_message = "O email já está registrado.";
            $_SESSION['register_error'] = $error_message;
            header("Location: ../registo.php");
            exit();
        }

        // Insert user into database
        $sql = "INSERT INTO users (first_name, last_name, age, genre, email, user_password, phone_number, user_type) VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            $error_message = "Erro ao preparar a consulta de inserção: " . $conn->error;
            $_SESSION['register_error'] = $error_message;
            header("Location: ../registo.php");
            exit();
        }

        $stmt->bind_param("sssssss", $first_name, $last_name, $age, $genre, $email, $user_password, $phone_number);
        if (!$stmt->execute()) {
            $error_message = "Erro ao inserir dados: " . $stmt->error;
            $_SESSION['register_error'] = $error_message;
            header("Location: ../registo.php");
            exit();
        }

        $user_id = $stmt->insert_id;
        $user_dir = "../images/users/" . $user_id;

        if (!is_dir($user_dir) && !mkdir($user_dir, 0777, true)) {
            $error_message = "Erro ao criar o diretório do usuário.";
            $_SESSION['register_error'] = $error_message;
            header("Location: ../registo.php");
            exit();
        }

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $target_file = $user_dir . "/" . basename($_FILES["image"]["name"]);
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $error_message = "Erro ao salvar a imagem.";
                $_SESSION['register_error'] = $error_message;
                header("Location: ../registo.php");
                exit();
            }

            $image = $target_file;
        } else {
            $image = "../images/users/default.jpg";  // Caminho da imagem padrão
        }

        $sql_update = "UPDATE users SET image = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        if (!$stmt_update) {
            $error_message = "Erro ao preparar a consulta de atualização da imagem: " . $conn->error;
            $_SESSION['register_error'] = $error_message;
            header("Location: ../registo.php");
            exit();
        }

        $stmt_update->bind_param("si", $image, $user_id);
        if (!$stmt_update->execute()) {
            $error_message = "Erro ao atualizar o caminho da imagem: " . $stmt_update->error;
            $_SESSION['register_error'] = $error_message;
            header("Location: ../registo.php");
            exit();
        }

        $stmt_update->close();

        $sql_buyer = "INSERT INTO buyers (user_id, student_number, school_year) VALUES (?, ?, ?)";
        $stmt_buyer = $conn->prepare($sql_buyer);
        if (!$stmt_buyer) {
            $error_message = "Erro ao preparar a consulta de inserção do estudante: " . $conn->error;
            $_SESSION['register_error'] = $error_message;
            header("Location: ../registo.php");
            exit();
        }

        $stmt_buyer->bind_param("iis", $user_id, $student_number, $curricular_year);
        if (!$stmt_buyer->execute()) {
            $error_message = "Erro ao inserir dados do estudante: " . $stmt_buyer->error;
            $_SESSION['register_error'] = $error_message;
            header("Location: ../registo.php");
            exit();
        }

        $stmt_buyer->close();
    }

    $_SESSION['register_success'] = "Registo concluído com sucesso!";
    header("Location: ../login.php");
    exit();
?>