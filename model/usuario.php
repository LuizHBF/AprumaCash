<?php
    include ("conexao.php");
    class Usuario implements JsonSerializable{
        private $codUsu;
        private $nomeUsu;
        private $emailUsu;
        private $senhaUsu; 
        private $telUsu;
        private $nascUsu; 
        private $perfilUsu;

        function jsonSerialize():mixed{
            return [
                'codUsu' => $this->codUsu,
                'nomeUsu' => $this->nomeUsu,
                'emailUsu' => $this->emailUsu,
                'senhaUsu' => $this->senhaUsu,
                'telUsu' => $this->telUsu,
                'nascUsu' => $this->nascUsu,
            ];
        }

        // Definição dos métodos GET SET
        function __get($atributo){
            return $this->$atributo;
        }

        function __set($atributo, $value){
            $this->$atributo = $value;
        }

        // Acessar o banco de dados
        private $con;
        function __construct(){
            // Criando um objeto de classe chamado classe_con
            $classe_con = new Conexao();
            // Executando o método conectar e estabelecendo uma conexão com o BD
            $this->con = $classe_con->Conectar();
        }

        //métodos para gerenciar as informações no banco de dados
        //Enviando informações que serão armazenadas no na tabela
        function cadastrar(){
            // Verifica se já existe um usuário ATIVO com o mesmo e-mail
            $comandoVerifica = "SELECT COUNT(*) FROM usuario WHERE emailUsu = ? AND ativo = 1";
            $stmt = $this->con->prepare($comandoVerifica);
            $stmt->execute([$this->emailUsu]);
            $qtd = $stmt->fetchColumn();
                
            if ($qtd > 0) {
                // Já existe um usuário ativo com esse e-mail
                header("Location: ../view/cadastro.html?erro=ativo");
                exit();
            }

            $comandoSql = "insert into usuario (nomeUsu, emailUsu, senhaUsu, telUsu, nascUsu) values (?,?,?,?,?)";
            $valores = array($this->nomeUsu, $this->emailUsu, $this->senhaUsu, $this->telUsu, $this->nascUsu);
            $exec = $this->con->prepare($comandoSql);
            $exec->execute($valores);
        }
    }

    // Código executado ao enviar o formulário
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = new Usuario();
    
        $usuario->nomeUsu = $_POST['nome'];
        $usuario->emailUsu = $_POST['email'];
        // Criptografa a senha antes de armazenar
        $usuario->senhaUsu = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $usuario->telUsu = $_POST['telefone'];
        $usuario->nascUsu = $_POST['dataNasc'];
    
        $usuario->cadastrar();

        // Inicia a sessão
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Recupera o ID gerado
        $codUsu = $usuario->con->lastInsertId();
        $_SESSION['codUsu'] = $codUsu;
        
        // Recupera o nome do usuário recém-cadastrado e armazena na sessão
        $sql = "SELECT nomeUsu FROM usuario WHERE codUsu = ?";
        $stmt = $usuario->con->prepare($sql);
        $stmt->execute([$codUsu]);
        $usuarioNome = $stmt->fetchColumn();
        
        $_SESSION['nomeUsu'] = $usuarioNome; // Salva o nome na sessão
        
        header("Location: ../view/selecao.php");
        exit();
    }
?>