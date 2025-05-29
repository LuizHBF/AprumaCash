<?php
include("../../controller/verificaLogin.php");
include ('../../controller/controlar_pagamentos.php');
?>
<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="auto">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="Rodrigo Jordão, Luiz Henrique, Moysés Souza, Guilherme Oliveira">
	<meta name="generator" content="Hugo 0.145.0">
	<title>Pagamentos</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../../view/styles/pagamentos.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	<style>
		.bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			user-select: none;
		}
		.oculto {
			display: none;
		}
		.ativo {
    		display: block;
		}
	</style>
</head>
<body>

	<main>
		<!-- Cabeçário -->
		<section class="mt-3 text-center container">
			<div class="row py-lg-3">
				<div class="col-lg-6 col-md-8 mx-auto">
					<h1 class="fw-light">Lucros e Despesas</h1>
					<!-- Botão Voltar -->
					<div class="text-center mt-3 mb-3">
						<a class="btn btn-outline-primary w-25" href="../oficina.php">Voltar</a>
					</div>
					<p class="lead text-body-secondary">
						Registro histórico para seus lucros e despesas com valores fixos.<br>
						Pressione os botões abaixo para visualizar suas respectivas listas.<br>
					</p>
					<p>
						<a class="btn btn-primary my-2">Lucros</a>
						<a class="btn btn-secondary my-2">Despesas</a>
					</p>
					<!-- Feedback do sistema -->
					<div id="mensagem-erro" class="text-danger mt-3" style="display: none;"></div>
				</div>
			</div>
		</section>

		<!-- Pagamentos -->
		<div class="album py-5 bg-body-tertiary">
            <div class="container">
				<?php
				if (isset($_GET["pagam"]) && $_GET["pagam"] == "Lucro")
				{
					echo '<div class="oculto ativo" id="lucros">';
				} else {
					echo '<div class="oculto" id="lucros">';
				}
				?>
					<!-- Seção de lucros -->
					<h3>Lucros</h3>
					<a class="btn btn-primary" onclick="cadastrar('Lucro')">Adicionar Lucro</a>
					<?php if (isset($lucros) && $lucros != []): // Verifica se há registros de produtos ?>
					<center>
						<table>
							<thead>
								<tr>
									<th width="10%"><h5>Nome</h5></th>
									<th width="20%"><h5>Descrição</h5></th>
									<th width="10%"><h5>Produtos</h5></th>
									<th width="10%"><h5>Data Início</h5></th>
									<th width="10%"><h5>Data Fim</h5></th>
									<th width="10%"><h5>Subtotal</h5></th>
									<th width="5%"></th>
								</tr>
							</thead>
							<tbody>
							<?php foreach ($lucros as $lucro): ?>
								<tr>
									<td><?= $lucro["nomePagam"] ?></td>
									<td><?= $lucro["descPagam"] ?></td>
									<td><?= $lucro["produtos"] ?></td>
									<td><?= $lucro["dataInicio"] ?></td>
									<td><?= $lucro["dataFim"] ?></td>
									<td>R$ <?= number_format($lucro["valorPagam"], 2, ',', '.') ?></td>
									<td>
										<div class="btn-group">
											<button type='button' class='btn btn-sm btn-danger' onclick='editarPagamento(<?= $lucro["codPagam"] ?>, "Lucro")'>Editar</button>
											<button type='button' class='btn btn-sm btn-outline-danger' onclick='excluir(<?= $lucro["codPagam"] ?>)'>Excluir</button>
										</div>
									</td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</center>
					<?php else: ?>
					<center><h3 class="msg-nenhum-registo">Nenhum Registro Encontrado</h3></center>
                	<?php endif; ?>
				</div>

				<?php
				if (isset($_GET["pagam"]) && $_GET["pagam"] == "Despesa")
				{
					echo '<div class="oculto ativo" id="despesas">';
				} else {
					echo '<div class="oculto" id="despesas">';
				}
				?>
					<!-- Seção de despesas -->
					<h3>Despesas</h3>
					<a class="btn btn-primary" onclick="cadastrar('Despesa')">Adicionar Despesa</a>
					<?php if (isset($despesas) && $despesas != []): // Verifica se há registros de produtos ?>
					<center>
						<table>
							<thead>
								<tr>
									<th width="10%"><h5>Nome</h5></th>
									<th width="20%"><h5>Descrição</h5></th>
									<th width="10%"><h5>Período</h5></th>
									<th width="10%"><h5>Valor Pago</h5></th>
									<th width="10%"></th>
								</tr>
							</thead>
							<tbody>
							<?php foreach ($despesas as $despesa): ?>
									<tr>
										<td><?= $despesa["nome"] ?></td>
										<td><?= $despesa["desc"] ?></td>
										<td><?= $despesa["periodo"] ?></td>
										<td>R$ <?= number_format($despesa["valor"], 2, ',', '.') ?></td>
										<td>
											<div class="btn-group">
												<button type='button' class='btn btn-sm btn-danger' onclick='editarPagamento(<?= $despesa["cod"] ?>, "Despesa")'>Editar</button>
												<button type='button' class='btn btn-sm btn-outline-danger' onclick='excluir(<?= $despesa["cod"] ?>)'>Excluir</button>
											</div>
										</td>
									</tr>
									<?php endforeach; ?>
							</tbody>
						</table>
					</center>
					<?php else: ?>
					<center><h3 class="msg-nenhum-registo">Nenhum Registro Encontrado</h3></center>
                	<?php endif; ?>
        		</div>
				
        	</div>
        </div>
	</main>

	<!-- Formulário -->
	<div class="modal fade" id="formPagam" tabindex="-1" aria-labelledby="formReceitaLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form id="envioPagamento" class="modal-content" method="POST" action="?acao=cadastrar&pagam=Lucro">
				<div class="modal-header">
					<h5 class="modal-title">Adicionar Pagamento</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
				</div>
				<div class="modal-body">
					<input type="hidden" id="cod_pagam" name="cod_pagam">
					<label for="nome_pagam">Título</label>
					<input type="text" id="nome_pagam" name="nome_pagam" class="form-control mb-2" placeholder="Digite um nome" required>
					<label for="desc_pagam">Descrição (opcional)</label>
					<input type="text" id="desc_pagam" name="desc_pagam" class="form-control mb-2" placeholder="Descreva o pagamento">
					<div id="produtos" class="oculto">
						<h5>Produtos</h5>
						<div style="overflow-x: hidden; overflow-y: scroll; padding: 10px">
							
							<?php if (isset($produtos) && $produtos != []): // Verifica se há registros de produtos ?>
								<?php foreach ($produtos as $produto): ?>
									<p>
										<label><?= $produto["nome"] ?></label>
										<?php echo "<input type='hidden' name='cod_prod[]' value='".$produto["cod"]."'>"; ?>
										<?php echo "<input type='hidden' name='nome_prod[]' value='".$produto["nome"]."'>"; ?>
										<?php echo "<input type='hidden' name='valor_prod[]' value='".$produto['valor']."'>"; ?>
										<input type="number" name="qnt_prod[]" value="0" min="0" step="1">
									</p>
								<?php endforeach; ?>
									
							<?php else: ?>
								<center>
									<h3>Nenhum Produto Encontrado</h3>
									<a class="btn btn-primary" href="produtos.php">Adicionar produto</a>
								</center>
								<!--label for="valor_pagam">Valor (R$)</label>
								<input type="number" id="valor_pagam" name="valor_pagam" class="form-control mb-2" min="0" step="0.01" placeholder="R$ 0,00"-->
							<?php endif; ?>
										
						</div>
						<br><hr>
						<label for="data_inicio">Data de Início</label>
						<input type="date" id="data_inicio" name="data_inicio" class="form-control mb-2">
						<label for="data_fim">Data Final</label>
						<input type="date" id="data_fim" name="data_fim" class="form-control mb-2">
					</div>
					<div id="precos" class="oculto">
						<label for="valor_pagam">Valor (R$)</label>
						<input type="number" id="valor_pagam" name="valor_pagam" class="form-control mb-2" min="0" step="0.01" placeholder="R$ 0,00">
						<label for="periodo">Período</label>
						<br>
						<select id="periodo" name="periodo" style="padding: 2px; border-radius: 3px; border: 1px solid #ced4da">
							<option value="days">Dias</option>
							<option value="weeks">Semanas</option>
							<option value="months">Meses</option>
							<option value="years">Anos</option>
						</select>
						<input type="number" id="qnt_periodo" name="qnt_periodo" class="form-control mb-2" placeholder="Digite o tempo" />
						<!--input type="date" id="data_inicio" name="data_inicio" class="form-control mb-2" required-->
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Salvar</button>
				</div>
			</form>
		</div>
	</div>

	<!-- Modal de edição de Lucro -->
	<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalEditarLabel">Editar Lucro</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="formEditar">
						<input type="hidden" id="codPagamEditar" name="codPagam">
						<div class="form-group mb-3">
							<label for="nomePagamEditar">Nome</label>
							<input type="text" class="form-control" id="nomePagamEditar" name="nomePagam" required>
						</div>
						<div class="form-group mb-3">
							<label for="descPagamEditar">Descrição</label>
							<textarea class="form-control" id="descPagamEditar" name="descPagam"></textarea>
						</div>
						<div class="form-group mb-3">
							<label for="dataInicioEditar">Data Início</label>
							<input type="date" class="form-control" id="dataInicioEditar" name="dataInicio" required>
						</div>
						<div class="form-group mb-3">
							<label for="dataFimEditar">Data Fim</label>
							<input type="date" class="form-control" id="dataFimEditar" name="dataFim" required>
						</div>
						<div class="form-group mb-3">
							<label for="valorPagamEditar">Valor</label>
							<input type="number" step="0.01" class="form-control" id="valorPagamEditar" name="valorPagam" required>
						</div>
						<div id="produtosEditar" class="mb-3">
							<!-- Produtos serão inseridos aqui dinamicamente -->
						</div>
						<button type="button" class="btn btn-secondary" onclick="adicionarProdutoEditar()">Adicionar Produto</button>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="Can_Lucr">Cancelar</button>
					<button type="button" class="btn btn-primary" onclick="salvarEdicao()">Salvar</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Formulário de Edição de Despesa -->
	<div class="modal fade" id="formEditarDespesa" tabindex="-1" aria-labelledby="formEditarDespesaLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form id="envioEditarDespesa" class="modal-content" method="POST" action="?acao=atualizar&pagam=Despesa" onsubmit="return salvarEdicaoDespesa(this);">
				<div class="modal-header">
					<h5 class="modal-title">Editar Despesa</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
				</div>
				<div class="modal-body">
					<input type="hidden" id="cod_despesa_editar" name="codPagam">
					<label for="nome_despesa_editar">Título</label>
					<input type="text" id="nome_despesa_editar" name="nomePagam" class="form-control mb-2" placeholder="Digite um nome" required>
					<label for="desc_despesa_editar">Descrição (opcional)</label>
					<input type="text" id="desc_despesa_editar" name="descPagam" class="form-control mb-2" placeholder="Descreva a despesa">
					<label for="periodo_despesa_editar">Período</label>
					<br>
					<select id="periodo_despesa_editar" name="periodo" class="form-control mb-2" required>
						<option value="days">Dias</option>
						<option value="weeks">Semanas</option>
						<option value="months">Meses</option>
						<option value="years">Anos</option>
					</select>
					<label for="qnt_periodo_despesa_editar">Quantidade do Período</label>
					<input type="number" id="qnt_periodo_despesa_editar" name="qntPeriodo" class="form-control mb-2" placeholder="Digite o tempo" required min="1" />
					<label for="valor_despesa_editar">Valor (R$)</label>
					<input type="number" id="valor_despesa_editar" name="valorPagam" class="form-control mb-2" min="0" step="0.01" placeholder="R$ 0,00" required>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="Can_Desp">Cancelar</button>
					<button type="submit" class="btn btn-primary">Salvar</button>
				</div>
			</form>
		</div>
	</div>

	<!-- Botão Voltar ao Topo -->
	<div class="text-center mt-4 mb-4">
		<a href="#" class="text-decoration-none back-to-top">Voltar para o topo</a>
	</div>
	<!-- Script do Bootstrap -->
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
                    MSGERRO.textContent = "Erro: Este pagamento já foi cadastrado.";
                    break;
				case "invalido":
                    MSGERRO.textContent = "Erro: O lucro possui valor menor ou igual a 0.";
					break;
                default:
                    MSGERRO.textContent = "Erro desconhecido.";
            }
		}
		
		// Exibição das tabelas específicas
		function mostrarTB(pagina1, pagina2)
		{
			const MOSTRAR = document.getElementById(pagina1);
			const OCULTAR = document.getElementById(pagina2);
			MOSTRAR.classList.add('ativo');
			OCULTAR.classList.remove('ativo');
		}
		
		// Referências tabelas
		document.querySelector('.btn.btn-primary.my-2').addEventListener('click', function()
		{
			mostrarTB('lucros', 'despesas');
		});
		
		document.querySelector('.btn.btn-secondary.my-2').addEventListener('click', function()
		{
			mostrarTB('despesas', 'lucros');
		});

		// Referencias formulário
		const EDTPAGAMENTO = new bootstrap.Modal(document.getElementById('formPagam')); // Div parente do formulário
		const ENVPAGAMENTO = document.getElementById('envioPagamento'); // Área de configurações do formulário
		// Campos do formulário
		const CODPAGAMENTO = document.getElementById("cod_pagam");
		const NOMPAGAMENTO = document.getElementById('nome_pagam');
		const DECPAGAMENTO = document.getElementById("desc_pagam");

		const DATINIPAGAMENTO = document.getElementById("data_inicio");
		const DATFIMPAGAMENTO = document.getElementById("data_fim");
		const PRDPAGAMENTO = document.getElementById("qnt_periodo");

		const VALPAGAMENTO = document.getElementById("valor_pagam");

		const PRODUTOS = document.getElementById("produtos");
		const PRECOS = document.getElementById("precos");

		// Declaração de objetos ativadores para exibir formulários
		function cadastrar(pagam)
		{
			CODPAGAMENTO.value = "";
			NOMPAGAMENTO.value = "";
			DECPAGAMENTO.value = "";
			DATINIPAGAMENTO.value = "";
			DATFIMPAGAMENTO.value = "";
			VALPAGAMENTO.value = "";
			
			// Mudar ação do formulário
			ENVPAGAMENTO.action='?acao=cadastrar&pagam='+pagam;
			if (pagam == "Lucro")
			{
				PRODUTOS.classList.add('ativo');
				PRECOS.classList.remove('ativo');
				PRDPAGAMENTO.required = false;
				DATINIPAGAMENTO.required = true;
				DATFIMPAGAMENTO.required = true;
			}
			else if (pagam == "Despesa")
			{
				PRECOS.classList.add('ativo');
				PRODUTOS.classList.remove('ativo');
				PRDPAGAMENTO.required = true;
				DATINIPAGAMENTO.required = false;
				DATFIMPAGAMENTO.required = false;
			}
			EDTPAGAMENTO.show(); // Exibe formulário
		}
		
		function atualizar(cod, nome, desc, dataInicio, dataFim, valor, pagam)
		{
			//alert(cod + ", " + nome + ", " + valor); // Exibição pop-up de valores para testes
			CODPAGAMENTO.value = cod;
			NOMPAGAMENTO.value = nome;
			DECPAGAMENTO.value = desc;
			DATINIPAGAMENTO.value = dataInicio;
			DATFIMPAGAMENTO.value = dataFim;
			VALPAGAMENTO.value = valor;
			
			PRECOS.classList.add('ativo');
			PRODUTOS.classList.remove('ativo');

			ENVPAGAMENTO.action='?acao=atualizar&pagam='+pagam;
			if (pagam == "Lucro")
			{
				PRODUTOS.classList.add('ativo');
				PRECOS.classList.remove('ativo');
				PRDPAGAMENTO.required = false;
				DATINIPAGAMENTO.required = true;
				DATFIMPAGAMENTO.required = true;
			}
			else if (pagam == "Despesa")
			{
				PRECOS.classList.add('ativo');
				PRODUTOS.classList.remove('ativo');
				PRDPAGAMENTO.required = true;
				DATINIPAGAMENTO.required = false;
				DATFIMPAGAMENTO.required = false;
			}
			EDTPAGAMENTO.show(); // Exibe formulário
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
        		CODEXCLUI.name = 'cod_pagam';
        		CODEXCLUI.value = cod;
        		FORMEXCLUI.appendChild(CODEXCLUI);

        		// Adiciona e envia
        		document.body.appendChild(FORMEXCLUI);
        		FORMEXCLUI.submit();
    		}
		}

		function adicionarProdutoEditar(produto = null) {
			// Se for um produto existente sendo carregado, adiciona normalmente
			if (produto) {
				const div = $('<div class="form-group produto-item">');
				div.html(`
					<div class="row">
						<div class="col-md-6">
							<select class="form-control produto-select" name="produtos[]" required onchange="recalcularSubtotal()" disabled>
								<option value="">Selecione um produto</option>
								<?php foreach ($produtos as $p): ?>
								<option value="<?= $p['cod'] ?>" data-valor="<?= $p['valor'] ?>" ${produto.codProduto == <?= $p['cod'] ?> ? 'selected' : ''}>
									<?= $p['nome'] ?> - R$ <?= number_format($p['valor'], 2, ',', '.') ?>
								</option>
								<?php endforeach; ?>
							</select>
							<input type="hidden" name="produtos[]" value="${produto.codProduto}">
						</div>
						<div class="col-md-4">
							<input type="number" class="form-control qtd-produto" name="qnt_prod[]" placeholder="Qtd" value="${produto.qntProduto}" required min="1" onchange="recalcularSubtotal()">
						</div>
						<div class="col-md-2">
							<button type="button" class="btn btn-danger" onclick="removerProduto(this)">X</button>
						</div>
					</div>
				`);
				$('#produtosEditar').append(div);
				recalcularSubtotal();
				return;
			}

			// Para novo produto, verifica se já existe
			const select = $('<select class="form-control produto-select" name="produtos[]" required onchange="verificarProdutoExistente(this)">');
			select.html(`
				<option value="">Selecione um produto</option>
				<?php foreach ($produtos as $p): ?>
				<option value="<?= $p['cod'] ?>" data-valor="<?= $p['valor'] ?>">
					<?= $p['nome'] ?> - R$ <?= number_format($p['valor'], 2, ',', '.') ?>
				</option>
				<?php endforeach; ?>
			`);

			const div = $('<div class="form-group produto-item">');
			div.html(`
				<div class="row">
					<div class="col-md-6"></div>
					<div class="col-md-4">
						<input type="number" class="form-control qtd-produto" name="qnt_prod[]" placeholder="Qtd" value="1" required min="1" onchange="recalcularSubtotal()">
					</div>
					<div class="col-md-2">
						<button type="button" class="btn btn-danger" onclick="removerProduto(this)">X</button>
					</div>
				</div>
			`);
			div.find('.col-md-6').append(select);
			$('#produtosEditar').append(div);
			recalcularSubtotal();
		}

		function verificarProdutoExistente(select) {
			const codProduto = $(select).val();
			if (!codProduto) return;

			// Procura por produtos iguais
			let produtoExistente = null;
			$('.produto-item').each(function() {
				const itemSelect = $(this).find('.produto-select');
				if (itemSelect[0] !== select && itemSelect.val() === codProduto) {
					produtoExistente = $(this);
					return false; // break the loop
				}
			});

			if (produtoExistente) {
				// Se encontrou produto igual, soma as quantidades
				const qtdAtual = parseInt(produtoExistente.find('.qtd-produto').val()) || 0;
				const qtdNova = parseInt($(select).closest('.produto-item').find('.qtd-produto').val()) || 0;
				produtoExistente.find('.qtd-produto').val(qtdAtual + qtdNova);
				
				// Remove o item duplicado
				$(select).closest('.produto-item').remove();
				
				// Recalcula o subtotal
				recalcularSubtotal();
			} else {
				// Se não encontrou produto igual, desabilita o select e adiciona um input hidden
				$(select).prop('disabled', true);
				$(select).after(`<input type="hidden" name="produtos[]" value="${codProduto}">`);
			}
		}

		function removerProduto(button) {
			$(button).closest('.produto-item').remove();
			recalcularSubtotal();
		}

		function recalcularSubtotal() {
			let subtotal = 0;
			$('.produto-item').each(function() {
				const select = $(this).find('.produto-select');
				const quantidade = parseInt($(this).find('.qtd-produto').val()) || 0;
				const valor = parseFloat(select.find('option:selected').data('valor')) || 0;
				subtotal += quantidade * valor;
			});
			$('#valorPagamEditar').val(subtotal.toFixed(2));
		}

		function validarFormularioDespesa(form) {
			console.log('Validando formulário de despesa...');
			
			// Obtém todos os campos do formulário
			const codPagam = form.codPagam.value;
			const nomePagam = form.nomePagam.value;
			const descPagam = form.descPagam.value;
			const periodo = form.periodo.value;
			const qntPeriodo = form.qntPeriodo.value;
			const valorPagam = form.valorPagam.value;
			
			// Log dos valores
			console.log('Valores do formulário:');
			console.log('codPagam:', codPagam);
			console.log('nomePagam:', nomePagam);
			console.log('descPagam:', descPagam);
			console.log('periodo:', periodo);
			console.log('qntPeriodo:', qntPeriodo);
			console.log('valorPagam:', valorPagam);
			
			// Verifica campos obrigatórios
			if (!codPagam) {
				alert('Código da despesa não encontrado');
				return false;
			}
			if (!nomePagam) {
				alert('Nome é obrigatório');
				return false;
			}
			if (!periodo) {
				alert('Período é obrigatório');
				return false;
			}
			if (!qntPeriodo || qntPeriodo < 1) {
				alert('Quantidade do período é obrigatória e deve ser maior que zero');
				return false;
			}
			if (!valorPagam || valorPagam <= 0) {
				alert('Valor é obrigatório e deve ser maior que zero');
				return false;
			}
			
			return true;
		}

		function editarPagamento(codPagam, tipo) {
			console.log('Editando pagamento:', codPagam, tipo); // Debug
			
			$.ajax({
				url: '../../controller/controlar_pagamentos.php',
				type: 'POST',
				data: {
					acao: 'editar',
					codPagam: codPagam
				},
				success: function(response) {
					console.log('Resposta bruta:', response); // Debug da resposta bruta
					try {
						// Tenta extrair apenas o JSON da resposta
						const jsonStart = response.indexOf('{');
						const jsonEnd = response.lastIndexOf('}') + 1;
						const jsonStr = response.substring(jsonStart, jsonEnd);
						console.log('JSON extraído:', jsonStr); // Debug do JSON extraído
						
						const pagamento = JSON.parse(jsonStr);
						console.log('Dados do pagamento:', pagamento); // Debug dos dados parseados
						
						if (tipo === "Lucro") {
							$('#codPagamEditar').val(pagamento.codPagam);
							$('#nomePagamEditar').val(pagamento.nomePagam);
							$('#descPagamEditar').val(pagamento.descPagam);
							$('#dataInicioEditar').val(pagamento.dataInic);
							$('#dataFimEditar').val(pagamento.dataFim);
							$('#valorPagamEditar').val(pagamento.valorPagam);
							
							// Limpa e preenche a lista de produtos
							$('#produtosEditar').empty();
							if (pagamento.produtos && pagamento.produtos.length > 0) {
								pagamento.produtos.forEach(function(produto) {
									adicionarProdutoEditar(produto);
								});
							}
							// Recalcula o subtotal inicial
							recalcularSubtotal();
							
							// Abre o modal de lucro
							const modal = new bootstrap.Modal(document.getElementById('modalEditar'));
							modal.show();
						} else {
							console.log('Preenchendo formulário de despesa...');
							
							// Preenche os campos do formulário de despesa
							$('#cod_despesa_editar').val(pagamento.codPagam || '');
							$('#nome_despesa_editar').val(pagamento.nomePagam || '');
							$('#desc_despesa_editar').val(pagamento.descPagam || '');
							
							// Extrai o período e a quantidade do período
							const periodoCompleto = pagamento.periodo || '';
							console.log('Período completo do banco:', periodoCompleto);
							
							// Extrai a quantidade e a unidade do período
							const match = periodoCompleto.match(/^(\d+)\s+(days|weeks|months|years)$/);
							if (match) {
								const qntPeriodo = match[1];
								const periodo = match[2];
								console.log('Quantidade do período:', qntPeriodo);
								console.log('Período:', periodo);
								
								// Preenche os campos
								$('#qnt_periodo_despesa_editar').val(qntPeriodo);
								$('#periodo_despesa_editar').val(periodo);
							} else {
								console.log('Formato de período inválido:', periodoCompleto);
								// Define valores padrão se o formato for inválido
								$('#qnt_periodo_despesa_editar').val('1');
								$('#periodo_despesa_editar').val('days');
							}
							
							// Ajusta o valor (remove o sinal negativo se existir)
							const valor = pagamento.valorPagam ? Math.abs(pagamento.valorPagam) : '0.00';
							console.log('Valor do banco:', valor);
							$('#valor_despesa_editar').val(valor);
							
							// Log dos valores após preenchimento
							console.log('Valores após preenchimento:');
							console.log('codPagam:', $('#cod_despesa_editar').val());
							console.log('nomePagam:', $('#nome_despesa_editar').val());
							console.log('descPagam:', $('#desc_despesa_editar').val());
							console.log('periodo:', $('#periodo_despesa_editar').val());
							console.log('qntPeriodo:', $('#qnt_periodo_despesa_editar').val());
							console.log('valorPagam:', $('#valor_despesa_editar').val());
							
							// Abre o modal de despesa
							const modal = new bootstrap.Modal(document.getElementById('formEditarDespesa'));
							modal.show();
						}
					} catch (e) {
						console.error('Erro ao processar resposta:', e);
						console.error('Resposta recebida:', response);
						alert('Erro ao processar dados do pagamento. Por favor, tente novamente.');
					}
				},
				error: function(xhr, status, error) {
					console.error('Erro na requisição:', error);
					console.error('Status:', status);
					console.error('Resposta:', xhr.responseText);
					alert('Erro ao carregar dados: ' + error);
				}
			});
		}

		function salvarEdicao() {
			// Obtém os dados do formulário
			const formData = {
				codPagam: $('#codPagamEditar').val(),
				nomePagam: $('#nomePagamEditar').val(),
				descPagam: $('#descPagamEditar').val(),
				dataInicio: $('#dataInicioEditar').val(),
				dataFim: $('#dataFimEditar').val(),
				valorPagam: $('#valorPagamEditar').val(),
				produtos: [],
				qnt_prod: []
			};

			// Coleta os produtos e suas quantidades
			$('.produto-item').each(function() {
				const codProduto = $(this).find('input[name="produtos[]"]').val();
				const qntProduto = $(this).find('.qtd-produto').val();
				if (codProduto && qntProduto > 0) {
					formData.produtos.push(codProduto);
					formData.qnt_prod.push(qntProduto);
				}
			});

			// Envia os dados para o servidor
			$.ajax({
				url: '?acao=atualizar&pagam=Lucro',
				type: 'POST',
				data: formData,
				success: function(response) {
					try {
						const result = JSON.parse(response);
						if (result.success) {
							// Fecha o modal
							$('#modalEditar').modal('hide');
							// Recarrega a página para atualizar os dados
							location.reload();
						} else {
							alert('Erro ao salvar: ' + (result.error || 'Erro desconhecido'));
						}
					} catch (e) {
						console.error('Erro ao processar resposta:', e);
						alert('Erro ao processar resposta do servidor');
					}
				},
				error: function(xhr, status, error) {
					console.error('Erro na requisição:', error);
					alert('Erro ao salvar: ' + error);
				}
			});
		}

		function salvarEdicaoDespesa(form) {
			if (!validarFormularioDespesa(form)) {
				return false;
			}

			$.ajax({
				url: form.action,
				type: 'POST',
				data: $(form).serialize(),
				success: function(response) {
					try {
						const result = JSON.parse(response);
						if (result.success) {
							// Fecha o modal
							$('#formEditarDespesa').modal('hide');
							// Recarrega a página para atualizar os dados
							location.reload();
						} else {
							alert('Erro ao salvar: ' + (result.error || 'Erro desconhecido'));
						}
					} catch (e) {
						console.error('Erro ao processar resposta:', e);
						alert('Erro ao processar resposta do servidor');
					}
				},
				error: function(xhr, status, error) {
					console.error('Erro na requisição:', error);
					alert('Erro ao salvar: ' + error);
				}
			});

			return false; // Previne o envio padrão do formulário
		}
	</script>
</body>
</html>