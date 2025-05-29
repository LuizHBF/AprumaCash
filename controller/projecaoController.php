<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebendo os dados do formulário
    $valorMeta = floatval($_POST['valorMeta']);
    $dataIni = new DateTime($_POST['dataIni']);
    $unidadeTempo = $_POST['unidadeTempo'];
    $tempoQuantidade = intval($_POST['tempoQuantidade']);
    $produtosSelecionados = isset($_POST['produtos']) ? $_POST['produtos'] : [];
    $despesasSelecionadas = isset($_POST['despesas']) ? $_POST['despesas'] : [];

    // Calcular a data final com base na unidade e quantidade
    switch ($unidadeTempo) {
        case 'days':
            $interval = new DateInterval("P{$tempoQuantidade}D");
            break;
        case 'weeks':
            $interval = new DateInterval("P" . ($tempoQuantidade * 7) . "D");
            break;
        case 'months':
            $interval = new DateInterval("P{$tempoQuantidade}M");
            break;
        case 'years':
            $interval = new DateInterval("P{$tempoQuantidade}Y");
            break;
        default:
            $_SESSION['erro'] = "Unidade de tempo inválida!";
            header('Location: ../view/ferramentas/projecao.php');
            exit;
    }

    // Data final
    $dataFim = clone $dataIni;
    $dataFim->add($interval);

    // Dias entre dataIni e dataFim
    $diasDiferenca = $dataFim->diff($dataIni)->days;
    if ($diasDiferenca <= 0) {
        $_SESSION['erro'] = "Intervalo de tempo inválido.";
        header('Location: ../view/ferramentas/projecao.php');
        exit;
    }

    // Calcular total de despesas selecionadas
    $totalDespesas = 0;
    if (!empty($despesasSelecionadas)) {
        include_once __DIR__ . '/../model/model_pagamentos.php';
        $consultarDesp = new Pagamento();
        $consultarDesp->codUsuario = $_SESSION['codUsu'];

        $pagamento = $consultarDesp->consultaPagam();
        foreach ($pagamento as $pagamentos)
        {
    	    if ($pagamentos["valor"] <= 0)
    	    {
    		    $despesas[] = $pagamentos;
    	    }
        }
        
        foreach ($despesas as $despesa) {
            if (in_array($despesa['cod'], $despesasSelecionadas)) {
                // Calcula o valor total das despesas no período
                $valorDespesa = abs($despesa['valor']);
                $periodoDespesa = 0;
                
                if (strpos($despesa['periodo'], 'dias') !== false) {
                    $periodoDespesa = 1;
                } elseif (strpos($despesa['periodo'], 'semanas') !== false) {
                    $periodoDespesa = 7;
                } elseif (strpos($despesa['periodo'], 'meses') !== false) {
                    $periodoDespesa = 30;
                } elseif (strpos($despesa['periodo'], 'anos') !== false) {
                    $periodoDespesa = 365;
                }
                
                // Calcula quantos períodos completos da despesa cabem no período total
                $quantidadePeriodos = floor($diasDiferenca / $periodoDespesa);
                $totalDespesas += $valorDespesa * $quantidadePeriodos;
            }
        }
    }

    // Calcular meta diária considerando despesas
    $metaTotal = $valorMeta + $totalDespesas;
    $metaDiaria = $metaTotal / $diasDiferenca;

    // Calcular quantidade de produtos necessária por dia
    $quantidadeProdutosPorDia = [];
    if (!empty($produtosSelecionados)) {
        include_once __DIR__ . '/../model/model_produto.php';
        $consultarProd = new Produto();
        $consultarProd->codUsuario = $_SESSION['codUsu'];
        $produtos = $consultarProd->consultaProduto();
        
        foreach ($produtos as $produto) {
            if (in_array($produto['cod'], $produtosSelecionados)) {
                $quantidadeProdutosPorDia[$produto['nome']] = ceil($metaDiaria / $produto['valor']);
            }
        }
    }

    // Armazenar resultado para exibir na interface
    $_SESSION['resultado_meta'] = [
        'dataInicio' => $dataIni->format('d/m/Y'),
        'dataFinal' => $dataFim->format('d/m/Y'),
        'valorMeta' => number_format($valorMeta, 2, ',', '.'),
        'dias' => $diasDiferenca,
        'metaDiaria' => number_format($metaDiaria, 2, ',', '.'),
        'totalDespesas' => number_format($totalDespesas, 2, ',', '.'),
        'metaTotal' => number_format($metaTotal, 2, ',', '.'),
        'quantidadeProdutosPorDia' => $quantidadeProdutosPorDia
    ];

    header('Location: ../view/ferramentas/projecao.php');
    exit;
}