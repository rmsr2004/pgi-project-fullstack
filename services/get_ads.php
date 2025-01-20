<?php
include 'config.php';

// Conexão ao banco de dados
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Parâmetros de filtro e ordenação recebidos via GET
$order = isset($_GET['order']) && in_array($_GET['order'], ['asc', 'desc']) ? $_GET['order'] : 'asc';
$minPrice = isset($_GET['min_price']) ? (float) $_GET['min_price'] : 0;
$maxPrice = isset($_GET['max_price']) ? (float) $_GET['max_price'] : PHP_INT_MAX;

// Consulta SQL para obter anúncios com filtros e ordenação
$sql = "
    SELECT advertisements.*
    FROM advertisements
    WHERE advertisements.is_available = TRUE
    AND advertisements.price BETWEEN ? AND ?
    ORDER BY advertisements.price $order
";

$stmt = $conn->prepare($sql);
$stmt->bind_param('dd', $minPrice, $maxPrice);
$stmt->execute();
$result = $stmt->get_result();

$ads = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Busca a primeira imagem de cada anúncio
        $imageSql = "
            SELECT link
            FROM images
            WHERE address_id = ?
            LIMIT 1
        ";
        $imageStmt = $conn->prepare($imageSql);
        $imageStmt->bind_param('i', $row['id']);
        $imageStmt->execute();
        $imageResult = $imageStmt->get_result();
        $firstImage = $imageResult->num_rows > 0 ? $imageResult->fetch_assoc()['link'] : null;

        // Adiciona o anúncio com a primeira imagem ao array
        $ads[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'description' => $row['description'],
            'price' => $row['price'],
            'first_image' => $firstImage, // Primeira imagem do anúncio
        ];

        $imageStmt->close();
    }
}

// Retorna os anúncios como JSON
header('Content-Type: application/json');
echo json_encode($ads);

$stmt->close();
$conn->close();
?>