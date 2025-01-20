<?php
    include 'config.php';

    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    $advertisement_id = $_POST['advertisement_id'];

    $sql_check = "SELECT is_available FROM advertisements WHERE id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $advertisement_id);
    $stmt_check->execute();
    $stmt_check->bind_result($is_available);
    $stmt_check->fetch();
    $stmt_check->close();

    $new_availability = $is_available ? 0 : 1;

    $sql_update = "UPDATE advertisements SET is_available = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ii", $new_availability, $advertisement_id);

    if ($stmt_update->execute()) {
        echo "Disponibilidade do anúncio alterada com sucesso!";
    } else {
        echo "Erro ao alterar a disponibilidade: " . $stmt_update->error;
    }
    
    $stmt_update->close();
    $conn->close();
?>
