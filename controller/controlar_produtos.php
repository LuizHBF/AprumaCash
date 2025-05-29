<?php

include '../../model/model_produto.php'; // Inclui modelagem da tabela no BD

// CRUD produtos
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	switch ($_REQUEST["acao"])
	{
		case 'cadastrar':
			$cadastro = new Produto(); // Cria objeto de classe da entidade

			// Atribui valores recebidos para características de classe
			$cadastro->nomeProduto = $_POST['nome_prod'];
			$cadastro->valorProduto = $_POST['valor_prod'];
			$cadastro->codUsuario = $_SESSION['codUsu'];
		
			$cadastro->cadastraProduto(); // Executa ação de cadastro
			//echo "ok"; // Feedback para testes
			break;

		case 'atualizar':
			$atualizacao = new Produto();

			$atualizacao->nomeProduto = $_POST['nome_prod'];
			$atualizacao->valorProduto = $_POST['valor_prod'];
			$atualizacao->codProduto = $_POST['cod_prod'];
			$atualizacao->codUsuario = $_SESSION['codUsu'];

			$atualizacao->atualizaProduto();
			//echo "ok";
			break;

		case 'excluir':
			$exclusao = new Produto();
			$exclusao->codProduto = $_POST['cod_prod'];

			$exclusao->excluiProduto();
			//echo "ok";
			break;

		default:
			echo "Ação desconhecida";
		break;
	}
}

// Exibição de produtos
$consultar = new Produto();
$consultar->codUsuario = $_SESSION['codUsu'];
$produtos = $consultar->consultaProduto();

?>