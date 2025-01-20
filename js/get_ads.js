window.onload = function() {
    fetch('../services/get_ads.php')
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                console.log('Anúncios carregados:', data);
                displayAds(data);
            } else {
                document.getElementById('an-container').innerHTML = 'Nenhum anúncio disponível.';
            }
        })
        .catch(error => console.error('Erro ao carregar os anúncios:', error));
}

function displayAds(ads) {
    const container = document.getElementById('an-container');

    // Para cada anúncio, cria um elemento HTML e adiciona ao container
    ads.forEach(ad => {
        const adElement = document.createElement('div');
        adElement.classList.add('an-item');
        
        // Usando o link da imagem que foi retornado pelo PHP
        const imageUrl = ad.first_image || '../images/house1.png';

        // Monta o HTML para o anúncio
        adElement.innerHTML = `
            <img src="${imageUrl}" alt="${ad.title}" class="an-image">
            <h3>${ad.title}</h3>
            <p>${ad.description}</p>
            <p>Preço: ${ad.price}€</p>
            <a href="ads_details.php?id=${ad.id}" class="button">Ver Mais</a>
        `;

        // Adiciona o anúncio ao container
        container.appendChild(adElement);
    });
}

