function toggleSteps() {
    const studentSteps = document.getElementById('studentSteps');
    const elderlySteps = document.getElementById('elderlySteps');
    const button = document.getElementById('toggleButton');
  
    // Alterna entre as seções
    if (studentSteps.style.display === "none") {
      studentSteps.style.display = "block";
      elderlySteps.style.display = "none";
      button.textContent = "Ver Etapas para Idosos";
    } else {
      studentSteps.style.display = "none";
      elderlySteps.style.display = "block";
      button.textContent = "Ver Etapas para Estudantes";
    }
  }
  