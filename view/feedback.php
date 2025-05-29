<?php
    include("../controller/verificaLogin.php");

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../vendor/autoload.php'; // ajuste o caminho se necessário

    $mensagemEnviada = false;
    $erroEnvio = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $mensagem = htmlspecialchars($_POST["mensagem"]);
        $emailUsuario = htmlspecialchars($_POST["email"]);

        $mail = new PHPMailer(true);

        try {
            // Configurações do servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'suporte.AprumaCash@gmail.com'; // seu email Gmail
            $mail->Password = 'vkqh apud uslv vwas'; // senha ou senha de app
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Remetente e destinatário
            $mail->setFrom('suporte.AprumaCash@gmail.com', 'Sistema de Feedback');
            $mail->addAddress('suporte.AprumaCash@gmail.com', 'Admin'); // para onde vai o feedback

            // Se o usuário preencheu o e-mail, adiciona como "Reply-To"
            if (!empty($emailUsuario)) {
                $mail->addReplyTo($emailUsuario);
            }

            // Conteúdo do e-mail
            $mail->isHTML(true);
            $mail->Subject = 'Novo feedback do sistema';
            $mail->Body    = "<strong>Email do usuário:</strong> $emailUsuario<br><strong>Mensagem:</strong><br>$mensagem";

            $mail->send();
            $mensagemEnviada = true;
        } catch (Exception $e) {
            $erroEnvio = "Erro ao enviar: {$mail->ErrorInfo}";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Feedback</title>
    <link rel="shortcut icon" href="./img/favicon.svg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./styles/config.css">
</head>
<body>
    <!-- Cabeçalho -->
    <section class="mt-5 text-center container">
      <div class="row py-lg-3">
        <div class="col-lg-6 col-md-8 mx-auto">
          <h1 class="fw-light">Envie seu Feedback</h1>
          <!-- Botão Voltar -->
          <div class="text-center mt-3 mb-3">
            <a class="btn btn-outline-primary w-25" href="config.php">Voltar</a>
          </div>
          <p class="lead">
            Envie feedbacks de forma simples e eficaz.<br>
            Preencha os campos abaixo para registrar sua opinião ou sugestão de maneira clara e objetiva.
          </p>
        </div>
      </div>
    </section>

    <div class="container">
        <?php if ($mensagemEnviada): ?>
        <div class="alert alert-success">Feedback enviado com sucesso!</div>
        <?php elseif ($erroEnvio): ?>
        <div class="alert alert-danger"><?php echo $erroEnvio; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Seu email (opcional)</label>
                <input type="email" class="form-control" name="email" id="email">
            </div>
            <div class="mb-3">
                <label for="mensagem" class="form-label">Mensagem</label>
                <textarea class="form-control" name="mensagem" id="mensagem" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-custom">Enviar</button>
        </form>
    </div>
</body>
</html>