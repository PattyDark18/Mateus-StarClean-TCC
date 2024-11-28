function mostrarMais() {
  // Seleciona todos os cards inativos
  const cardInativo = document.querySelectorAll('.card-servico:not(.ativo)');
  
  // Adiciona a classe "ativo" para todos os cards inativos
  cardInativo.forEach(card => {
    card.classList.add('ativo');
  });
  
  // Oculta o botão "Mostrar Mais" depois que todos os cards são exibidos
  document.querySelector('.Mostrar-Mais-Servicos').style.display = 'none';
}

// Adiciona um listener para o clique no botão "Mostrar Mais"
document.querySelector('.Mostrar-Mais-Servicos').addEventListener('click', mostrarMais);
