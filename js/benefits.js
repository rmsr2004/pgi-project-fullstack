// Estado inicial para estudantes
let showingStudents = false;

function toggleBenefits() {
    const benefitsGrid = document.getElementById('benefitsGrid');
    const toggleButton = document.getElementById('toggleButton');

    if (showingStudents) {
        // Benefícios para idosos
        const elderlyBenefits = [
            {
                title: "Rentabilização",
                description: "Ganhe dinheiro com um quarto que não está em uso."
            },
            {
                title: "Fim da Solidão",
                description: "Tenha companhia de jovens estudantes e crie conexões."
            },
            {
                title: "Segurança",
                description: "Garantimos um processo seguro e confiável."
            },
            {
                title: "Contribuição",
                description: "Ajude um estudante a começar sua vida em uma nova cidade."
            }
        ];

        // Atualizar os quadrados
        benefitsGrid.innerHTML = elderlyBenefits.map(benefit => `
            <div class="benefit-item">
                <h3>${benefit.title}</h3>
                <p>${benefit.description}</p>
            </div>
        `).join('');

        // Alterar texto do botão
        toggleButton.innerText = "Benefícios para Estudantes";
    } else {
        // Benefícios para estudantes
        const studentBenefits = [
            {
                title: "Alojamento Rápido",
                description: "Encontra quartos disponíveis de forma mais fácil e acessível."
            },
            {
                title: "Integração",
                description: "Sente-te em casa com o carinho de uma pessoa idosa"
            },
            {
                title: "Economia",
                description: "Despesas reduzidas em comparação com outras opções de alojamento."
            },
            {
                title: "Apoio Social",
                description: "Recebe orientação e companhia de pessoas mais experientes."
            }
        ];

        // Atualizar os quadrados
        benefitsGrid.innerHTML = studentBenefits.map(benefit => `
            <div class="benefit-item">
                <h3>${benefit.title}</h3>
                <p>${benefit.description}</p>
            </div>
        `).join('');

        // Alterar texto do botão
        toggleButton.innerText = "Benefícios para Idosos";
    }

    // Alternar estado
    showingStudents = !showingStudents;
}

// Inicializa os benefícios com os dados dos estudantes
toggleBenefits();
