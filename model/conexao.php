<?php
if (!class_exists("Conexao"))
{
    class Conexao{
        function Conectar(){
            try {
                $con = new PDO("mysql:host=localhost;dbname=aprumacash", "root", "");
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $con;
            } catch(PDOException $e) {
                die("Erro na conexão: " . $e->getMessage());
            }
        }
    }
}
?>