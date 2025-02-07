<?php
    $pageTitle = "Visão do produto";
    $pageCSS = ["visao11.css"];
    $pageJS = ["visao.js"];

    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
    include $BASE_PATH . 'src/View/header.php';

    include_once($BASE_PATH . 'src/Models/Produto.php');
    include_once($BASE_PATH . 'src/DAO/ProdutoDAO.php');

    //processamento produto
    $produtoDao = new ProdutoDAO($conn, $BASE_URL);

    //pegar o id do filme
    $id = filter_input(INPUT_GET, "id");

    $produto;

    if(empty($id)) {
        $message->setMessage("O produto não foi encontrado.", "error", "index.php");
        exit();
    }
    else {
        $produto = $produtoDao->findById($id);

        //verifica se o filme existe
        if(!$produto) {
            $message->setMessage("O produto não foi encontrado.", "error", "index.php");
            exit();
        }
    }

?>
    <main>

        <div class="esquerda">
           <div class="slider">
               <div class="slides">
                       <input type="radio" name="radio-btn" id="radio1">
                       <input type="radio" name="radio-btn" id="radio2">
                       <input type="radio" name="radio-btn" id="radio3">
                       <input type="radio" name="radio-btn" id="radio4">
                       <input type="radio" name="radio-btn" id="radio5">

   
                       <div class="slide first">
                           <img src="<?= $BASE_URL?>imagens/produtos/<?= $produto->imagens[0]?>">
                       </div>
                       <div class="slide">
                           <img src="<?= $BASE_URL?>imagens/produtos/<?= $produto->imagens[1]?>">
                       </div>
                       <div class="slide">
                           <img src="<?= $BASE_URL?>imagens/produtos/<?= $produto->imagens[2]?>">
                       </div>
                       <div class="slide">
                           <img src="<?= $BASE_URL?>imagens/produtos/<?= $produto->imagens[3]?>" >
                       </div>
                       <div class="slide">
                           <img src="<?= $BASE_URL?>imagens/produtos/<?= $produto->imagens[4]?>" >
                       </div>
               </div>
               <div class="manual-navigation">
                   <label for="radio1" class="manual-btn"><img src="<?= $BASE_URL?>imagens/produtos/<?= $produto->imagens[0]?>"></label>
                   <label for="radio2" class="manual-btn"><img src="<?= $BASE_URL?>imagens/produtos/<?= $produto->imagens[1]?>"></label>
                   <label for="radio3" class="manual-btn"><img src="<?= $BASE_URL?>imagens/produtos/<?= $produto->imagens[2]?>"></label>
                   <label for="radio4" class="manual-btn"><img src="<?= $BASE_URL?>imagens/produtos/<?= $produto->imagens[3]?>" ></label>
                   <label for="radio5" class="manual-btn"><img src="<?= $BASE_URL?>imagens/produtos/<?= $produto->imagens[4]?>" ></label>
               </div>
           </div>
        </div>  
    <div class="lado">
        <div class="direita">
            <div class="informaçoes">
                <span class="infor"><?= $produto->titulo?></span>
                <span class="infor2"><?= $produto->subtitulo?></span>
           
                <div class="avaliacoes">
                    <img src="imagens/star.png">
                    <img src="imagens/star.png">
                    <img src="imagens/star.png">
                    <img src="imagens/star.png">
                    <img src="imagens/star.png">
                    <span class="avalia">12.382</span>
                </div>
                <div class="share">
                    <a href="#" class="compar"><img src="imagens/share.png"></a>
                </div>
            </div>
          
        </div>
       
           
         <div class="importante">
            <div class="opcoes_pagamento1">
                <span class="inforpaga1">R$ <?= $produto->precoavista?></span>
                <div class="juntos">
                    <span class="inforpaga2">R$ <?= $produto->precoavista?></span>
                    <span class="inforpaga3"id="e1">ou</span>
                </div>
                <div class="juntos">
                    <span class="inforpaga4">R$ <?= $produto->precoavista?></span>
                    <span class="inforpaga3"id="e2">no pix</span>
                </div>
            </div>
           
            <div class="opcoes_pagamento2">
                <span class="inforpaga2"><?= $produto->nparcelas?>x R$ <?= $produto->precoparcelado?> sem juros</span>
                <span class="fpaga"><a href="#">Ver formas de pagamento</a></span>
                <div class="calcfrete">
                    <div class="juntos">
                        <img class="caminhão" src="imagens/caminhão 1.png">
                        <a href="#"><span onclick="exibirFormulario()" class="calcfret">Calcular Frete</span></a>
                    </div>
                </div>
            </div>
        </div>
            <div class="compracelfix">
                <img src="imagens/818911 1.png">
                <p class="cel">Compra e entraga feita por</p><p class="fix">CELFIX</p>
            </div>
   
            <div class="botao">
                <a href="<?= $BASE_URL?>pagamento22.php?Product=<?= $produto->id ?>"><button class="b1">
                        <span class="b2">Comprar agora</span>  <!--mexer no caminho-->
                </button></a>
   
                <a href="<?= $BASE_URL?>../src/Controller/carrinhoprocess.php?Product=<?= $produto->id ?>"><button class="b1">
                    <span class="b2">Adicionar ao carrinho</span>
                </button></a>
            </div>
        </div>

        <div class="avaliac">
            <div class="estrelasgrandes">
                <img src="imagens/star.svg">
                <div class="numeestre">
                   <span>4.4 /5</span>
                </div>
            </div>
             
            <div class="carrosseldeimagens">
                <div class="container">
                    <button class="arrow-left control" aria-label="Previous image">◀</button>
                    <button class="arrow-right control" aria-label="Next Image">▶</button>
                    <div class="gallery-wrapper">
                    <div class="gallery">
                        <img src="imagens/cara1.svg" alt="Beach Image" class="item current-item">
                        <img src="imagens/cara2.svg" alt="Animal Image" class="item">
                        <img src="imagens/cara3.svg" alt="Street Image" class="item">
                        <img src="imagens/cara4.svg" alt="Zoo Image" class="item">
                    </div>
                    </div>
                </div>
            </div>
   
            <div class="text_ava">
                <div class="qava">
                    <div class="fotocliente">
                        <img src="imagens/fotocliente.png">
                    </div>
                    <div class="alignju">
                        <div class="nomecliente">
                            <span>Antônio</span>
                        </div>
                        <div class="esava">
                            <img src="imagens/avaliacao.svg">
                        </div>
                   </div>
                    <div class="comentario">
                        <p class="c1">Muito bom entrega rapida e funciona muito bem “melhor que iphone”</p>
                    </div>
                </div>
   
                <div class="qava">
                    <div class="fotocliente">
                        <img src="imagens/fotocliente.png">
                    </div>
                    <div class="alignju">
                        <div class="nomecliente">
                            <span>Joacielio</span>
                        </div>
                        <div class="esava">
                            <img src="imagens/avaliacao.svg">
                        </div>
                    </div>
                    <div class="comentario">
                        <p class="c2">meu celular antigo não tinha memoria suficiente mas esse com 16GB estou satisfeito.</p>
                    </div>
               </div>
   
               <div class="qava">
                    <div class="fotocliente">
                        <img src="imagens/fotocliente.png">
                    </div>
                    <div class="alignju">
                        <div class="nomecliente">
                            <span>Rogério</span>
                        </div>
                        <div class="esava">
                            <img src="imagens/avaliacao.svg">
                        </div>
                    </div>
                   <div class="comentario">
                       <p class="c3">minha filha jogou esse celular da escada e continua funcionando.</p>
                   </div>
               </div>
   
               <div class="qava">
                    <div class="fotocliente">
                        <img src="imagens/fotocliente.png">
                    </div>
                    <div class="alignju">
                        <div class="nomecliente">
                            <span>Antoni</span>
                        </div>
                        <div class="esava">
                            <img src="imagens/avaliacao.svg">
                        </div>
                    </div>
                   <div class="comentario">
                       <p class="c4">superou minhas expectativas</p>
                   </div>
               </div>
   
               <div class="botaomais">
                <a href="#"><button>
                       <span>Ver mais</span>    
                    </button></a>
               </div>
            </div>
        </div>

        <!--Aqui comeca o frete-->
        <div class="comecafrete">
            <div id="freteBackground"></div>

            <!-- Formulário para calcular frete -->
            <div id="freteForm">
   
                <a onclick="fecharFormulario()"><img class="fecharfrete" src="imagens/fechar.png"></a>
                <h2 class="tifrete">Escolha sua localização</h2>
                <p class="cepfrete">Digite um cep</p>
                <form>       
                    
                         <input class="campofrete" type="text" id="destino" name="destino" placeholder="Digite o seu CEP" required>
                         <button class="botaofrete" type="button" onclick="calcularFrete()"><span class="okfrete"> OK</span></button>
                    
                </form> 
                <p id="resultado"></p>
                <p class="Enderecosfre">Acesse os endereços cadastrados</p>
                <button class="loginfrete"><span class="lfrete">Fazer login</span></button>
            </div>
        </div>
    </main>

    <?php
        include $BASE_PATH . 'src/View/footer.php';

    ?>