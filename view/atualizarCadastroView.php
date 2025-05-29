<?php
    session_start();

    // Verifica se o usuário está logado
    if (!isset($_SESSION['codUsu'])) {
        header("Location: loginView.php?erro=acesso");
        exit;
    }

    include ("../model/conexao.php");

    $conexao = new Conexao();
    $con = $conexao->Conectar();

    $sql = "SELECT * FROM usuario WHERE codUsu = :codUsu";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':codUsu', $_SESSION['codUsu'], PDO::PARAM_INT);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        echo "<div class='alert alert-danger mt-5 pt-5 text-center'>Usuário não encontrado!</div>";
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualização de Cadastro</title>
    <link rel="shortcut icon" href="./img/favicon.svg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./styles/perfil.css">
    <style>
        .btn-no-hover:hover{
            background-color: transparent !important;
            color: inherit !important;
            box-shadow: none !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #2CAA37;">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="index.html">
                <img id="logo" src="./img/logo_tema_escuro.svg" alt="logo" height="50">
            </a>
            <h1 class="text-white h5 m-0">Atualização de Cadastro</h1>
            <div>
                <img id="iconU" src="./img/user_escuro.svg" alt="Perfil" onclick="window.location.href='perfil.php'" width="30" class="me-3">
                <img id="iconS" src="./img/settings_escuro.svg" alt="Configurações" onclick="window.location.href='config.php'" width="30">
            </div>
        </div>
    </nav>
    
    <div class="container mt-4 pt-5 d-flex justify-content-center align-items-center">
        <div class="container-box  w-100">
            <form action="../controller/atualizarCadastro.php" method="POST">
                <input type="hidden" name="txtId" value="<?php echo($usuario['codUsu']); ?>" />
            
                <div class="mb-3">
                    <label for="novoEmail" class="form-label">Email atual</label>
                    <input type="email" class="form-control" id="novoEmail" name="novoEmail" value="<?php echo($usuario['emailUsu']);?>">
                </div>
                <div class="mb-3 position-relative">
                    <label for="senhaAtual" class="form-label">Senha atual</label>
                    <input type="password" class="form-control" id="senhaAtual" name="senhaAtual">
                    <button type="button" class="btn btn-outline-secondary btn-no-hover" id="toggleSenhaAtual" style="position: absolute; border: none; top: 35px; right: 5px;">
                        <i id="iconeSenhaAtual" class="bi bi-eye-slash"></i>
                    </button>
                </div>

                <div class="mb-3 position-relative">
                    <label for="novaSenha" class="form-label">Nova senha (opcional)</label>
                    <input type="password" class="form-control" id="novaSenha" name="novaSenha">
                    <button type="button" class="btn btn-outline-secondary btn-no-hover" id="toggleNovaSenha" style="position: absolute; border: none; top: 35px; right: 5px;">
                        <i id="iconeNovaSenha" class="bi bi-eye-slash"></i>
                    </button>
                </div>
                <div class="mb-3">
                    <label for="novoTel" class="form-label">Telefone atual</label>
                    <input type="text" class="form-control" id="novoTel" name="novoTel" placeholder="(00) 00000-0000" value="<?php echo($usuario['telUsu']);?>">
                </div>
                <button type="submit" class="btn btn-primary w-100">Atualizar</button>
                <p id="msgErro" class="text-danger text-center" style="display: none; margin-top: 8px; margin-bottom: -15px;"></p>
            </form>
            <br>
            <div class="d-flex justify-content-center gap-2">
                <button class="btn btn-outline-primary" onclick="window.location.href='mailto:suporteAprumaCash@gmail.com'">Suporte</button>
                <button class="btn btn-outline-primary" onclick="window.location.href='perfil.php'">Voltar</button>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        // Exibe mensagens de erro com base no parâmetro da URL (?erro=...)
        document.addEventListener("DOMContentLoaded", () => {
            const params = new URLSearchParams(window.location.search);
            const erro = params.get("erro");
            const msgErro = document.getElementById("msgErro");
        
            if (erro && msgErro) {
                msgErro.style.display = "block";
            
                switch (erro) {
                    case "senhaIncorreta":
                        msgErro.textContent = "Senha atual incorreta! Tente novamente.";
                        break;
                    case "senhaFraca":
                        msgErro.textContent = "Senha nova: min. 8 caracteres com maiúscula, minúscula, número e símbolo.";
                        break;
                    default:
                        msgErro.textContent = "Erro desconhecido.";
                }
            
                // Se quiser ocultar automaticamente após 2s
                setTimeout(() => {
                    msgErro.style.opacity = '0';
                    setTimeout(() => msgErro.remove(), 500);
                }, 4000);
            }
        });

        // Função para alternar visibilidade da senha
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
        
            const tipo = input.getAttribute("type") === "password" ? "text" : "password";
            input.setAttribute("type", tipo);
        
            icon.classList.toggle("bi-eye");
            icon.classList.toggle("bi-eye-slash");
        }

        // Listeners para cada botão
        document.getElementById("toggleSenhaAtual").addEventListener("click", () => {
            togglePassword("senhaAtual", "iconeSenhaAtual");
        });

        document.getElementById("toggleNovaSenha").addEventListener("click", () => {
            togglePassword("novaSenha", "iconeNovaSenha");
        });

        // Aplica máscara ao telefone
        $(document).ready(function () {
            $('#novoTel').mask('(00) 00000-0000');
        
            // Ao enviar o formulário, remove a máscara
            $('form').on('submit', function () {
                const telInput = document.getElementById('novoTel');
                telInput.value = telInput.value.replace(/\D/g, '');
            });
        });
    </script>
</body>
</html>
