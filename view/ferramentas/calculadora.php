<?php
    include("../../controller/verificaLogin.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Calculadora de Preço</title>
  <link rel="shortcut icon" href="../img/favicon.svg" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../styles/calculadora.css">
</head>
<body>
  <main>
    <!-- Cabeçalho -->
    <section class="mt-3 text-center container">
      <div class="row py-lg-3">
        <div class="col-lg-6 col-md-8 mx-auto">
          <h1 class="fw-light">Calculadora de Preço</h1>
          <!-- Botão Voltar -->
          <div class="text-center mt-3 mb-3">
            <a class="btn btn-outline-primary w-25" href="../oficina.php">Voltar</a>
          </div>
          <p class="lead">
            Calcule o preço de venda com base no custo e na margem de lucro desejada.<br>
            Preencha os campos abaixo para obter o resultado.
          </p>
        </div>
      </div>
    </section>

    <div class="container">
      <div class="row g-4 justify-content-center">
        
        <div class="col-md-6">
          <div class="card p-4 shadow">
            <div class="mb-3">
              <label for="custo" class="form-label">Custo Total (R$):</label>
              <input type="number" class="form-control" id="custo" placeholder="Ex: 150.00" min="0" step="0.01">
            </div>

            <div class="mb-3">
              <label for="margem" class="form-label">Margem de Lucro (%):</label>
              <input type="number" class="form-control" id="margem" placeholder="Ex: 30" min="0" max="100" step="1">
            </div>

            <button class="btn btn-primary w-100" onclick="calcularPreco()">Calcular Preço de Venda</button>

            <div id="resultado" class="resultado" style="display:none;"></div>
          </div>
        </div>

        <div class="col-md-6">
          <button class="btn btn-outline-primary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHistorico" aria-expanded="true" aria-controls="collapseHistorico">
            Esconder Histórico de Cálculos
          </button>

          <div class="collapse show mt-3" id="collapseHistorico">
            <div class="d-flex justify-content-center">
              <div class="card p-4 shadow w-100">
                <h5>Histórico de Cálculos</h5>
                <ul id="historico" class="list-group mb-4" style="max-height: 220px; overflow-y: auto;"></ul>
                <button class="btn btn-outline-danger btn-sm w-100" onclick="limparHistorico()">Limpar Histórico</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Botão Voltar ao Topo -->
    <div class="text-center mt-4 mb-4">
      <a href="#" class="text-decoration-none back-to-top">Voltar para o topo</a>
    </div>
  </main>

  <script>
    function calcularPreco() {
      const custo = parseFloat(document.getElementById('custo').value);
      const margem = parseFloat(document.getElementById('margem').value);
      if (isNaN(custo) || isNaN(margem)) {
        alert('Por favor, preencha todos os campos corretamente.');
        return;
      }
      const precoVenda = custo + (custo * (margem / 100));
      const ganho = custo * (margem / 100);
      const resultado = document.getElementById('resultado');
      resultado.style.display = 'block';
      resultado.innerHTML = `Preço de venda sugerido: <strong>R$ ${precoVenda.toFixed(2)} (Lucro de R$ ${ganho.toFixed(2)})</strong>`;
      // Salva no histórico
      const historico = JSON.parse(localStorage.getItem('historicoPrecoVenda')) || [];
      historico.unshift({
        custo: custo.toFixed(2),
        margem: margem.toFixed(0),
        preco: precoVenda.toFixed(2),
        ganho: ganho.toFixed(2),
        data: new Date().toLocaleString()
      });
      localStorage.setItem('historicoPrecoVenda', JSON.stringify(historico));
      renderizarHistorico();
    }
    function renderizarHistorico() {
      const historico = JSON.parse(localStorage.getItem('historicoPrecoVenda')) || [];
      const lista = document.getElementById('historico');
      lista.innerHTML = "";
      if (historico.length === 0) {
        lista.innerHTML = '<li class="list-group-item">Nenhum cálculo salvo.</li>';
        return;
      }
      historico.forEach(item => {
        const li = document.createElement('li');
        li.className = 'list-group-item';
        li.innerHTML = `📜 R$ ${item.custo} + ${item.margem}% → <strong>R$ ${item.preco} (Lucro de R$ ${item.ganho})</strong><br><small>📆 ${item.data}</small>`;
        lista.appendChild(li);
          });
      }
      function limparHistorico() {
        localStorage.removeItem('historicoPrecoVenda');
        renderizarHistorico();
      }
  
      // Inicializa ao carregar a página
      renderizarHistorico();

      // Atualiza o texto do botão quando o histórico é escondido/mostrado
      document.getElementById('collapseHistorico').addEventListener('show.bs.collapse', function () {
          document.querySelector('[data-bs-target="#collapseHistorico"]').textContent = 'Esconder Histórico de Cálculos';
      });

      document.getElementById('collapseHistorico').addEventListener('hide.bs.collapse', function () {
          document.querySelector('[data-bs-target="#collapseHistorico"]').textContent = 'Mostrar Histórico de Cálculos';
      });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>