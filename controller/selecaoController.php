<?php
    include("../model/conexao.php");
    session_start();
    
    // Verifica se o usuário está logado
    if (!isset($_SESSION['codUsu'])) {
        header("Location: ../view/loginView.php");
        exit();
    }
    
    // Só continua se for uma requisição POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Define as variáveis
        $perfilSelecionado = $_POST['choices'] ?? null;
        $codUsu = $_SESSION['codUsu'];
    
        // Verifica se o perfil é válido (1, 2 ou 3)
        if ($perfilSelecionado && in_array($perfilSelecionado, ['1', '2', '3'])) {
            $conexao = new Conexao();
            $con = $conexao->Conectar();
        
            $stmt = $con->prepare("UPDATE usuario SET perfilUsu = ? WHERE codUsu = ?");
            $stmt->execute([$perfilSelecionado, $codUsu]);
        
            if ($stmt->rowCount() > 0) {
                // Atualiza o perfil na sessão
                $_SESSION['perfilUsu'] = $perfilSelecionado;
            
                header("Location: ../view/carregamento.php");
                exit();
            } else {
                header("Location: ../view/carregamento.php");
            }
        } else {
            header ("Location: ../view/selecao.php?erro=valido");
        }
    } else {
        echo "Requisição inválida.";
    }
?>