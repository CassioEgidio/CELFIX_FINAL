<?php
    $pageTitle = "Celfix";
    $pageCSS = ["assistencia.css"];
    $pageJS = ["assistencia2.js"];

    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');

    include_once($BASE_PATH . 'config/db.php');
    include_once($BASE_PATH . 'src/DAO/UserDAO.php');

    $userDao = new UserDAO($conn, $BASE_URL);
    $userData = $userDao->verifyToken(true);

    include $BASE_PATH . 'src/View/header.php';

    include_once($BASE_PATH . 'src/Models/Aparelho.php');
    include_once($BASE_PATH . 'src/DAO/AparelhoDAO.php');

    //processamento produto
    $aparelhoDao = new AparelhoDAO($conn, $BASE_URL);

    $aparelhos = $aparelhoDao->findAll(); //fazendo ainda

    //print_r($aparelhos);exit();

?>

    <main>
      <div class="conteiner">
        <div class="esquerda">
          <div class="conj1">
            <p class="txt1">Insira a marca do aparelho</p>

            <button id="modalButton1" class="b1" onclick="abrirModal()">
              <img class="ad1" src="<?= $BASE_URL ?>imagens/mais.png" />
            </button>
          </div>

          <div class="conj2">
            <p id="textseg" class="txt2 disabledcor">Insira o aparelho correspondente</p>

            <button id="modalButton2" class="b2 disabled"  onclick="abrirModal2()" disabled>
              <img id="imgtrocar" class="ad2" src="<?= $BASE_URL ?>imagens/add2.png" />
            </button>
          </div>
        </div>

        <div class="direita">

          <div class="foratext">
             <textarea class="textarea" id="problemaAparelho" placeholder="Descreva o problema do aparelho detalhadamente"></textarea>
          </div>

          <div class="divbotaonext">

              <form onsubmit="atualizarDescricao()" action="<?= $BASE_URL ?>assistenciapagina2.php" method="post">
                <input type="hidden" value="" id="marca" name="marca">
                <input type="hidden" value="" id="aparelho" name="aparelho">
                <input type="hidden" value="" id="descricao" name="descricao">
                <input type="hidden" value="" id="idapar" name="idapar">
                <input type="hidden" value="<?=$userData->id?>" name="idusuario">
                <input class="buttonmetodo" type="submit" value="Avançar">
              </form>

          </div>

        </div>
      </div>

     
    <!-- Modal 1: Seleção de Marcas -->
    <div id="freteBackground"></div>

    <div id="myModal" class="modal">
          <span class="close" onclick="fecharModal()"><img src="<?= $BASE_URL ?>imagens/canceldownloads.png"></span>

          <div class="modal-content">

           <figure class="image-container">
             <img class="img1modal" src="<?= $BASE_URL ?>imagens/marca/apple-logo.png" onclick="alterarBotao(this)" alt="Apple">
             <figcaption class="text1modal">Apple</figcaption>
           </figure>

           <figure class="image-container">
            <img class="img1modal" src="<?= $BASE_URL ?>imagens/marca/samsung-logo.png" onclick="alterarBotao(this)" alt="Samsung">
            <figcaption class="text1modal">Samsung</figcaption>
           </figure>

           <figure class="image-container">
             <img class="img1modal" src="<?= $BASE_URL ?>imagens/marca/motorola-logo.png" onclick="alterarBotao(this)" alt="Motorola">
             <figcaption class="text1modal">Motorola</figcaption>
           </figure>

           <figure class="image-container">
            <img class="img1modal" src="<?= $BASE_URL ?>imagens/marca/lg-logo.png" onclick="alterarBotao(this)" alt="LG">
            <figcaption class="text1modal">LG</figcaption>
          </figure>

          <figure class="image-container">
            <img class="img1modal" src="<?= $BASE_URL ?>imagens/marca/realme-logo.png" onclick="alterarBotao(this)" alt="Realme">
            <figcaption class="text1modal">Realme</figcaption>
          </figure>

          <figure class="image-container">
            <img class="img1modal" src="<?= $BASE_URL ?>imagens/marca/xiaomi-logo.png" onclick="alterarBotao(this)" alt="Xiaomi">
            <figcaption class="text1modal">Xiaomi</figcaption>
          </figure>

          <figure class="image-container">
            <img class="img1modal" src="<?= $BASE_URL ?>imagens/marca/sony-logo.png" onclick="alterarBotao(this)" alt="Sony">
            <figcaption class="text1modal">Sony</figcaption>
          </figure>
          
          </div>
     </div>
     </div>

     <!-- Modal 2: Seleção do aparelho -->
     <div id="myModal2" class="modal2">
      <span class="close" onclick="fecharModal2()"><img src="<?= $BASE_URL ?>imagens/canceldownloads.png"></span>

      <div class="modal-content">

        <?php foreach($aparelhos as $aparelho): ?>

          <figure class="image-container">
            <img class="img1modal" src="<?= $BASE_URL ?>imagens/aparelhos/<?= $aparelho->image_aparelho?>" onclick="alterarBotao2(this)" alt="<?= $aparelho->Descricao?>">
            <figcaption class="text1modal"><?= $aparelho->Descricao?></figcaption>
            <p id="idaparelho" style="display: none;"><?= $aparelho->id_aparelho?></p>
          </figure>

        <?php endforeach; ?>   

      </div>
     </div>
    </main>

   
  </body>
</html>