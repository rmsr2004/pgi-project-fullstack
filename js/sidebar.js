// Função para alternar a sidebar (abrir ou fechar)
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const button = document.getElementById('sidebarToggle');
    
    // Se a sidebar estiver aberta, fecha a sidebar
    if (sidebar.classList.contains('open')) {
      sidebar.classList.remove('open');
      button.innerHTML = '&#9776;'; // Muda o ícone para o de abrir (hamburguer)
    } else {
      // Caso contrário, abre a sidebar
      sidebar.classList.add('open');
      button.innerHTML = '&#10006;'; // Muda o ícone para o de fechar (X)
    }
  }
  