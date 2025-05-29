<?php
    require_once("conexao.php");

    class Usuario {
        private $con;

        public function __construct() {
            $this->con = Conexao::conectar();
        }

        // Atualizar o perfil do usuário logado
        public function atualizarPerfil($codUsu, $perfilSelecionado) {
            try {
                $stmt = $this->con->prepare("UPDATE usuario SET perfilUsu = :perfil WHERE codUsu = :codUsu");
                $stmt->bindParam(":perfil", $perfilSelecionado, PDO::PARAM_INT);
                $stmt->bindParam(":codUsu", $codUsu, PDO::PARAM_INT);
                $stmt->execute();
                return true;
            } catch (PDOException $e) {
                // Você pode fazer log de erro aqui, se quiser
                return false;
            }
        }
    }
?>
