<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperação de Senha</title>
    <link rel="shortcut icon" href="./img/favicon.svg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./styles/login.css">
</head>
<body>
    <div class="position-absolute" style="margin-top: -75vh;">
        <a href="index.html"><img id="logo" src="./img/logo_tema_claro.svg" alt="logo" width="120px"></a>
    </div>
    <div class="container text-center">
        <h1>Recuperação de Senha</h1>
        <form action="../controller/recuperarSenha.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Digite seu email cadastrado</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Enviar Link de Recuperação</button>
            <div id="mensagem" class="mt-3" style="display: none;"></div>
        </form>
        <a href="loginView.php" class="d-block mt-3 text-decoration-none">Voltar para o Login</a>
    </div>

    <script>
        // Exibe mensagens com base no parâmetro da URL
        document.addEventListener("DOMContentLoaded", () => {
            const params = new URLSearchParams(window.location.search);
            const status = params.get("status");
            const msg = document.getElementById("mensagem");

            if (status && msg) {
                msg.style.display = "block";
                
                switch (status) {
                    case "enviado":
                        msg.textContent = "Email de recuperação enviado com sucesso!";
                        msg.className = "alert alert-success mt-3";
                        break;
                    case "erro":
                        msg.textContent = "Erro ao enviar email. Tente novamente mais tarde.";
                        msg.className = "alert alert-danger mt-3";
                        break;
                    case "naoEncontrado":
                        msg.textContent = "Email não encontrado em nossa base de dados.";
                        msg.className = "alert alert-warning mt-3";
                        break;
                }
            }
        });
    </script>
</body>
</html> 