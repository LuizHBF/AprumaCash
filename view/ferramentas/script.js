document.getElementById('calcularValor').addEventListener('click', function() {
    const valorMeta = parseFloat(document.getElementById('valorMeta').value) || 0;
    const tempo = parseFloat(document.getElementById('tempo').value) || 0;
    const unidadeTempo = document.getElementById('unidadeTempo').value;

    // Converte o tempo para dias
    let dias = tempo;
    if (unidadeTempo === 'meses') {
        dias *= 30; // Aproximadamente 30 dias em um mês
    } else if (unidadeTempo === 'anos') {
        dias *= 365; // Aproximadamente 365 dias em um ano
    }
});