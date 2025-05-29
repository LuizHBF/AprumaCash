<?php
    include '../model/conexao.php';
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $token = $_POST['token'];
        $novaSenha = $_POST['novaSenha'];
        $confirmaSenha = $_POST['confirmaSenha'];

        // Verifica se o token é válido
        if (!isset($_SESSION['reset_token']) || 
            $token !== $_SESSION['reset_token'] || 
            time() > $_SESSION['reset_expires']) {
            header("Location: ../view/loginView.php?erro=tokenInvalido");
            exit;
        }

        // Verifica se as senhas coincidem
        if ($novaSenha !== $confirmaSenha) {
            header("Location: ../view/novaSenha.php?token=" . $token . "&erro=senhasDiferentes");
            exit;
        }

        // Valida força da senha
        $padraoSenhaForte = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
        if (!preg_match($padraoSenhaForte, $novaSenha)) {
            header("Location: ../view/novaSenha.php?token=" . $token . "&erro=senhaFraca");
            exit;
        }

        // Atualiza a senha no banco
        $conexao = new Conexao();
        $con = $conexao->Conectar();
        
        $email = $_SESSION['reset_email'];
        $novaSenhaCriptografada = password_hash($novaSenha, PASSWORD_DEFAULT);
        
        $sql = "UPDATE usuario SET senhaUsu = :novaSenha WHERE emailUsu = :email";
        $stmt = $con->prepare($sql);
        $stmt->execute([
            'novaSenha' => $novaSenhaCriptografada,
            'email' => $email
        ]);

        // Limpa os dados da sessão
        unset($_SESSION['reset_token']);
        unset($_SESSION['reset_email']);
        unset($_SESSION['reset_expires']);

        // Redireciona para o login com mensagem de sucesso
        header("Location: ../view/loginView.php?msg=senhaAlterada");
        exit;
    }
?> 