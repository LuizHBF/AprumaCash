<?php
    session_start();

    if (!isset($_SESSION['codUsu'])) {
        header("Location: ../view/loginView.php?erro=acesso");
        exit();
    }

    include('../model/conexao.php');

    try {
        $conexao = new Conexao();
        $con = $conexao->Conectar();

        $codUsu = $_SESSION['codUsu'];

        // Inativa o usuário
        $sql = "UPDATE usuario SET ativo = 0 WHERE codUsu = :codUsu";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':codUsu', $codUsu, PDO::PARAM_INT);
        $stmt->execute();

        // Redireciona com mensagem ANTES de destruir a sessão
        session_unset();
        session_destroy();

        // Redirecionamento com o parâmetro de sucesso
        header("Location: ../view/loginView.php?msg=contaExcluida");
        exit;

    } catch (PDOException $e) {
        echo "Erro ao excluir conta: " . $e->getMessage();
    }
?>