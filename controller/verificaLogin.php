<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($_SESSION['codUsu'])) {
        header("Location: loginView.php?erro=acesso");
        exit();
    }
?>