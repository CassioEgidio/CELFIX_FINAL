<?php
    $pageTitle = "Meus pedidos geral";
    $pageCSS = ["meuspedidos.css"];
    $pageJS = ["meuspedidos.js"];

    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');

    include_once($BASE_PATH . 'src/DAO/UserDAO.php');
    include_once($BASE_PATH . 'config/db.php');

    $userDao = new UserDAO($conn, $BASE_URL);
    $userData = $userDao->verifyFuncionario(true);

    include $BASE_PATH . 'src/View/header.php';

    include_once($BASE_PATH . 'src/Models/Produto.php');

    include_once($BASE_PATH . 'src/DAO/ProdutoDAO.php');
    include_once($BASE_PATH . 'src/DAO/PagamentoProdutoDAO.php');

    //processamento do protocolo
    $produtoDao = new ProdutoDAO($conn, $BASE_URL);
    $compraDao = new PagamentoProdutoDAO($conn, $BASE_URL);

    $compras = $compraDao->listarProtocolosporaadm($userData->id);

    //print_r($compras);exit();

?>


<main>

    <div class="conteiner">

        <div class="ContTitu">
            <p class="titu">Pedidos dos clientes</p>
            <div class="search-bar">
                <form method="GET" action="">
                    <input type="text" name="query" placeholder="Pesquisar ..." class="search-input" value="">
                    <button type="submit" class="search-button">Novo</button>
                </form>
            </div>

            <div class="cont">


            <?php if($compras): ?>
                <?php foreach($compras as $compra):  ?>

                <div class="proto1">
                    <div class="par1">
                        <!--conteudo do card-->
                        <p class="num">
                            <span class="left-text">Data da compra: <?= $compra->data_compra?>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ID cliente: <?= $compra->usuario_id?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nome cliente: <?= $compra->usuario_nome?></span>
                            <span class="right-text">Número:#<?= $compra->id_compra?></span>
                        </p>

                        <hr>
                        <div class="diviso">
                            <img class="im" src="<?= $BASE_URL?>imagens/produtos/<?= $compra->imagens[0]?>">
                            <span class="left-text2">
                                <h2><?=$compra->titulo ?></h2>
                                <p>Frete: <?=$compra->frete ?></p>
                                <p>Data de entrega: <?=$compra->data_entrega ?></p>
                                <p>Valor total: <?=$compra->preco_total ?></p>
                            </span>
                            <span class="right-text2"> <button class="butver">Ver pedido</button> </span>
                        </div>
                    </div>
                </div>

                <?php endforeach; ?>   

                <?php else: ?>

                    <p>você ainda não fez compras.</p>

                <?php endif; ?>

                <div class="bar"></div>
            </div>
        </div>
    </div>
    </div>
</main>

</body>

</html>