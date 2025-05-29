<?php
    include '../../model/model_pagamentos.php';
    include '../../model/model_produto.php';
    
    // Buscar produtos cadastrados
    $consultar = new Produto();
    $consultar->codUsuario = $_SESSION['codUsu'];
    $produtos = $consultar->consultaProduto();

    $consultarPag = new Pagamento();
    $consultarPag->codUsuario = $_SESSION['codUsu'];

    $pagamento = $consultarPag->consultaPagam();
    foreach ($pagamento as $pagamentos)
    {
    	if ($pagamentos["valor"] <= 0)
    	{
    		$despesas[] = $pagamentos;
    	}
    }
?> 