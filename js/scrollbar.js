// Adicionando um efeito de scroll suave com JavaScript e ajustando o deslocamento
const links = document.querySelectorAll('a[href^="#"]');
links.forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const targetId = this.getAttribute("href");
        const targetElement = document.querySelector(targetId);
        
        // Realizando o scroll, com um deslocamento de 80px
        window.scrollTo({
            top: targetElement.offsetTop - 80, // Ajuste o valor conforme necessário
            behavior: 'smooth'
        });
    });
});
