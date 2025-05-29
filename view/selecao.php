<?php
    session_start();

    if (!isset($_SESSION['codUsu'])) {
        header("Location: loginView.php?erro=acesso");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleção de Perfil</title>
    <link rel="shortcut icon" href="./img/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./styles/selecao.css">
</head>
<body>
    <div class="position-absolute" style="margin-top: -75vh;">
        <a href="index.html"><img id="logo" src="./img/logo_tema_claro.svg" alt="logo" width="120px"></a>
    </div>
    <div class="container container-custom mt-5">
        <h1 class="mb-4">Selecione seu perfil</h1>
        <form action="../controller/selecaoController.php" method="POST">
            <div class="form-check option">
                <input class="form-check-input" type="radio" id="option1" name="choices" value="1">
                <label class="form-check-label" for="option1"><strong>Profissional Online</strong></label>
                <p>Um profissional online é alguém que trabalha de forma remota, através da internet, para desenvolver, criar, programar e manter serviços digitais.</p>
            </div>
            <div class="form-check option">
                <input class="form-check-input" type="radio" id="option2" name="choices" value="2">
                <label class="form-check-label" for="option2"><strong>Profissional Físico</strong></label>
                <p>Um profissional que trabalha de maneira física é aquele que possui um estabelecimento comercial que opera em um ponto comercial, geralmente localizado na área central da cidade.</p>
            </div>
            <div class="form-check option">
                <input class="form-check-input" type="radio" id="option3" name="choices" value="3">
                <label class="form-check-label" for="option3"><strong>Profissional Ambulante</strong></label>
                <p>Um profissional ambulante é uma pessoa que vende produtos ou presta serviços de forma itinerante, sem um local fixo de trabalho.</p>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-3">Continuar</button>
            <div id="mensagem-erro" class="text-danger mt-3" style="display: none;"></div>
        </form>
    </div>
    <!--<label class="theme">
        <input class="theme-toggle input" checked="checked" type="checkbox" onclick="toggleTheme()">
        <svg width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="24" fill="none" class="icon icon-sun"><circle r="5" cy="12" cx="12"></circle><line y2="3" y1="1" x2="12" x1="12"></line><line y2="23" y1="21" x2="12" x1="12"></line><line y2="5.64" y1="4.22" x2="5.64" x1="4.22"></line><line y2="19.78" y1="18.36" x2="19.78" x1="18.36"></line><line y2="12" y1="12" x2="3" x1="1"></line><line y2="12" y1="12" x2="23" x1="21"></line><line y2="18.36" y1="19.78" x2="5.64" x1="4.22"></line><line y2="4.22" y1="5.64" x2="19.78" x1="18.36"></line></svg>
        <svg viewBox="0 0 24 24" class="icon icon-moon"><path d="m12.3 4.9c.4-.2.6-.7.5-1.1s-.6-.8-1.1-.8c-4.9.1-8.7 4.1-8.7 9 0 5 4 9 9 9 3.8 0 7.1-2.4 8.4-5.9.2-.4 0-.9-.4-1.2s-.9-.2-1.2.1c-1 .9-2.3 1.4-3.7 1.4-3.1 0-5.7-2.5-5.7-5.7 0-1.9 1.1-3.8 2.9-4.8zm2.8 12.5c.5 0 1 0 1.4-.1-1.2 1.1-2.8 1.7-4.5 1.7-3.9 0-7-3.1-7-7 0-2.5 1.4-4.8 3.5-6-.7 1.1-1 2.4-1 3.8-.1 4.2 3.4 7.6 7.6 7.6z"></path></svg>
    </label>-->
    <script>
        /*function toggleTheme() {
            document.body.classList.toggle('dark-theme');

            const logo = document.getElementById("logo");

            // Alterna a imagem da logo
            if (document.body.classList.contains("dark-theme")) {
                logo.src = "./img/logo_tema_escuro.svg"; // Logo para o tema escuro
            } else {
                logo.src = "./img/logo_tema_claro.svg"; // Logo para o tema claro
            }
        }*/

        // Tratamento de erros (mensagens)
        const params = new URLSearchParams(window.location.search);
        const erro = params.get("erro");
        const msgErro = document.getElementById("mensagem-erro");

        if (erro) {
            msgErro.style.display = "block";

            switch (erro) {
                case "valido":
                    msgErro.textContent = "Selecione um perfil e tente novamente.";
                    break;
                default:
                    msgErro.textContent = "Erro desconhecido.";
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>