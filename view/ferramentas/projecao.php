<?php
    include("../../controller/verificaLogin.php");
    include '../../controller/controlar_projecao.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ferramenta de Projeção</title>
    <link rel="shortcut icon" href="../img/favicon.svg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../view/styles/projecao.css">
</head>
<body>
    <main>
        <!-- Cabeçário -->
        <section class="mt-3 text-center container">
            <div class="row py-lg-3">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light">Ferramenta de Projeção</h1>
                    <!-- Botão Voltar -->
                    <div class="text-center mt-3 mb-3">
                        <a class="btn btn-outline-primary w-25" href="../oficina.php">Voltar</a>
                    </div>
                    <p class="lead text-body-secondary">
                        Calcule quanto você precisa vender para atingir sua meta, considerando suas despesas fixas.
                    </p>
                </div>
            </div>
        </section>

        <div class="container py-5">
            <form action="../../controller/projecaoController.php" method="post">
                <div class="row">
                    <!-- Seleção de Produtos -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Selecione os produtos</h5>
                            </div>
                            <div class="card-body">
                                <div class="checkbox-group">
                                    <div class="scrollable-options">
                                        <div class="checkbox-option select-all">
                                            <input type="checkbox" id="selectAll" name="selectAll" class="form-check-input">
                                            <label for="selectAll" class="form-check-label">Selecionar Todos</label>
                                            <span id="selectedCount" class="selected-count">(0)</span>
                                        </div>
                                        <?php if (isset($produtos) && $produtos != []): ?>
                                            <?php foreach ($produtos as $produto): ?>
                                                <div class="checkbox-option">
                                                    <input type="checkbox" id="produto_<?= $produto['cod'] ?>" name="produtos[]" value="<?= $produto['cod'] ?>" class="form-check-input">
                                                    <label for="produto_<?= $produto['cod'] ?>" class="form-check-label"><?= $produto['nome'] ?> - R$ <?= number_format($produto['valor'], 2, ',', '.') ?></label>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="text-center">
                                                <p>Nenhum produto cadastrado</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Seleção de Despesas -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Selecione as despesas</h5>
                            </div>
                            <div class="card-body">
                                <div class="checkbox-group">
                                    <div class="scrollable-options">
                                        <div class="checkbox-option select-all">
                                            <input type="checkbox" id="selectAllD" name="selectAllD" class="form-check-input">
                                            <label for="selectAllD" class="form-check-label">Selecionar Todos</label>
                                            <span id="selectedCountD" class="selected-count">(0)</span>
                                        </div>
                                        <?php if (isset($despesas) && $despesas != []): ?>
                                            <?php foreach ($despesas as $despesas): ?>
                                                <div class="checkbox-option">
                                                    <input type="checkbox" id="despesas_<?= $despesas['cod'] ?>" name="despesas[]" value="<?= $despesas['cod'] ?>" class="form-check-input">
                                                    <label for="despesas_<?= $despesas['cod'] ?>" class="form-check-label"><?= $despesas['nome'] ?> - R$ <?= number_format($despesas['valor'], 2, ',', '.') ?></label>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="text-center">
                                                <p>Nenhuma despesa cadastrada</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Configurações da Meta -->
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Configurações da Meta</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="valorMeta" class="form-label">Valor a Alcançar (R$)</label>
                                        <input type="number" class="form-control" id="valorMeta" name="valorMeta" placeholder="Digite a meta" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="dataIni" class="form-label">Data de Início</label>
                                        <input type="date" class="form-control" id="dataIni" name="dataIni" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="unidadeTempo" class="form-label">Período</label>
                                        <select class="form-select" id="unidadeTempo" name="unidadeTempo">
                                            <option value="days">Dias</option>
                                            <option value="weeks">Semanas</option>
                                            <option value="months">Meses</option>
                                            <option value="years">Anos</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="tempo" class="form-label">ㅤ</label>
                                        <input type="number" class="form-control" id="tempo" name="tempoQuantidade" placeholder="Digite a quantidade" required>
                                    </div>
                                </div>
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary">Calcular Projeção</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Resultado da Projeção -->
            <?php if (isset($_SESSION['resultado_meta'])): ?>
            <div id="resultadoProjecao">
                <div class="card shadow-sm mt-4">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="card-title mb-0">Resultado da Projeção</h5>
                            <img src="../../view/img/icone_download.png" id="downloadPDF" title="Baixar PDF" style="cursor:pointer; width:32px; height:32px; margin-left:10px;">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Data de início:</strong> <?= $_SESSION['resultado_meta']['dataInicio'] ?></p>
                                <p><strong>Data final:</strong> <?= $_SESSION['resultado_meta']['dataFinal'] ?></p>
                                <p><strong>Meta de lucro desejada:</strong> R$ <?= $_SESSION['resultado_meta']['valorMeta'] ?></p>
                                <p><strong>Total de despesas fixas no período:</strong> R$ <?= $_SESSION['resultado_meta']['totalDespesas'] ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Meta total (lucro + despesas):</strong> R$ <?= $_SESSION['resultado_meta']['metaTotal'] ?></p>
                                <p><strong>Duração:</strong> <?= $_SESSION['resultado_meta']['dias'] ?> dias</p>
                                <p><strong>Meta diária necessária:</strong> R$ <?= $_SESSION['resultado_meta']['metaDiaria'] ?></p>
                            </div>
                        </div>
                        
                        <?php if (!empty($_SESSION['resultado_meta']['quantidadeProdutosPorDia'])): ?>
                            <div class="mt-4">
                                <h5>Quantidade mínima de cada produto que deve ser vendida por dia para atingir a meta e cobrir as despesas (considerando a venda exclusiva de cada produto):</h5>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Produto</th>
                                                <th>Quantidade Diária</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($_SESSION['resultado_meta']['quantidadeProdutosPorDia'] as $produto => $quantidade): ?>
                                                <tr>
                                                    <td><?= $produto ?></td>
                                                    <td><?= $quantidade ?> unidades</td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php unset($_SESSION['resultado_meta']); ?>
            <?php endif; ?>
        </div>

        <!-- Botão Voltar ao Topo -->
        <div class="text-center mb-4">
          <a href="#" class="text-decoration-none back-to-top">Voltar para o topo</a>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        // Selecionar todos os produtos
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="produtos[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateSelectedCount("produtos");
        });

        // Selecionar todas as despesas
        document.getElementById('selectAllD').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="despesas[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateSelectedCount("despesas");
        });

        // Adicionar event listeners para checkboxes individuais de produtos
        document.querySelectorAll('input[name="produtos[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateSelectedCount("produtos");
            });
        });

        // Adicionar event listeners para checkboxes individuais de despesas
        document.querySelectorAll('input[name="despesas[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateSelectedCount("despesas");
            });
        });

        // Atualizar contador de selecionados
        function updateSelectedCount(campo) {
            if(campo == "produtos") {
                const selectedCount = document.querySelectorAll('input[name="produtos[]"]:checked').length;
                document.getElementById('selectedCount').textContent = `(${selectedCount})`;
            } else if (campo == "despesas") {
                const selectedCount = document.querySelectorAll('input[name="despesas[]"]:checked').length;
                document.getElementById('selectedCountD').textContent = `(${selectedCount})`;
            }
        }

        document.getElementById('downloadPDF').addEventListener('click', function () {
            const resultado = document.getElementById('resultadoProjecao');
            html2canvas(resultado).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new window.jspdf.jsPDF('p', 'mm', 'a4');
                const pageWidth = pdf.internal.pageSize.getWidth();
                const pageHeight = pdf.internal.pageSize.getHeight();
                const imgProps = pdf.getImageProperties(imgData);
                const pdfWidth = pageWidth;
                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
                let position = 0;

                if (pdfHeight < pageHeight) {
                    pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, pdfHeight);
                } else {
                    // Se o conteúdo for maior que uma página, divide em várias páginas
                    let heightLeft = pdfHeight;
                    while (heightLeft > 0) {
                        pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, pdfHeight);
                        heightLeft -= pageHeight;
                        if (heightLeft > 0) {
                            pdf.addPage();
                            position = 0;
                        }
                    }
                }
                pdf.save('resultado_projecao.pdf');
            });
        });
    </script>
</body>
</html>