<?php
    session_start();
    
    // Verifica se o token é válido
    if (!isset($_GET['token']) || !isset($_SESSION['reset_token']) || 
        $_GET['token'] !== $_SESSION['reset_token'] || 
        time() > $_SESSION['reset_expires']) {
        header("Location: loginView.php?erro=tokenInvalido");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Senha</title>
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
        <h1>Defina sua Nova Senha</h1>
        <form action="../controller/atualizarSenha.php" method="POST">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
            <div class="mb-3">
                <label for="novaSenha" class="form-label">Nova Senha</label>
                <input type="password" class="form-control" id="novaSenha" name="novaSenha" required>
                <button type="button" class="btn btn-outline-secondary btn-no-hover" id="toggleSenha" style="position: absolute; border: none; margin-top: -33px; margin-left: 140px;">
                    <i id="iconeSenha" class="bi bi-eye-slash"></i>
                </button>
            </div>
            <div class="mb-3">
                <label for="confirmaSenha" class="form-label">Confirmar Nova Senha</label>
                <input type="password" class="form-control" id="confirmaSenha" name="confirmaSenha" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Redefinir Senha</button>
            <div id="mensagem" class="mt-3" style="display: none;"></div>
        </form>
    </div>

    <script>
        // Validação de senha
        const form = document.querySelector("form");
        form.addEventListener("submit", function(event) {
            const novaSenha = document.getElementById("novaSenha").value;
            const confirmaSenha = document.getElementById("confirmaSenha").value;
            const msg = document.getElementById("mensagem");

            // Regex para senha forte
            const senhaForteRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
            
            if (!senhaForteRegex.test(novaSenha)) {
                event.preventDefault();
                msg.textContent = "A senha deve conter no mínimo 8 caracteres, incluindo letra maiúscula, minúscula, número e caractere especial.";
                msg.className = "alert alert-danger mt-3";
                msg.style.display = "block";
                return;
            } else if (novaSenha !== confirmaSenha) {
                event.preventDefault();
                msg.textContent = "As senhas não coincidem, tente novamente.";
                msg.className = "alert alert-danger mt-3";
                msg.style.display = "block";
                return;
            }
        });

        // Icone de olho senha
        const toggleSenha = document.getElementById("toggleSenha");
        const senhaInput = document.getElementById("novaSenha");
        const iconeSenha = document.getElementById("iconeSenha");
            
        toggleSenha.addEventListener("click", () => {
            const tipo = senhaInput.getAttribute("type") === "password" ? "text" : "password";
            senhaInput.setAttribute("type", tipo);
        
            // Troca o ícone
            iconeSenha.classList.toggle("bi-eye");
            iconeSenha.classList.toggle("bi-eye-slash");
        });
    </script>
</body>
</html> 