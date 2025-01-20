<?php
session_start();

// Limpa todos os dados da sessão
$_SESSION = [];

// Destroi a sessão no servidor
session_destroy();

// Define um cookie com validade expirada para eliminar a sessão do navegador
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, 
        $params["path"], $params["domain"], 
        $params["secure"], $params["httponly"]
    );
}

// Redireciona para a página de login ou página inicial
header("Location: index.php");
exit();
?>