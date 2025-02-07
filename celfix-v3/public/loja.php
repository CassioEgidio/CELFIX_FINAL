<?php
    $pageTitle = "Celfix";
    $pageCSS = ["loja5.css"];
    $pageJS = ["loja111.js"];

    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
    include $BASE_PATH . 'src/View/header.php';

    include_once($BASE_PATH . 'src/Models/Produto.php');
    include_once($BASE_PATH . 'src/DAO/ProdutoDAO.php');

    //processamento produto

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        // Reseta a categoria para "Todos" ao entrar na página
        $_SESSION['categoria_selecionada'] = 'Todos';
    }

    $produtoDao = new ProdutoDAO($conn, $BASE_URL);

    $categoriapexibir = $produtoDao->findAll();
   
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $type = filter_input(INPUT_POST, "type");
    
        if ($type === "categoria") {
            $categoria = filter_input(INPUT_POST, "catego");
            $_SESSION['categoria_selecionada'] = $categoria;
    
            if ($categoria === "Todos") {
                $categoriapexibir = $produtoDao->findAll();
            } else {
                $categoriapexibir = $produtoDao->getProdutoByCategory($categoria);
            }
        }
    }
    
    $categoriaSelecionada = $_SESSION['categoria_selecionada'] ?? 'Todos';

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

        <div class="sliderProd" id="slider1">
            <div class="filtro">
                <div class="filterBtn">
                    <img src="<?= $BASE_URL?>imagens/filtro.svg" alt="filtro" onclick="caseAbrir()">
                </div>
                <div class="case ">
                    <form action="" method="POST">
                        <input type="hidden" name="type" value="categoria">
                        <input type="hidden" name="catego" value="Todos">
                        <input type="submit" value="Todos" 
                            style="<?= $categoriaSelecionada === 'Todos' ? 'font-size: 20px; font-weight: bold; opacity: 1;' : '' ?>">
                    </form>
                    <form action="" method="POST">
                        <input type="hidden" name="type" value="categoria">
                        <input type="hidden" name="catego" value="produtos mais vendidos">
                        <input type="submit" value="produtos mais vendidos" 
                            style="<?= $categoriaSelecionada === 'produtos mais vendidos' ? 'font-size: 20px; font-weight: bold; opacity: 1;' : '' ?>">
                    </form>
                    <form action="" method="POST">
                        <input type="hidden" name="type" value="categoria">
                        <input type="hidden" name="catego" value="Celulares">
                        <input type="submit" value="Celulares" 
                            style="<?= $categoriaSelecionada === 'Celulares' ? 'font-size: 20px; font-weight: bold; opacity: 1;' : '' ?>">
                    </form>

                    <form action="" method="POST">
                        <input type="hidden" name="type" value="categoria">
                        <input type="hidden" name="catego" value="Tablets">
                        <input type="submit" value="Tablets" 
                            style="<?= $categoriaSelecionada === 'Tablets' ? 'font-size: 20px; font-weight: bold; opacity: 1;' : '' ?>">
                    </form>

                    <form action="" method="POST">
                        <input type="hidden" name="type" value="categoria">
                        <input type="hidden" name="catego" value="Fones">
                        <input type="submit" value="Fones" 
                            style="<?= $categoriaSelecionada === 'Fones' ? 'font-size: 20px; font-weight: bold; opacity: 1;' : '' ?>">
                    </form>

                    <form action="" method="POST">
                        <input type="hidden" name="type" value="categoria">
                        <input type="hidden" name="catego" value="Capinhas">
                        <input type="submit" value="Capinhas" 
                            style="<?= $categoriaSelecionada === 'Capinhas' ? 'font-size: 20px; font-weight: bold; opacity: 1;' : '' ?>">
                    </form>
                    <form action="" method="POST">
                        <input type="hidden" name="type" value="categoria">
                        <input type="hidden" name="catego" value="acessórios">
                        <input type="submit" value="acessórios" 
                            style="<?= $categoriaSelecionada === 'acessórios' ? 'font-size: 20px; font-weight: bold; opacity: 1;' : '' ?>">
                    </form>
                    <form action="" method="POST">
                        <input type="hidden" name="type" value="categoria">
                        <input type="hidden" name="catego" value="carregadores">
                        <input type="submit" value="carregadores" 
                            style="<?= $categoriaSelecionada === 'carregadores' ? 'font-size: 20px; font-weight: bold; opacity: 1;' : '' ?>">
                    </form>
                    <form action="" method="POST">
                        <input type="hidden" name="type" value="categoria">
                        <input type="hidden" name="catego" value="adaptadores">
                        <input type="submit" value="adaptadores" 
                            style="<?= $categoriaSelecionada === 'adaptadores' ? 'font-size: 20px; font-weight: bold; opacity: 1;' : '' ?>">
                    </form>
                    <form action="" method="POST">
                        <input type="hidden" name="type" value="categoria">
                        <input type="hidden" name="catego" value="acessórios de jogos">
                        <input type="submit" value="acessórios de jogos" 
                            style="<?= $categoriaSelecionada === 'acessórios de jogos' ? 'font-size: 20px; font-weight: bold; opacity: 1;' : '' ?>">
                    </form>
                    <form action="" method="POST">
                        <input type="hidden" name="type" value="categoria">
                        <input type="hidden" name="catego" value="microfones">
                        <input type="submit" value="microfones" 
                            style="<?= $categoriaSelecionada === 'microfones' ? 'font-size: 20px; font-weight: bold; opacity: 1;' : '' ?>">
                    </form>
                    
                </div>
            </div>

            <div class="slideProd">      

                <div class="cards" id="cards">
                    <?php foreach($categoriapexibir as $produto): ?>
                        <div class="card">
                            <div class="fundo">
                                <div class="imgprod"><img src="<?= $BASE_URL ?>imagens/produtos/<?= $produto->imagens[0] ?>" class="img-prod"></div>
                                <div class="titu"><?= $produto->titulo?></div>
                                <div class="vend"><?= $produto->produtos_comprados?> Vendidos</div>
                                <div class="avaliacao"><img src="<?= $BASE_URL ?>imagens/5stars.png"></div>
                                <div class="preco"><div class="moeda">R$</div><div class="valor"><?= $produto->precoavista ?></div></div>
                                <div class="prodbtn"><a href="<?= $BASE_URL?>visao.php?id=<?= $produto->id ?>" class="prod-btn">Pré-Visualizar</a></div>
                            </div>
                        </div>
                    <?php endforeach; ?>   
                    
                </div>
            </div>
        </div>

    </main>


   


    
    <?php
        include $BASE_PATH . 'src/View/footer.php';

    ?>
   