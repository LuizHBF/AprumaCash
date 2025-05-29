<?php
    if (isset($_GET['msg']) && $_GET['msg'] === 'relogin') {
        echo "<div id='alertRelogin' class='alert alert-success text-center' style='position: relative; z-index: 1;'>Dados atualizados! Faça login novamente.</div>";
    }

    if (isset($_GET['msg']) && $_GET['msg'] === 'contaExcluida') {
        echo "<div id='alertExclui' class='alert alert-success text-center' style='position: relative; z-index: 1;'>Conta excluída com sucesso.</div>";
    }

    if (isset($_GET['msg']) && $_GET['msg'] === 'senhaAlterada') {
        echo "<div id='alertSenha' class='alert alert-success text-center' style='position: relative; z-index: 1;'>Senha alterada com sucesso! Faça login com sua nova senha.</div>";
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" href="./img/favicon.svg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./styles/login.css">
    <style>
        .btn-no-hover:hover{
            background-color: transparent !important;
            color: inherit !important;
            box-shadow: none !important;
        }

        #alertRelogin, #alertExclui {
            transition: opacity 0.5s ease;
            margin-top: 40px; /* espaço entre a logo e o alerta */
        }
    </style>
</head>
<body>
    <div class="position-absolute" style="margin-top: -75vh;">
        <a href="index.html"><img id="logo" src="./img/logo_tema_claro.svg" alt="logo" width="120px"></a>
    </div>
    <div class="container text-center">
        <h1>Faça seu Login</h1>
        <form action="../model/login.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
                <button type="button" class="btn btn-outline-secondary btn-no-hover" id="toggleSenha" style="position: absolute; border: none; margin-top: -33px; margin-left: 140px;">
                    <i id="iconeSenha" class="bi bi-eye-slash"></i>
                </button>
            </div>
            <button type="submit" class="btn btn-primary w-100">Continuar</button>
            <div id="mensagem-erro" class="text-danger mt-3" style="display: none;"></div>
        </form>
        <a href="esqueciSenha.php" class="d-block mt-3 text-decoration-none">Esqueci minha senha</a>
        <a href="cadastro.html" class="d-block mt-1 text-decoration-none">Cadastre-se</a>
    </div>
    <!--<label class="theme">
        <input class="theme-toggle input" checked="checked" type="checkbox" onclick="toggleTheme()">
        <svg width="24" viewBox="0 0 24 24" stroke-width="2" stroke-linejoin="round" stroke-linecap="round" stroke="currentColor" height="24" fill="none" class="icon icon-sun"><circle r="5" cy="12" cx="12"></circle><line y2="3" y1="1" x2="12" x1="12"></line><line y2="23" y1="21" x2="12" x1="12"></line><line y2="5.64" y1="4.22" x2="5.64" x1="4.22"></line><line y2="19.78" y1="18.36" x2="19.78" x1="18.36"></line><line y2="12" y1="12" x2="3" x1="1"></line><line y2="12" y1="12" x2="23" x1="21"></line><line y2="18.36" y1="19.78" x2="5.64" x1="4.22"></line><line y2="4.22" y1="5.64" x2="19.78" x1="18.36"></line></svg>
        <svg viewBox="0 0 24 24" class="icon icon-moon"><path d="m12.3 4.9c.4-.2.6-.7.5-1.1s-.6-.8-1.1-.8c-4.9.1-8.7 4.1-8.7 9 0 5 4 9 9 9 3.8 0 7.1-2.4 8.4-5.9.2-.4 0-.9-.4-1.2s-.9-.2-1.2.1c-1 .9-2.3 1.4-3.7 1.4-3.1 0-5.7-2.5-5.7-5.7 0-1.9 1.1-3.8 2.9-4.8zm2.8 12.5c.5 0 1 0 1.4-.1-1.2 1.1-2.8 1.7-4.5 1.7-3.9 0-7-3.1-7-7 0-2.5 1.4-4.8 3.5-6-.7 1.1-1 2.4-1 3.8-.1 4.2 3.4 7.6 7.6 7.6z"></path></svg>
    </label>-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

        // Icone de olho senha
        const toggleSenha = document.getElementById("toggleSenha");
        const senhaInput = document.getElementById("senha");
        const iconeSenha = document.getElementById("iconeSenha");
            
        toggleSenha.addEventListener("click", () => {
          const tipo = senhaInput.getAttribute("type") === "password" ? "text" : "password";
          senhaInput.setAttribute("type", tipo);
        
          // Troca o ícone
          iconeSenha.classList.toggle("bi-eye");
          iconeSenha.classList.toggle("bi-eye-slash");
        });

        // Tratamento de erros (mensagens)
        const params = new URLSearchParams(window.location.search);
        const erro = params.get("erro");
        const msgErro = document.getElementById("mensagem-erro");

        if (erro) {
            msgErro.style.display = "block";

            switch (erro) {
                case "usuSenha":
                    msgErro.textContent = "Usuário ou senha incorreto, tente novamente.";
                    break;
                case "inexistente":
                    msgErro.textContent = "Usuário não encontrado, tente novamente.";
                    break;
                case "acesso":
                    msgErro.textContent = "Faça login ou cadastre-se.";
                    break;
                default:
                    msgErro.textContent = "Erro desconhecido.";
            }
        }

        // Mensagem temporario de dados atualizados
        setTimeout(() => {
            const alerta = document.getElementById('alertRelogin');
            if (alerta) {
                alerta.style.opacity = '0'; // animação de sumir
                setTimeout(() => alerta.remove(), 500); // remove do DOM após fade
            }
        }, 1500); // 1,5 segundos

        // Mensagem temporario de conta excluida
        setTimeout(() => {
            const alerta = document.getElementById('alertExclui');
            if (alerta) {
                alerta.style.opacity = '0'; // animação de sumir
                setTimeout(() => alerta.remove(), 500); // remove do DOM após fade
            }
        }, 1500); // 1,5 segundos

        // Mensagem temporária de senha alterada
        setTimeout(() => {
            const alerta = document.getElementById('alertSenha');
            if (alerta) {
                alerta.style.opacity = '0';
                setTimeout(() => alerta.remove(), 500);
            }
        }, 1500);
    </script>
</body>
</html>
