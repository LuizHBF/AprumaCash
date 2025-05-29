<?php
    include("../controller/verificaLogin.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nós - AprumaCash</title>
    <link rel="shortcut icon" href="./img/favicon.svg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./styles/config.css">
    <style>
        .team-member-card {
            transition: transform 0.3s ease;
        }
        .team-member-card:hover {
            transform: translateY(-5px);
        }
        .btn-primary {
            background-color: #1D1994;
            border: 2px solid #1D1994;
        }
        .btn-primary:hover {
            background-color: #120F59;
            transition: 0.23s;
            border: 2px solid #120F59;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="index.html">
                <img id="logo" src="./img/logo_tema_escuro.svg" alt="logo" height="50">
            </a>
            <h1 class="text-white h5 m-0">Sobre Nós</h1>
            <div>
                <img id="iconU" src="./img/user_escuro.svg" alt="Perfil" onclick="window.location.href='perfil.php'" width="30" class="me-3">
                <img id="iconS" src="./img/settings_escuro.svg" alt="Configurações" onclick="window.location.href='config.php'" width="30">
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <div class="card p-4 shadow mb-4">
            <h2 class="mb-4">Nossa História</h2>
            <p class="lead">O AprumaCash nasceu de um Projeto de Conclusão de Curso (TCC), na Escola Técnica Estadual Dr. Emílio Hernandez Aguilar, da necessidade de simplificar a gestão financeira de profissionais autônomos.</p>
            <p>Nossa jornada começou com uma visão clara: criar uma plataforma que unisse simplicidade e poder, permitindo que qualquer usuário tivessem acesso a ferramentas financeiras de alta qualidade.</p>
        </div>

        <div class="card p-4 shadow mb-4">
            <h2 class="mb-4">Nossa Equipe</h2>
            <p class="lead">Somos uma equipe composta por 4 desenvolvedores</p>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card team-member-card h-70">
                        <div class="card-body text-center">
                            <img src="./img/Luiz.png" alt="Desenvolvedor" class="rounded-circle mb-3" width="120">
                            <h5 class="card-title text-muted">Luiz <br> Henrique</h5>
                        </div>
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <a href="https://github.com/LuizHBF" target="_blank" class="btn btn-primary">Saiba Mais</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card team-member-card h-70">
                        <div class="card-body text-center">
                            <img src="./img/Rodrigo.png" alt="Designer" class="rounded-circle mb-3" width="120">
                            <h5 class="card-title text-muted">Rodrigo Jordão</h5>
                        </div>
                        <div class="d-flex justify-content-center gap-2 mb-3">
                        <a href="https://github.com/RodrigoJK48" target="_blank" class="btn btn-primary">Saiba Mais</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card team-member-card h-70">
                        <div class="card-body text-center">
                            <img src="./img/Guilherme.png" alt="Analista" class="rounded-circle mb-3" width="120">
                            <h5 class="card-title text-muted">Guilherme Oliveira</h5>
                        </div>
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <a href="https://github.com/Guilherme23-br" target="_blank" class="btn btn-primary">Saiba Mais</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card team-member-card h-70">
                        <div class="card-body text-center">
                            <img src="./img/moyses.png" alt="Analista" class="rounded-circle mb-3" width="120">
                            <h5 class="card-title text-muted">Moysés Antunes</h5>
                        </div>
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <a href="https://github.com/moyses-antunese" target="_blank" class="btn btn-primary">Saiba Mais</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card p-4 shadow mb-4">
            <h2 class="mb-4">Nossa Missão</h2>
            <p>Transformar a maneira como as empresas gerenciam suas finanças, oferecendo uma plataforma intuitiva, segura e eficiente que simplifica processos e impulsiona o crescimento dos negócios.</p>
        </div>

        <div class="d-flex justify-content-center gap-2">
            <button class="btn btn-primary" onclick="window.location.href='config.php'">Voltar</button>
        </div>
    </div>

    <script src="tema.js"></script>
</body>
</html> 