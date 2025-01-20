<?php
    include 'config.php';
    session_start();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $is_available = 1; // Sempre disponível inicialmente
    $address_street = $_POST['address_street'];
    $address_number = $_POST['address_number'];
    $address_zip_code = $_POST['address_zip_code'];
    $address_city = $_POST['address_city'];
    $owner_name = $_POST['owner_name'];
    $owner_description = $_POST['owner_description'];
    $conditions = $_POST['conditions'];

    if (isset($_FILES['owner_image']) && $_FILES['owner_image']['error'] === UPLOAD_ERR_OK) {
        $owner_image_tmp = $_FILES['owner_image']['tmp_name'];
        $owner_image_name = basename($_FILES['owner_image']['name']);
    } else {
        die("Erro: A imagem do senhorio é obrigatória.");
    }

    try {
        $sql = "INSERT INTO advertisements (title, description, price, is_available, address_street, address_number, address_zip_code, address_city, owner_name, owner_description, conditions) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Erro na preparação da consulta: " . $conn->error);
        }

        // Associar os parâmetros à consulta
        $stmt->bind_param(
            "ssississsss",
            $title,
            $description,
            $price,
            $is_available,
            $address_street,
            $address_number,
            $address_zip_code,
            $address_city,
            $owner_name,
            $owner_description,
            $conditions
        );

        // Executar a consulta e verificar o resultado
        if ($stmt->execute()) {
            $advertisement_id = $stmt->insert_id; // ID do anúncio recém-criado

            // Criar o diretório para armazenar as imagens
            $upload_dir = "../images/ads/" . $advertisement_id . "/";
            if (!file_exists($upload_dir)) {
                if (!mkdir($upload_dir, 0777, true)) {
                    die("Erro ao criar o diretório de upload.");
                }
            }

            // Determinar o caminho para a imagem do senhorio
            $owner_image_path = $upload_dir . $owner_image_name;

            // Salvar a imagem do senhorio no servidor
            if (!move_uploaded_file($owner_image_tmp, $owner_image_path)) {
                die("Erro ao salvar a imagem do senhorio.");
            }

            // Atualizar o registro do anúncio com o caminho da imagem
            $sql_update = "UPDATE advertisements SET owner_image = ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            if ($stmt_update) {
                $stmt_update->bind_param("si", $owner_image_path, $advertisement_id);
                $stmt_update->execute();
                $stmt_update->close();
            }

            // Salvar as imagens adicionais associadas ao anúncio
            if (isset($_FILES['an_images']['tmp_name']) && count($_FILES['an_images']['tmp_name']) > 0) {
                foreach ($_FILES['an_images']['tmp_name'] as $key => $tmp_name) {
                    $file_name = $_FILES['an_images']['name'][$key];
                    $file_tmp = $_FILES['an_images']['tmp_name'][$key];
                    $file_path = $upload_dir . basename($file_name);

                    // Verificar se o arquivo foi carregado com sucesso
                    if (move_uploaded_file($file_tmp, $file_path)) {
                        // Inserir o caminho da imagem na tabela images
                        $sql_image = "INSERT INTO images (link, address_id) VALUES (?, ?)";
                        $stmt_image = $conn->prepare($sql_image);
                        if ($stmt_image) {
                            $stmt_image->bind_param("si", $file_path, $advertisement_id);
                            $stmt_image->execute();
                            $stmt_image->close();
                        }
                    }
                }
            }

            // Redirecionar para a página de anúncios
            header("Location: ../advertisements.php");
        } else {
            echo "Erro ao criar o anúncio: " . $stmt->error;
        }
    } catch (Exception $e) {
        echo "Erro inesperado: " . $e->getMessage();
    } finally {
        // Fechar conexões
        if ($stmt) {
            $stmt->close();
        }
        if ($conn) {
            $conn->close();
        }
    }
?>
