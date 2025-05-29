<?php
    include("../controller/verificaLogin.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações</title>
    <link rel="shortcut icon" href="./img/favicon.svg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./styles/config.css">
    <style>
        /*
        body.tema-claro {
            background-color: #fff;
            color: #000;
        }

        body.tema-escuro {
            background-color: #121212;
            color: #f1f1f1;
        }

        .tema-escuro .card {
            background-color: #1e1e1e;
            color: #f1f1f1;
        }

        .tema-escuro .navbar {
            background-color: #1c1c1c !important;
        }

        .tema-claro .navbar {
            background-color: #2CAA37 !important;
        }*/

        .btn-primary {
            background-color: #1D1994;
            border: 2px solid #1D1994;
        }
        .btn-primary:hover {
            background-color: #120F59;
            transition: 0.23s;
            border: 2px solid #120F59;
        }
        .btn-outline-primary {
            border: 2px solid #1D1994;
            color: #1D1994;
        }
        .btn-outline-primary:hover {
            border: 2px solid #120F59;
            background-color: #120F59;
            transition: 0.23s;
        }
        .sobre-nos-content {
            transition: max-height 0.5s ease-in-out;
            max-height: 0;
        }
        .sobre-nos-content.show {
            max-height: 1000px;
        }
        .toggle-icon {
            transition: transform 0.3s ease;
        }
        .toggle-icon.rotate {
            transform: rotate(180deg);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="index.html">
                <img id="logo" src="./img/logo_tema_escuro.svg" alt="logo" height="50">
            </a>
            <h1 class="text-white h5 m-0">Configurações</h1>
            <div>
                <img id="iconU" src="./img/user_escuro.svg" alt="Perfil" onclick="window.location.href='perfil.php'" width="30" class="me-3">
                <img id="iconS" src="./img/settings_escuro.svg" alt="Configurações" onclick="window.location.href='config.php'" width="30">
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <div class="card p-4 shadow">
            <div class="mt-3">
                <h5>Feedback e Ajuda</h5>
                <p>Contribua com sugestões ou tire dúvidas sobre o sistema.</p>

                <button class="btn btn-primary btn-custom mb-2" onclick="window.location.href='feedback.php'">Enviar feedback</button>

                <button class="btn btn-primary btn-custom mb-2" onclick="window.location.href='faq.php'">Ver perguntas frequentes</button>
                <hr>
            </div>

            <div class="mt-3">
                <h5 class="d-flex justify-content-between align-items-center" style="cursor: pointer;" onclick="toggleSobreNos()">
                    Sobre Nós
                    <span class="toggle-icon">▼</span>
                </h5>
                <div id="sobreNosContent" class="sobre-nos-content" style="display: none; overflow: hidden;">
                    <div class="card bg-light p-3 mb-3">
                        <h6 class="mb-3"><b>Nossa Equipe de Desenvolvimento</b></h6>
                        <p class="mb-2">Somos uma equipe apaixonada por tecnologia e inovação, dedicada a criar soluções que transformam a maneira como as pessoas gerenciam suas finanças.</p>
                        <p class="mb-2">Nossa missão é desenvolver ferramentas que simplifiquem a vida financeira dos usuários, combinando tecnologia de ponta com uma interface intuitiva e amigável.</p>
                    </div>
                    <button class="btn btn-primary btn-custom mb-2 mt-2" onclick="window.location.href='sobre.php'">Conheça mais sobre nós</button>
                </div>
                <hr>
            </div>

            <div class="d-flex justify-content-center gap-2">
                <button class="btn btn-outline-primary" onclick="window.location.href='oficina.php'">Voltar</button>
            </div>
        </div>
    </div>
    <script src="tema.js"></script>
    <script>
        function toggleSobreNos() {
            const content = document.getElementById('sobreNosContent');
            const icon = document.querySelector('.toggle-icon');
            
            if (content.style.display === 'none') {
                content.style.display = 'block';
                setTimeout(() => {
                    content.classList.add('show');
                    icon.classList.add('rotate');
                }, 10);
            } else {
                content.classList.remove('show');
                icon.classList.remove('rotate');
                setTimeout(() => {
                    content.style.display = 'none';
                }, 500);
            }
        }
    </script>
</body>
</html>
