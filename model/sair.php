<?php
    session_start();

    // Destroi todas as variáveis da sessão
    $_SESSION = array();

    // Se existir um cookie de sessão, o remove
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Encerra a sessão
    session_destroy();

    // Redireciona para login ou página inicial
    header("Location: ../view/index.html");
    exit();
?>