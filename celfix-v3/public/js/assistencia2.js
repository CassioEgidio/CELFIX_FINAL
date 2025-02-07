var imagemSelecionada = ""; // Variável global para armazenar a imagem clicada no primeiro modal
  var aparelhoSelecionado = ""; // Variável para armazenar o aparelho selecionado

  function abrirModal() {
    document.getElementById("freteBackground").style.display = "block";
    document.getElementById('myModal').style.display = 'block';
  }

  function fecharModal() {
    document.getElementById('myModal').style.display = 'none';
    document.getElementById("freteBackground").style.display = "none";
  }

  function alterarBotao(img) {
    var icon = img.src;
    document.getElementById('modalButton1').innerHTML = '<img src="' + icon + '" alt="Imagem Clicada" class="imgbt1res">'; 
    imagemSelecionada = icon; 

    // Armazena o valor da marca no input hidden
    document.getElementById('marca').value = img.alt;
    console.log(document.getElementById('marca').value);

    var modalButton = document.getElementById('modalButton2');
    var textsegunda = document.getElementById('textseg');

    textsegunda.classList.remove('disabledcor');
    modalButton.classList.remove('disabled');
    modalButton.disabled = false;
    modalButton.classList.add('transib2');

    var imagemq2 = document.getElementById('imgtrocar');
    imagemq2.src = 'http://localhost/celfix-v3/public/imagens/mais.png';  //futuramanete mexer

    fecharModal();
  }

  function abrirModal2() {
    if (imagemSelecionada !== "") {
      document.getElementById("freteBackground").style.display = "block";
      document.getElementById('myModal2').style.display = 'block';
      mostrarImagensEspecificas();
    }
  }

  function fecharModal2() {
    document.getElementById('myModal2').style.display = 'none';
    document.getElementById("freteBackground").style.display = "none";
  }

  function alterarBotao2(img) {
    var icon = img.src;
    document.getElementById('modalButton2').innerHTML = '<img src="' + icon + '" alt="Imagem Clicada" class="imgbt2res">'; 
    aparelhoSelecionado = img.alt; 
    //aparelhoSelecionado2 = img.src; 

    // Armazena o valor do aparelho no input hidden
    document.getElementById('aparelho').value = aparelhoSelecionado;
    console.log(document.getElementById('aparelho').value);

    fecharModal2();
  }

  function mostrarImagensEspecificas() {
    var imagens = document.querySelectorAll('#myModal2 .modal-content figure');
    for (var i = 0; i < imagens.length; i++) {
      imagens[i].style.display = 'none';

      var img = imagens[i].querySelector('img');

      if (imagemSelecionada.endsWith('apple-logo.png') && img.alt.startsWith('Apple')) {
        imagens[i].style.display = 'flex';
      }else if (imagemSelecionada.endsWith('apple-logo.png') && img.alt.startsWith('Iphone')) {
        imagens[i].style.display = 'flex';
      }else if (imagemSelecionada.endsWith('motorola-logo.png') && img.alt.startsWith('Motorola')) {
        imagens[i].style.display = 'flex';
      } else if (imagemSelecionada.endsWith('samsung-logo.png') && img.alt.startsWith('Samsung')) {
        imagens[i].style.display = 'flex';
      } else if (imagemSelecionada.endsWith('lg-logo.png') && img.alt.startsWith('LG')) {
        imagens[i].style.display = 'flex';
      } else if (imagemSelecionada.endsWith('realme-logo.png') && img.alt.startsWith('Realme')) {
        imagens[i].style.display = 'flex';
      } else if (imagemSelecionada.endsWith('xiaomi-logo.png') && img.alt.startsWith('Xiaomi')) {
        imagens[i].style.display = 'flex';
      } else if (imagemSelecionada.endsWith('sony-logo.png') && img.alt.startsWith('Sony')) {
        imagens[i].style.display = 'flex';
      }
    }
  }

  function atualizarDescricao() {
    var descricaoTexto = document.getElementById('problemaAparelho').value;
    document.getElementById('descricao').value = descricaoTexto;
    console.log(document.getElementById('descricao').value);

    let idpa = document.getElementById("idaparelho");
    let idAparelho = idpa.innerText;
    document.getElementById('idapar').value = idAparelho;
    console.log(document.getElementById('idapar').value);
  }