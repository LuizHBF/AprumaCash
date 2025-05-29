<?php
include("../../controller/verificaLogin.php");
include '../../controller/controlar_produtos.php';
?>
<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="auto">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="Rodrigo Jordão, Luiz Henrique, Moysés Souza, Guilherme Oliveira">
	<meta name="generator" content="Hugo 0.145.0">
	<title>Catálogo de Produtos</title>
	<link rel="shortcut icon" href="../img/favicon.svg" type="image/x-icon">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../../view/styles/produtos.css">
	<style>
		.bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			user-select: none;
		}
		/* Estilo para inputs de valores em reais */
		.input-group-text {
			background-color: #f8f9fa;
			border: 1px solid #ced4da;
			color: #495057;
			font-weight: 500;
		}

		.input-group .form-control {
			border-left: none;
		}

		.input-group .form-control:focus {
			border-color: #ced4da;
			box-shadow: none;
		}

		.input-group:focus-within {
			box-shadow: 0 0 0 0.2rem rgba(29, 25, 148, 0.25);
			border-radius: 4px;
		}

		.input-group:focus-within .input-group-text,
		.input-group:focus-within .form-control {
			border-color: #1D1994;
		}
	</style>
</head>
<body>

	<main>
		<!-- Cabeçário -->
		<section class="mt-3 text-center container">
			<div class="row py-lg-3">
				<div class="col-lg-6 col-md-8 mx-auto">
					<h1 class="fw-light">Catálogo Produtos</h1>
					<!-- Botão Voltar -->
					<div class="text-center mt-3 mb-3">
						<a class="btn btn-outline-primary w-25" href="../oficina.php">Voltar</a>
					</div>
					<p class="lead">
						Registro dos seus serviços com valores fixos.<br>
						Pressione os botões abaixo para adicionar uma despesa ou receita à lista.
					</p>
					<div class="button-group">
						<a class="btn btn-primary my-2" onclick="cadastrar()">Adicionar Produto</a>
						<a class="btn btn-danger my-2" href="calculadora.php">Calcular Preço</a>
					</div>
					<!-- Feedback do sistema -->
					<div id="mensagem-erro" class="text-danger mt-3" style="display: none;"></div>
				</div>
			</div>
		</section>

		<div class="album py-5">
			<div class="container">
				<?php if (isset($produtos) && $produtos != []): // Verifica se há registros de produtos ?>

				<div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">

					<!-- Seção de produtos -->
					<?php foreach ($produtos as $produto): ?>
					<div class="col">
						<div class="card h-100">
							<div class="card-header text-center py-3">
								<h5 class="card-title mb-0"><?= $produto["nome"] ?></h5>
							</div>
							<div class="card-body d-flex flex-column">
								<p class="card-text mb-4">Valor: R$ <?= number_format($produto["valor"], 2, ',', '.') ?></p>
								<div class="btn-group mt-auto">
									<?php
									// Botão de atualização
									echo "<button type='button' class='btn btn-outline-secondary' onclick='atualizar(".
										$produto["cod"].",\"".
										$produto["nome"]."\",".
										$produto["valor"].")'>Editar</button>";
									// Botão de exclusão
									echo "<button type='button' class='btn btn-outline-danger' onclick='excluir(".
										$produto["cod"].")'>Excluir</button>";
									?>
								</div>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
				<?php else: ?>
				<div class="text-center empty-state">
					<h3>Nenhum Registro Encontrado</h3>
					<p class="lead">Comece adicionando seu primeiro produto!</p>
				</div>
				<?php endif; ?>
			</div>
			<!-- Botão Voltar ao Topo -->
			<div class="text-center">
				<a href="#" class="text-decoration-none back-to-top">Voltar para o topo</a>
			</div>
		</div>
	</main>

	<!-- Formulário -->
	<div class="modal fade" id="formProduto" tabindex="-1" aria-labelledby="formProdutoLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form id="envioProduto" class="modal-content" method="POST" action="?acao=cadastrar">
				<div class="modal-header">
					<h5 class="modal-title">Adicionar Produto</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
				</div>
				<div class="modal-body">
					<input type="hidden" id="cod_prod" name="cod_prod">
					<div class="mb-3">
						<label for="nome_prod" class="form-label">Título</label>
						<input type="text" id="nome_prod" name="nome_prod" class="form-control" placeholder="Digite um nome" required>
					</div>
					<div class="mb-3">
						<label for="valor_prod" class="form-label">Valor</label>
						<div class="input-group">
							<span class="input-group-text">R$</span>
							<input type="number" id="valor_prod" name="valor_prod" class="form-control" min="0" step="0.01" placeholder="0,00" required>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary">Salvar</button>
				</div>
			</form>
		</div>
	</div>
	<!-- Script do Bootstrap -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	<script>
        // Mensagens de erros
        const PARAMS = new URLSearchParams(window.location.search);
		const ERRO = PARAMS.get("erro");
        const MSGERRO = document.getElementById("mensagem-erro");
        if (ERRO)
		{
            MSGERRO.style.display = "block";
			switch (ERRO)
			{
                case "existe":
                    MSGERRO.textContent = "Erro: Este produto já foi cadastrado.";
                    break;
                default:
                    MSGERRO.textContent = "Erro desconhecido.";
            }
		}

		// Referencias formulário
		const EDTPRODUTO = new bootstrap.Modal(document.getElementById('formProduto')); // Div parente de formulário
		const ENVPRODUTO = document.getElementById('envioProduto'); // Área de configurações do formulário
		// Campos do formulário
		const CODPRODUTO = document.getElementById('cod_prod');
		const NOMPRODUTO = document.getElementById("nome_prod");
		const VALPRODUTO = document.getElementById("valor_prod");

		// Declaração de objetos ativadores para exibir formulários
		function cadastrar()
		{
			CODPRODUTO.value = "";
			NOMPRODUTO.value = "";
			VALPRODUTO.value = "";
			
			ENVPRODUTO.action='?acao=cadastrar'; // Muda ação do formulário
			EDTPRODUTO.show(); // Exibe formulário
		}

		function atualizar(cod, nome, valor)
		{
			//alert(cod + ", " + nome + ", " + valor); // Exibição pop-up de valores para testes
			CODPRODUTO.value = cod;
			NOMPRODUTO.value = nome;
			VALPRODUTO.value = valor;

			
			ENVPRODUTO.action='?acao=atualizar';
			EDTPRODUTO.show();
		}

		function excluir(cod)
		{
    		if (confirm("Deseja realmente excluir este produto?")) // Alerta de confirmação
			{
    		    // Cria formulário oculto para enviar código e ação
    		    const FORMEXCLUI = document.createElement('form');
    		    FORMEXCLUI.method = 'POST';
    		    FORMEXCLUI.action = '?acao=excluir';
        
        		// Campo recebe cod_prod
        		const CODEXCLUI = document.createElement('input');
        		CODEXCLUI.type = 'hidden';
        		CODEXCLUI.name = 'cod_prod';
        		CODEXCLUI.value = cod;
        		FORMEXCLUI.appendChild(CODEXCLUI);

        		// Adiciona e envia
        		document.body.appendChild(FORMEXCLUI);
        		FORMEXCLUI.submit();
    		}
		}
	</script>
</body>
</html>