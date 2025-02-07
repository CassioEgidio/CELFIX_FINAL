<?php
    $pageTitle = "Celfix";
    $pageCSS = ["index1.css"];
    $pageJS = ["index11.js"];

    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
    include $BASE_PATH . 'src/View/header.php';

    include_once($BASE_PATH . 'src/Models/Produto.php');
    include_once($BASE_PATH . 'src/DAO/ProdutoDAO.php');

    //processamento produto
    $produtoDao = new ProdutoDAO($conn, $BASE_URL);

    $maisvendidos = $produtoDao->getProdutoByCategory("produtos mais vendidos");
    $fonesproduto = $produtoDao->getProdutoByCategory("fones");
    $celularesproduto = $produtoDao->getProdutoByCategory("celulares");
    $capinhasproduto = $produtoDao->getProdutoByCategory("capinhas");
    $acessoriosproduto = $produtoDao->getProdutoByCategory("acessórios");
    $tabletsproduto = $produtoDao->getProdutoByCategory("tablets");
    $carregadoresproduto = $produtoDao->getProdutoByCategory("carregadores");

    //print_r($maisvendidos);exit();

?>

    <main>
        <div class="slider">
            <div class="slides">
                    <input type="radio" name="radio-btn" id="radio1">
                    <input type="radio" name="radio-btn" id="radio2">
                    <input type="radio" name="radio-btn" id="radio3">
                    <input type="radio" name="radio-btn" id="radio4">

                    <div class="slide first">
                        <img src="<?= $BASE_URL?>imagens/banner1.png" alt="Banner 1">
                    </div>
                    <div class="slide">
                        <img src="<?= $BASE_URL?>imagens/banner2.png" alt="Banner 2">
                    </div>
                    <div class="slide">
                        <img src="<?= $BASE_URL?>imagens/banner3.png" alt="Banner 3">
                    </div>
                    <div class="slide">
                        <img src="<?= $BASE_URL?>imagens/banner4.png" alt="Banner 3">
                    </div>

                    <div class="navigation-auto">
                        <div class="auto-btn1"></div>
                        <div class="auto-btn2"></div>
                        <div class="auto-btn3"></div>
                        <div class="auto-btn4"></div>
                    </div>
            </div>
            <div class="manual-navigation">
                <label for="radio1" class="manual-btn"></label>
                <label for="radio2" class="manual-btn"></label>
                <label for="radio3" class="manual-btn"></label>
                <label for="radio4" class="manual-btn"></label>
            </div>
        </div>

        <div class="botoes">
            <div class="btnloja">
                <a href="<?= $BASE_URL?>loja.php" class="Loja"><img src="<?= $BASE_URL?>imagens/lojabtn.svg" alt="Ir a loja"></a>
            </div>
            <div class="btnreparo">
                <a href="<?= $BASE_URL?>assistencia.php" class="Reparo"><img src="<?= $BASE_URL?>imagens/reparobtn.svg" alt="Ir a reparo"></a>
            </div>
        </div>
        
        <div class="separador"></div>

        <!--aqui começa o card de produtos-->

        <?php if(count($maisvendidos) != 0): ?>
            <div class="sliderProd" id="slider1">
                <div class="cat">Produtos mais vendidos</div>
                <div class="slideProd"> 

                    <div class="cards" id="cards">
                        <?php $counter = 0; ?>
                        <?php foreach($maisvendidos as $produto): 
                            if ($counter >= 22) break; ?>
                                <div class="card">
                                    <div class="fundo">
                                        <div class="imgprod"><img src="<?= $BASE_URL ?>imagens/produtos/<?= $produto->imagens[0] ?>" class="img-prod"></div>
                                        <div class="titu"><?= $produto->titulo?></div>
                                        <div class="vend"><?= $produto->produtos_comprados?> Vendidos</div>
                                        <div class="avaliacao"><img src="<?= $BASE_URL?>imagens/5stars.png"></div>
                                        <div class="preco"><div class="moeda">R$</div><div class="valor"><?= $produto->precoavista ?></div></div>
                                        <div class="prodbtn"><a href="<?= $BASE_URL?>visao.php?id=<?= $produto->id ?>" class="prod-btn">Pré-Visualizar</a></div>
                                    </div>
                                </div> 
                                <?php $counter++; ?>
                        <?php endforeach; ?>   
                    </div>
                </div>
                <div class="btnProd">
                    <div class="buttonsProd">
                        <input type="radio" name="r-btn1" id="r1-1" class="radios" checked>
                        <input type="radio" name="r-btn1" id="r1-2" class="radios">
                        <input type="radio" name="r-btn1" id="r1-3" class="radios">
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if(count($fonesproduto) != 0): ?>
            <div class="sliderProd" id="slider2">
                <div class="cat">Fones</div>
                <div class="slideProd"> 

                    <div class="cards" id="cards">
                        <?php $counter = 0; ?>
                        <?php foreach($fonesproduto as $produto): 
                            if ($counter >= 22) break; ?>
                                <div class="card">
                                    <div class="fundo">
                                        <div class="imgprod"><img src="<?= $BASE_URL ?>imagens/produtos/<?= $produto->imagens[0] ?>" class="img-prod"></div>
                                        <div class="titu"><?= $produto->titulo?></div>
                                        <div class="vend"><?= $produto->produtos_comprados?> Vendidos</div>
                                        <div class="avaliacao"><img src="<?= $BASE_URL?>imagens/5stars.png"></div>
                                        <div class="preco"><div class="moeda">R$</div><div class="valor"><?= $produto->precoavista ?></div></div>
                                        <div class="prodbtn"><a href="<?= $BASE_URL?>visao.php?id=<?= $produto->id ?>" class="prod-btn">Pré-Visualizar</a></div>
                                    </div>
                                </div> 
                                <?php $counter++; ?>
                        <?php endforeach; ?>   
                    </div>
                </div>
                <div class="btnProd">
                    <div class="buttonsProd">
                        <input type="radio" name="r-btn2" id="r2-1" class="radios" checked>
                        <input type="radio" name="r-btn2" id="r2-2" class="radios">
                        <input type="radio" name="r-btn2" id="r2-3" class="radios">
                    </div>
                </div>
            </div>
        <?php endif; ?>


        <?php if(count($celularesproduto) != 0): ?>
            <div class="sliderProd" id="slider3">
                <div class="cat">Celulares</div>
                <div class="slideProd"> 

                    <div class="cards" id="cards">
                        <?php $counter = 0; ?>
                        <?php foreach($celularesproduto as $produto): 
                            if ($counter >= 22) break; ?>
                                <div class="card">
                                    <div class="fundo">
                                        <div class="imgprod"><img src="<?= $BASE_URL ?>imagens/produtos/<?= $produto->imagens[0] ?>" class="img-prod"></div>
                                        <div class="titu"><?= $produto->titulo?></div>
                                        <div class="vend"><?= $produto->produtos_comprados?> Vendidos</div>
                                        <div class="avaliacao"><img src="<?= $BASE_URL?>imagens/5stars.png"></div>
                                        <div class="preco"><div class="moeda">R$</div><div class="valor"><?= $produto->precoavista ?></div></div>
                                        <div class="prodbtn"><a href="<?= $BASE_URL?>visao.php?id=<?= $produto->id ?>" class="prod-btn">Pré-Visualizar</a></div>
                                    </div>
                                </div> 
                                <?php $counter++; ?>
                        <?php endforeach; ?>   
                    </div>
                </div>
                <div class="btnProd">
                    <div class="buttonsProd">
                        <input type="radio" name="r-btn3" id="r3-1" class="radios" checked>
                        <input type="radio" name="r-btn3" id="r3-2" class="radios">
                        <input type="radio" name="r-btn3" id="r3-3" class="radios">
                    </div>
                </div>
            </div>
        <?php endif; ?>


        <?php if(count($capinhasproduto) != 0): ?>
            <div class="sliderProd" id="slider4">
                <div class="cat">Capinhas</div>
                <div class="slideProd"> 

                    <div class="cards" id="cards">
                        <?php $counter = 0; ?>
                        <?php foreach($capinhasproduto as $produto): 
                            if ($counter >= 22) break; ?>
                                <div class="card">
                                    <div class="fundo">
                                        <div class="imgprod"><img src="<?= $BASE_URL ?>imagens/produtos/<?= $produto->imagens[0] ?>" class="img-prod"></div>
                                        <div class="titu"><?= $produto->titulo?></div>
                                        <div class="vend"><?= $produto->produtos_comprados?> Vendidos</div>
                                        <div class="avaliacao"><img src="<?= $BASE_URL?>imagens/5stars.png"></div>
                                        <div class="preco"><div class="moeda">R$</div><div class="valor"><?= $produto->precoavista ?></div></div>
                                        <div class="prodbtn"><a href="<?= $BASE_URL?>visao.php?id=<?= $produto->id ?>" class="prod-btn">Pré-Visualizar</a></div>
                                    </div>
                                </div> 
                                <?php $counter++; ?>
                        <?php endforeach; ?>   
                    </div>
                </div>
                <div class="btnProd">
                    <div class="buttonsProd">
                        <input type="radio" name="r-btn4" id="r4-1" class="radios" checked>
                        <input type="radio" name="r-btn4" id="r4-2" class="radios">
                        <input type="radio" name="r-btn4" id="r4-3" class="radios">
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if(count($acessoriosproduto) != 0): ?>
            <div class="sliderProd" id="slider5">
                <div class="cat">Acessórios</div>
                <div class="slideProd"> 

                    <div class="cards" id="cards">
                        <?php $counter = 0; ?>
                        <?php foreach($acessoriosproduto as $produto): 
                            if ($counter >= 22) break; ?>
                                <div class="card">
                                    <div class="fundo">
                                        <div class="imgprod"><img src="<?= $BASE_URL ?>imagens/produtos/<?= $produto->imagens[0] ?>" class="img-prod"></div>
                                        <div class="titu"><?= $produto->titulo?></div>
                                        <div class="vend"><?= $produto->produtos_comprados?> Vendidos</div>
                                        <div class="avaliacao"><img src="<?= $BASE_URL?>imagens/5stars.png"></div>
                                        <div class="preco"><div class="moeda">R$</div><div class="valor"><?= $produto->precoavista ?></div></div>
                                        <div class="prodbtn"><a href="<?= $BASE_URL?>visao.php?id=<?= $produto->id ?>" class="prod-btn">Pré-Visualizar</a></div>
                                    </div>
                                </div> 
                                <?php $counter++; ?>
                        <?php endforeach; ?>   
                    </div>
                </div>
                <div class="btnProd">
                    <div class="buttonsProd">
                        <input type="radio" name="r-btn5" id="r5-1" class="radios" checked>
                        <input type="radio" name="r-btn5" id="r5-2" class="radios">
                        <input type="radio" name="r-btn5" id="r5-3" class="radios">
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if(count($tabletsproduto) != 0): ?>
            <div class="sliderProd" id="slider6">
                <div class="cat">Tablets</div>
                <div class="slideProd"> 

                    <div class="cards" id="cards">
                        <?php $counter = 0; ?>
                        <?php foreach($tabletsproduto as $produto): 
                            if ($counter >= 22) break; ?>
                                <div class="card">
                                    <div class="fundo">
                                        <div class="imgprod"><img src="<?= $BASE_URL ?>imagens/produtos/<?= $produto->imagens[0] ?>" class="img-prod"></div>
                                        <div class="titu"><?= $produto->titulo?></div>
                                        <div class="vend"><?= $produto->produtos_comprados?> Vendidos</div>
                                        <div class="avaliacao"><img src="<?= $BASE_URL?>imagens/5stars.png"></div>
                                        <div class="preco"><div class="moeda">R$</div><div class="valor"><?= $produto->precoavista ?></div></div>
                                        <div class="prodbtn"><a href="<?= $BASE_URL?>visao.php?id=<?= $produto->id ?>" class="prod-btn">Pré-Visualizar</a></div>
                                    </div>
                                </div> 
                                <?php $counter++; ?>
                        <?php endforeach; ?>   
                    </div>
                </div>
                <div class="btnProd">
                    <div class="buttonsProd">
                        <input type="radio" name="r-btn6" id="r6-1" class="radios" checked>
                        <input type="radio" name="r-btn6" id="r6-2" class="radios">
                        <input type="radio" name="r-btn6" id="r6-3" class="radios">
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if(count($carregadoresproduto) != 0): ?>
            <div class="sliderProd" id="slider7">
                <div class="cat">Carregadores</div>
                <div class="slideProd"> 

                    <div class="cards" id="cards">
                        <?php $counter = 0; ?>
                        <?php foreach($carregadoresproduto as $produto): 
                            if ($counter >= 22) break; ?>
                                <div class="card">
                                    <div class="fundo">
                                        <div class="imgprod"><img src="<?= $BASE_URL ?>imagens/produtos/<?= $produto->imagens[0] ?>" class="img-prod"></div>
                                        <div class="titu"><?= $produto->titulo?></div>
                                        <div class="vend"><?= $produto->produtos_comprados?> Vendidos</div>
                                        <div class="avaliacao"><img src="<?= $BASE_URL?>imagens/5stars.png"></div>
                                        <div class="preco"><div class="moeda">R$</div><div class="valor"><?= $produto->precoavista ?></div></div>
                                        <div class="prodbtn"><a href="<?= $BASE_URL?>visao.php?id=<?= $produto->id ?>" class="prod-btn">Pré-Visualizar</a></div>
                                    </div>
                                </div> 
                                <?php $counter++; ?>
                        <?php endforeach; ?>   
                    </div>
                </div>
                <div class="btnProd">
                    <div class="buttonsProd">
                        <input type="radio" name="r-btn7" id="r7-1" class="radios" checked>
                        <input type="radio" name="r-btn7" id="r7-2" class="radios">
                        <input type="radio" name="r-btn7" id="r7-3" class="radios">
                    </div>
                </div>
            </div>
        <?php endif; ?>



        
    </main>


    <?php
        include $BASE_PATH . 'src/View/footer.php';

    ?>
   