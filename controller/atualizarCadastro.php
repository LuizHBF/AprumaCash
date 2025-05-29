<?php
    include '../model/conexao.php';
    session_start();

    $conexao = new Conexao();
    $con = $conexao->Conectar();

    $codUsu = $_POST['txtId'];
    $novoEmail = $_POST['novoEmail'];
    $novaSenha = $_POST['novaSenha'];
    $senhaAtual = $_POST['senhaAtual'];
    $novoTel = $_POST['novoTel'];

    // Buscar senha atual do banco
    $sqlBusca = "SELECT senhaUsu FROM usuario WHERE codUsu = :codUsu";
    $stmtBusca = $con->prepare($sqlBusca);
    $stmtBusca->bindParam(':codUsu', $codUsu);
    $stmtBusca->execute();
    $usuario = $stmtBusca->fetch(PDO::FETCH_ASSOC);

    // Se nova senha foi informada
    if (!empty($novaSenha)) {
        // Valida a senha atual
        if (!password_verify($senhaAtual, $usuario['senhaUsu'])) {
            header("Location: ../view/atualizarCadastroView.php?erro=senhaIncorreta");
            exit;
        }

        // Valida força da nova senha
        $padraoSenhaForte = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
        if (!preg_match($padraoSenhaForte, $novaSenha)) {
            header("Location: ../view/atualizarCadastroView.php?erro=senhaFraca");
            exit;
        }

        // Atualiza com nova senha
        $novaSenhaCriptografada = password_hash($novaSenha, PASSWORD_DEFAULT);
        $sql = "UPDATE usuario SET emailUsu = :novoEmail, senhaUsu = :novaSenha, telUsu = :novoTel WHERE codUsu = :codUsu";
        $stmt = $con->prepare($sql);
        $stmt->execute([
            'codUsu' => $codUsu,
            'novoEmail' => $novoEmail,
            'novaSenha' => $novaSenhaCriptografada,
            'novoTel' => $novoTel
        ]);
    } else {
        // Atualiza sem mexer na senha
        $sql = "UPDATE usuario SET emailUsu = :novoEmail, telUsu = :novoTel WHERE codUsu = :codUsu";
        $stmt = $con->prepare($sql);
        $stmt->execute([
            'codUsu' => $codUsu,
            'novoEmail' => $novoEmail,
            'novoTel' => $novoTel
        ]);
    }

    // Atualiza a sessão
    $_SESSION['emailUsu'] = $novoEmail;
    $_SESSION['telUsu'] = $novoTel;

    // Redireciona para login novamente
    session_destroy();
    header("Location: ../view/loginView.php?msg=relogin");
    exit;
?>