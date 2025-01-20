// Seleciona o indicador de scroll
const scrollIndicator = document.getElementById('scrollIndicator');

// Função para ocultar o indicador quando há scroll
window.addEventListener('scroll', () => {
    if (window.scrollY > 50) { // Se o scroll for maior que 50px
        scrollIndicator.classList.add('hidden'); // Adiciona a classe que oculta
    }
});

