<?php
  session_start();

  // Verifica se o usuário está logado
  if (!isset($_SESSION['codUsu'])) {
      header("Location: loginView.php?erro=acesso");
      exit;
  }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carregando...</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body, html {
        margin: 0;
        padding: 0;
        background: linear-gradient(135deg, #f8f8f8, #e0e0e0);
        font-family: 'Segoe UI', sans-serif;
        height: 100%;
        width: 100%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .container {
        text-align: center;
      }

      .message {
        font-size: 1.5rem;
        margin-bottom: 20px;
      }

      .progress-bar {
        width: 300px;
        height: 25px;
        background-color:rgba(168, 168, 168, 0.82);
        border-radius: 20px;
        overflow: hidden;
        margin: auto;
      }

      .progress {
        height: 100%;
        width: 0;
        background: linear-gradient(90deg,rgb(46, 40, 228), #120F59);
        transition: width 0.2s ease;
      }

      .percent {
        margin-top: 15px;
        font-size: 1.2rem;
      }
    </style>
</head>
<body>
    <div class="position-absolute" style="margin-top: -50vh;">
          <a href="index.html"><img id="logo" src="./img/logo_tema_claro.svg" alt="logo" width="120px"></a>
    </div>
    <div class="container">
      <div class="message" id="mensagem">Preparando ferramentas...</div>
      <div class="progress-bar">
        <div class="progress" id="progresso"></div>
      </div>
      <div class="percent" id="porcentagem">0%</div>
    </div>

    <script>
      let porcentagem = 0;
      const progresso = document.getElementById("progresso");
      const porcentagemTexto = document.getElementById("porcentagem");
      const mensagem = document.getElementById("mensagem");
        
      const mensagens = [
        "Carregando oficina...",
        "Preparando ferramentas...",
        "Quase lá..."
      ];
    
      // Benchmark simples de CPU
      function medirDesempenhoCPU() {
        const start = performance.now();
        for (let i = 0; i < 1e6; i++) {
          Math.sqrt(i); // operação "pesada"
        }
        const end = performance.now();
        return end - start; // tempo em ms
      }
    
      const tempoBenchmark = medirDesempenhoCPU();
    
      // Define velocidade de carregamento com base no desempenho
      let incremento;
      if (tempoBenchmark < 10) {
        incremento = 5; // dispositivo rápido
      } else if (tempoBenchmark < 20) {
        incremento = 3; // intermediário
      } else {
        incremento = 2; // mais lento
      }
    
      const intervalo = setInterval(() => {
        porcentagem += incremento;
      
        if (porcentagem > 100) porcentagem = 100;
      
        progresso.style.width = porcentagem + "%";
        porcentagemTexto.textContent = porcentagem + "%";
      
        if (porcentagem < 40) {
          mensagem.textContent = mensagens[0];
        } else if (porcentagem < 80) {
          mensagem.textContent = mensagens[1];
        } else {
          mensagem.textContent = mensagens[2];
        }
      
        if (porcentagem >= 100) {
          clearInterval(intervalo);
          setTimeout(() => {
            window.location.href = "oficina.php";
          }, 300);
        }
      
      }, 50); // mantém transição fluida
    </script>
</body>
</html>