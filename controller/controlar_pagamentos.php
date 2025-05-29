<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ob_start(); // Inicia o buffer de saída

include(__DIR__ . "/../model/model_pagamentos.php"); // Inclui modelagem da tabela no BD

include(__DIR__ . "/../model/model_produtoPagam.php"); // Cadastro e exibição de produtos dos pagamentos

include(__DIR__ . "/../model/model_produto.php"); // Exibição de todos os produtos

// CRUD pagamentos
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	switch ($_REQUEST["acao"])
    {
		case 'cadastrar':
			$cadastro = new Pagamento(); // Cria objeto de classe da entidade

			// Atribui valores recebidos para características de classe
			$cadastro->nomePagam = $_POST['nome_pagam'];
			$cadastro->descPagam = $_POST['desc_pagam'] ?? null;

			if ($_GET["pagam"] == "Despesa") // Define se o cadastro é despesa
			{
				$cadastro->valorPagam = ($_POST['valor_pagam'])*(-1);
				$cadastro->periodo = $_POST['qnt_periodo']." ".$_POST['periodo'];
			}
			else // Define o cadastro como lucro
			{
				$cadastro->descPagam = $_POST['desc_pagam'] ?? null;
				$cadastro->valorPagam = 0;

				foreach ($_POST["nome_prod"] as $index => $nome) // Executa para cada produto
				{
					/*if ($_POST['qnt_prod'][$index] > 0) // Verifica cada quantidade de produtos
					{
						$cadastro->descPagam .= $nome.": ".$_POST['qnt_prod'][$index]."<br>";
					}*/
					$cadastro->valorPagam += $_POST['valor_prod'][$index]*$_POST['qnt_prod'][$index];
				}
				$cadastro->dataInicio = $_POST['data_inicio'];
				$cadastro->dataFim = $_POST['data_fim'];
			}
			$cadastro->codUsuario = $_SESSION['codUsu'];
			if ($_GET["pagam"] == "Lucro" && $cadastro->valorPagam <= 0)
			{
				header("Location: ?erro=invalido");
			}
			else
			{
				$lucro = $cadastro->cadastraPagam(); // Executa ação de cadastro
				
				// Cadastro da quantidade de produtos				
				foreach ($_POST["nome_prod"] as $index => $nome) // Executa para cada produto
				{
					if ($_POST['qnt_prod'][$index] > 0) // Verifica cada quantidade de produtos
					{
						$produtoPagam = new ProdutoPagam(); // Cria objeto da classe de associação
						$produtoPagam->codProduto = $_POST['cod_prod'][$index];
						$produtoPagam->codPagam = $lucro;
						$produtoPagam->qntProduto = $_POST['qnt_prod'][$index];
						$produtoPagam->cadastraProdutoPagam();
					}
					$cadastro->valorPagam += $_POST['valor_prod'][$index]*$_POST['qnt_prod'][$index];
				}
			}
			/*echo $cadastro->descPagam;
			echo $cadastro->valorPagam;*/ // Exibição para testes
			//echo "ok"; // Feedback para testes
			break;

		case 'atualizar':
			ob_clean(); // Limpa qualquer saída anterior
			$atualizacao = new Pagamento();
			
			// Verifica se é uma despesa ou lucro
			if ($_GET["pagam"] == "Despesa") {
				// Verifica campos obrigatórios para despesa
				if (!isset($_POST['codPagam']) || !isset($_POST['nomePagam']) || 
					!isset($_POST['periodo']) || !isset($_POST['qntPeriodo']) || 
					!isset($_POST['valorPagam'])) {
					echo json_encode(['error' => 'Campos obrigatórios não preenchidos']);
					exit;
				}
				
				$atualizacao->codPagam = $_POST['codPagam'];
				$atualizacao->nomePagam = $_POST['nomePagam'];
				$atualizacao->descPagam = $_POST['descPagam'] ?? '';
				$atualizacao->periodo = $_POST['qntPeriodo']." ".$_POST['periodo'];
				$atualizacao->valorPagam = ($_POST['valorPagam'])*(-1); // Converte para negativo pois é despesa
				
				$atualizacao->atualizaPagam();
				echo json_encode(['success' => true]);
				exit;
			} else {
				// Verifica campos obrigatórios para lucro
				if (!isset($_POST['codPagam']) || !isset($_POST['nomePagam']) || 
					!isset($_POST['dataInicio']) || !isset($_POST['dataFim']) || 
					!isset($_POST['valorPagam'])) {
					echo json_encode(['error' => 'Campos obrigatórios não preenchidos']);
					exit;
				}
				
				$atualizacao->codPagam = $_POST['codPagam'];
				$atualizacao->nomePagam = $_POST['nomePagam'];
				$atualizacao->descPagam = $_POST['descPagam'] ?? '';
				$atualizacao->dataInicio = $_POST['dataInicio'];
				$atualizacao->dataFim = $_POST['dataFim'];
				$atualizacao->valorPagam = $_POST['valorPagam'];

				$atualizacao->atualizaPagam();
				echo json_encode(['success' => true]);
				exit;
			}
			break;

		case 'excluir':
			$exclusao = new Pagamento();
			$exclusao->codPagam = $_POST['cod_pagam'];
	
			$exclusao->excluiPagam();
			//echo "ok"; // Feedback para testes
			break;

        case 'editar':
            ob_clean(); // Limpa qualquer saída anterior
            $objPagamento = new Pagamento();
            $objPagamento->codPagam = $_POST['codPagam'];
            $pagamento = $objPagamento->consultarPagamento();
            $produtos = $objPagamento->consultaProdutosPagamento();
            $pagamento['produtos'] = $produtos;
            echo json_encode($pagamento);
            exit;
            break;

        default:
			echo "Ação desconhecida";
		break;
    }
}

// Exibição de pagamentos
$consultar = new Pagamento();
$consultar->codUsuario = $_SESSION['codUsu'];
$pagamento = $consultar->consultaPagam();

// Declaração de variáveis de exibição
$despesas = [];
$prodsPag = [];

// Definição de lucros e despesas
foreach ($pagamento as $pagamentos)
{
	/*if ($pagamentos["valor"] > 0)
	{
		$lucros[] = $pagamentos;
	}
	else if ($pagamentos["valor"] <= 0)
	{*/
		$despesas[] = $pagamentos;
	//}
}

// Exibição de produtos de cada lucro
$consultaProdPag = new ProdutoPagam();
$lucros = $consultaProdPag->consultaProdutoPagam();

// Exibição de todos os produtos
$consultar = new Produto();
$consultar->codUsuario = $_SESSION['codUsu'];
$produtos = $consultar->consultaProduto();
?>