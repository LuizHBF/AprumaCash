<?php
    include("../controller/verificaLogin.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Perguntas Frequentes (FAQ)</title>
    <link rel="shortcut icon" href="./img/favicon.svg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./styles/config.css">
</head>
<body>
    <!-- Cabeçalho -->
    <section class="text-center container header">
      <div class="row py-lg-3">
        <div class="col-lg-6 col-md-8 mx-auto">
          <h1 class="fw-light">Perguntas Frequentes</h1>
          <!-- Botão Voltar -->
          <div class="text-center mt-3 mb-3">
            <a class="btn btn-outline-primary w-25" href="config.php">Voltar</a>
          </div>
          <p class="lead">
            Encontre respostas para as dúvidas mais comuns.<br>
            Consulte as perguntas abaixo para obter informações rápidas e esclarecer suas principais questões.
          </p>
        </div>
      </div>
    </section>

    <div class="container">
        <div class="accordion" id="faqAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                        Como atualizo meu cadastro?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        Vá até a tela de perfil e clique em "Atualizar cadastro".
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                        Como altero meu perfil de usuário?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        Acesse o botão "Atualizar perfil" na tela de perfil e selecione um novo tipo.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                        Exclui meu Produto/Pagamento por engano, tem como recupera-los?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        Não, dados insensíveis são excluidos permanentemente do sistema.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>