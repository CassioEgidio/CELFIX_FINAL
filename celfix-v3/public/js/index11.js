let count = 1;
document.getElementById("radio1").checked = true;

setInterval( function(){
  nextImage();
},  6000)

function nextImage(){
  count++;
  if(count>4){
    count = 1;
  }
  document.getElementById("radio"+count).checked = true;
}

//carrossel //cards produtos

function updateMargin(sliderId) {
  const slider = document.getElementById(sliderId);
  const radiobtns = slider.querySelectorAll('input[type="radio"]');
  const cardsProd = slider.querySelector('.cards');

  // Associamos cada botão a uma margem específica
  const margins = [0, 99, 198];

  // Encontramos o índice do botão selecionado
  let selectedIndex = -1;
  radiobtns.forEach((radio, index) => {
    if (radio.checked) {
      selectedIndex = index;
    }
  });

  // Aplicamos a margem correspondente
  if (selectedIndex !== -1) {
    cardsProd.style.right = `${margins[selectedIndex]}%`;
  }
}

function setupSliders() {
  // Seleciona todos os sliders
  const sliders = document.querySelectorAll('.sliderProd');

  sliders.forEach(slider => {
      const radioBtns = slider.querySelectorAll('input[type="radio"]');

      // Adiciona o evento de mudança para cada botão de rádio dentro do slider
      radioBtns.forEach(radio => {
          radio.addEventListener('change', () => updateMargin(slider.id));
      });

      // Atualiza o estado inicial
      updateMargin(slider.id);
  });
}

// Inicializa os sliders ao carregar a página
document.addEventListener('DOMContentLoaded', setupSliders);