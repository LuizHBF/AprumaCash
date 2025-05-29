<?php
    session_start();
    
    if (!isset($_SESSION['codUsu'])) {
        // Redireciona para a tela de login se a sessão não estiver iniciada
        header("Location: loginView.php?erro=acesso");
        exit();
    }

    include("../controller/verificaLogin.php");

    // Pegando o nome e perfil do usuário da sessão
    $nome = $_SESSION['nomeUsu'] ?? 'Usuário';
    $codUsu = $_SESSION['codUsu'];  // Definindo a variável $codUsu a partir da sessão

    try {
        include("../model/conexao.php");
        $conexao = new Conexao();
        $con = $conexao->Conectar();
    
        // Consultar o nome do perfil baseado no codUsu
        $stmt = $con->prepare("
            SELECT p.nomePerfil
            FROM usuario u
            JOIN perfil p ON u.perfilUsu = p.codPerfil
            WHERE u.codUsu = ?
        ");
        $stmt->execute([$codUsu]);
    
        // Obter o perfil do usuário
        $perfil = $stmt->fetchColumn();
    
        // Caso o perfil não seja encontrado, exibe 'Não definido'
        if (!$perfil) {
            $perfil = 'Não definido';
        }
    
    } catch (PDOException $e) {
        $perfil = 'Erro ao buscar perfil';
    }

    /* O PHP pega a hora atual do sistema no formato 24 horas, porém retorna somente a hora (de 00 a 23).
    Exemplo:
    
    - Se forem 08:30, $hora será 8
    - Se forem 14:45, $hora será 14
    - Se forem 21:10, $hora será 21*/

    // Define a saudação com base na hora atual
    date_default_timezone_set('America/Sao_Paulo'); // Define o fuso horário
    $hora = date('H');

    if ($hora >= 5 && $hora < 12) {
        $saudacao = "Bom dia";
    } elseif ($hora >= 12 && $hora < 18) {
        $saudacao = "Boa tarde";
    } else {
        $saudacao = "Boa noite";
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="shortcut icon" href="./img/favicon.svg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./styles/perfil.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #2CAA37;">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="index.html">
                <img id="logo" src="./img/logo_tema_escuro.svg" alt="logo" height="50">
            </a>
            <h1 class="text-white h5 m-0">Perfil</h1>
            <div>
                <img id="iconU" src="./img/user_escuro.svg" alt="Perfil" onclick="window.location.href='perfil.php'" width="30" class="me-3">
                <img id="iconS" src="./img/settings_escuro.svg" alt="Configurações" onclick="window.location.href='config.php'" width="30">
            </div>
        </div>
    </nav>
    
    <div class="container pt-5 d-flex justify-content-center align-items-center row mt-5">
        <div class="text-center mb-5">
            <h3 class="text-success fw-bold"><?= $saudacao ?>, <?= htmlspecialchars($nome) ?>!</h3>
            <p class="text-muted">Perfil atual: <strong><?= htmlspecialchars($perfil) ?></strong></p>
            <p class="text-muted">Gerencie suas informações com facilidade aqui no seu perfil.</p>
        </div>
        <div class="container-box">
            <div class="mb-4">
                <button class="btn btn-primary btn-custom mb-1" onclick="window.location.href='atualizarCadastroView.php'">Atualizar cadastro</button>
                <button class="btn btn-primary btn-custom mb-1" onclick="window.location.href='selecao.php'">Atualizar perfil</button>
                <button class="btn btn-primary btn-custom mb-1" id="btnSair">Sair da conta</button>
            </div>
            <div class="d-flex justify-content-center gap-2">
                <button class="btn btn-outline-primary" onclick="window.location.href='mailto:suporteAprumaCash@gmail.com'">Suporte</button>
                <button class="btn btn-outline-primary" onclick="window.location.href='oficina.php'">Voltar</button>
            </div>
            <button class="btn text-danger d-block mx-auto mt-3" id="btnExcluirConta">Excluir conta</button>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>   
    <script>
        // Confirmação sair da conta (encerrar sessão)
        document.getElementById('btnSair').addEventListener('click', function(e) {
            e.preventDefault();
                
            Swal.fire({
                title: 'Tem certeza?',
                text: "Essa ação encerrará está sessão. Você deverá se logar novamente caso queira retornar o acesso!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Sim, sair',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../model/sair.php";
                }
            });
        });

        // Excluir a conta do banco
        document.getElementById('btnExcluirConta').addEventListener('click', function(e) {
            e.preventDefault();
                
            Swal.fire({
                title: 'Tem certeza?',
                text: "Essa ação é irreversível. Sua conta será permanentemente excluída!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Sim, excluir',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "../controller/excluir.php";
                }
            });
        });
    </script>  
</body>
</html>