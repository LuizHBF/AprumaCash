<?php
    // echo "cheguei aqui <br>"; // debug
    session_start(); // Inicia a sessão

    if (isset($_POST['email']) && isset($_POST['senha'])) {
        include("conexao.php");
    
        $classe_con = new Conexao();
        $con = $classe_con->Conectar();
    
        $email = $_POST['email'];
        $senha = $_POST['senha'];
    
        $sql = "SELECT * FROM usuario WHERE emailUsu = :email AND ativo = 1 LIMIT 1";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($usuario && password_verify($senha, $usuario['senhaUsu'])) {
            // Guarda informações na sessão
            $_SESSION['codUsu'] = $usuario['codUsu'];
            $_SESSION['emailUsu'] = $usuario['emailUsu'];
            $_SESSION['nomeUsu'] = $usuario['nomeUsu'];
            header("Location: ../view/carregamento.php");
            exit;
        } else {
            header("Location: ../view/loginView.php?erro=usuSenha");
            exit;
        }
    } else {
        header("Location: ../view/loginView.php?erro=inexistente");
        exit;
    }
?>
