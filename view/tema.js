function aplicarTema(tema) {
    if (tema === 'dark') {
        document.body.classList.add('tema-escuro');
        document.body.classList.remove('tema-claro');
    } else if (tema === 'light') {
        document.body.classList.add('tema-claro');
        document.body.classList.remove('tema-escuro');
    } else {
        // Tema do dispositivo
        const preferencia = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        aplicarTema(preferencia);
        return;
    }

    localStorage.setItem('temaEscolhido', tema);
}

function carregarTema() {
    const temaSalvo = localStorage.getItem('temaEscolhido') || 'device';
    aplicarTema(temaSalvo);

    // Marcar radio na tela de configuração, se existir
    const radio = document.querySelector(`input[name="theme"][value="${temaSalvo}"]`);
    if (radio) radio.checked = true;
}

function saveSettings() {
    const temaSelecionado = document.querySelector('input[name="theme"]:checked').value;
    aplicarTema(temaSelecionado);
}

// Aplica o tema ao carregar qualquer página
window.addEventListener('DOMContentLoaded', carregarTema);