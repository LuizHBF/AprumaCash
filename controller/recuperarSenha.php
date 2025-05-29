<?php
    include '../model/conexao.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require '../vendor/autoload.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        
        // Verifica se o email existe no banco
        $conexao = new Conexao();
        $con = $conexao->Conectar();
        
        $sql = "SELECT codUsu, nomeUsu FROM usuario WHERE emailUsu = :email AND ativo = 1 LIMIT 1";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($usuario) {
            // Gera um token único
            $token = bin2hex(random_bytes(32));
            
            // Armazena o token na sessão (alternativa temporária sem banco)
            session_start();
            $_SESSION['reset_token'] = $token;
            $_SESSION['reset_email'] = $email;
            $_SESSION['reset_expires'] = time() + 3600; // 1 hora de validade
            
            // Envia o email
            $mail = new PHPMailer(true);
            
            try {
                // Configurações do servidor SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'suporte.AprumaCash@gmail.com';
                $mail->Password = 'vkqh apud uslv vwas';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                
                // Remetente e destinatário
                $mail->setFrom('suporte.AprumaCash@gmail.com', 'AprumaCash');
                $mail->addAddress($email, $usuario['nomeUsu']);
                
                // Conteúdo do email
                $mail->isHTML(true);
                $mail->Subject = 'Recuperação de Senha - AprumaCash';
                $mail->Body = "
                    <h2>Recuperação de Senha</h2>
                    <p>Olá {$usuario['nomeUsu']},</p>
                    <p>Recebemos uma solicitação para redefinir sua senha.</p>
                    <p>Clique no link abaixo para criar uma nova senha:</p>
                    <p><a href='http://localhost/AprumaCashv3%20-%20Bootstrap/view/novaSenha.php?token={$token}'>Redefinir Senha</a></p>
                    <p>Este link expira em 1 hora.</p>
                    <p>Se você não solicitou esta alteração, ignore este email.</p>
                ";
                
                $mail->send();
                header("Location: ../view/esqueciSenha.php?status=enviado");
                exit;
            } catch (Exception $e) {
                header("Location: ../view/esqueciSenha.php?status=erro");
                exit;
            }
        } else {
            header("Location: ../view/esqueciSenha.php?status=naoEncontrado");
            exit;
        }
    }
?> 