//parte cassio

const controls = document.querySelectorAll(".control");
let currentItem = 0;
const items = document.querySelectorAll(".item");
const maxItems = items.length;

controls.forEach((control) => {
  control.addEventListener("click", (e) => {
    const isLeft = e.target.classList.contains("arrow-left");

    // Muda o item atual com base na seta clicada
    if (isLeft) {
      currentItem -= 1;
    } else {
      currentItem += 1;
    }

    // Recomeça do início ou do final, dependendo da seta
    if (currentItem >= maxItems) {
      currentItem = 0;
    }

    if (currentItem < 0) {
      currentItem = maxItems - 1;
    }

    // Remove a classe 'current-item' de todos os itens
    items.forEach((item) => item.classList.remove("current-item"));

    // Adiciona a classe 'current-item' ao item atual
    items[currentItem].scrollIntoView({
      behavior: "smooth",
      inline: "center"
    });

    items[currentItem].classList.add("current-item");
  });
});


//frete
function exibirFormulario() {
  // Exibir o fundo semi-transparente e o formulário
  document.getElementById("freteBackground").style.display = "flex";
  document.getElementById("freteForm").style.display = "flex";
}

function fecharFormulario() {
  // Fechar o fundo semi-transparente e o formulário
  document.getElementById("freteBackground").style.display = "none";
  document.getElementById("freteForm").style.display = "none";
}

function calcularFrete() {
  // Lógica de cálculo de frete (pode ser implementada conforme necessário)
  var peso = 10;
  var destino = document.getElementById("destino").value;

  // Exemplo simples: Valor fixo de R$ 10 por quilo
  var valorFrete = peso * 10;

  // Exibir o resultado na página
  var resultadoElement = document.getElementById("resultado");
  resultadoElement.innerHTML = `O frete para ${destino} é de R$ ${valorFrete.toFixed(2)}.`;
}