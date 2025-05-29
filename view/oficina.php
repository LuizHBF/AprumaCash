<?php
    include("../controller/verificaLogin.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambiente de Ferramentas</title>
    <link rel="shortcut icon" href="./img/favicon.svg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./styles/oficina.css">
</head>
<body class="d-flex flex-column align-items-center vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="index.html">
                <img id="logo" src="./img/logo_tema_escuro.svg" alt="logo">
            </a>
            <h1 class="text-white h5 m-0 titulo-navbar">Ambiente de Ferramentas</h1>
            <div class="d-flex align-items-center icons-navbar">
                <img id="iconU" src="./img/user_escuro.svg" alt="Perfil" onclick="window.location.href='perfil.php'" width="30" class="me-3">
                <img id="iconS" src="./img/settings_escuro.svg" alt="Configurações" onclick="window.location.href='config.php'" width="30">
            </div>
        </div>
    </nav>
    
    <div class="container mt-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-md-5 mt-3 mb-3">
                <div class="card text-center shadow p-4">
                    <h2 class="card-title">Projeção</h2>
                    <hr style="border: 1px solid #666; border-radius: 10px; margin-bottom: 7px; margin-top: -1px;">
                    <p class="card-text">Calcule quanto tempo e quais recursos são necessários para atingir sua meta financeira.</p>
                    <button class="btn btn-primary" onclick="window.location.href='ferramentas/projecao.php'">Entrar na ferramenta</button>
                </div>
            </div>

            <div class="col-md-5 mt-3 mb-3">
                <div class="card text-center shadow p-4">
                    <h2 class="card-title">Lucro/Despesas</h2>
                    <hr style="border: 1px solid #666; border-radius: 10px; margin-bottom: 7px; margin-top: -1px;">
                    <p class="card-text">Ferramenta simples e eficiente para registrar e controlar lucros e despesas de forma organizada.</p>
                    <button class="btn btn-primary" onclick="window.location.href='ferramentas/pagamentos.php'">Entrar na ferramenta</button>
                </div>
            </div>

            <div class="col-md-5 mt-3 mb-3">
                <div class="card text-center shadow p-4">
                    <h2 class="card-title">Produtos</h2>
                    <hr style="border: 1px solid #666; border-radius: 10px; margin-bottom: 7px; margin-top: -1px;">
                    <p class="card-text">Permite o registro e o gerenciamento dos seus produtos e/ou serviços oferecidos.</p>
                    <button class="btn btn-primary" onclick="window.location.href='ferramentas/produtos.php'">Entrar na ferramenta</button>
                </div>
            </div>

            <div class="col-md-5 mt-3 mb-3">
                <div class="card text-center shadow p-4">
                    <h2 class="card-title">Calculadora de venda</h2>
                    <hr style="border: 1px solid #666; border-radius: 10px; margin-bottom: 7px; margin-top: -1px;">
                    <p class="card-text">Cálculo do preço de venda ideal com base no custo e na margem de lucro desejada.</p>
                    <button class="btn btn-primary" onclick="window.location.href='ferramentas/calculadora.php'">Entrar na ferramenta</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
