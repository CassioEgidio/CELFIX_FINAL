<?php
    $pageTitle = "Meus pedidos";
    $pageCSS = ["meuspedidos.css"];
    $pageJS = ["meuspedidos.js"];

    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');

    include_once($BASE_PATH . 'src/DAO/UserDAO.php');
    include_once($BASE_PATH . 'config/db.php');

    $userDao = new UserDAO($conn, $BASE_URL);
    $userData = $userDao->verifyToken(true);

    include $BASE_PATH . 'src/View/header.php';

    include_once($BASE_PATH . 'src/Models/Produto.php');

    include_once($BASE_PATH . 'src/DAO/ProdutoDAO.php');
    include_once($BASE_PATH . 'src/DAO/PagamentoProdutoDAO.php');

    //processamento do protocolo
    $produtoDao = new ProdutoDAO($conn, $BASE_URL);
    $compraDao = new PagamentoProdutoDAO($conn, $BASE_URL);

    $compras = $compraDao->listarProtocolosporcliente($userData->id);

    //print_r($compras);exit();

?>


<main>

    <div class="conteiner">

        <div class="ContTitu">
            <p class="titu">Meus pedidos</p>


            <div class="cont">

            <?php if($compras): ?>
                <?php foreach($compras as $compra):  ?>

                    <form action="<?= $BASE_URL ?>VisaoCompra.php" method="post">
                        <input type="hidden" name="ID_COMPRA" value="<?= $compra->id_compra?>">

                        <div class="proto1">
                            <div class="par1">
                                <!--conteudo do card-->
                                <p class="num">
                                    <span class="left-text">Data da compra: <?= $compra->data_compra?></span>
                                    <span class="right-text">Número:#<?= $compra->id_compra?></span>
                                </p>

                                <hr>
                                <div class="diviso">
                                    <img class="im" src="<?= $BASE_URL?>imagens/produtos/<?= $compra->imagens[0]?>">
                                    <span class="left-text2">
                                        <h2><?=$compra->titulo ?></h2>
                                        <p>Frete - <?php
                                            if($compra->frete == 0) {
                                                echo "R$ " . sprintf('%.2f', 25.90);
                                            } else {
                                                echo "Grátis";
                                            }
                                        ?></p>
                                        <p>Data de entrega: <?=$compra->data_entrega ?></p>
                                        <p>Valor total: <?=$compra->preco_total ?></p>
                                    </span>
                                    <span class="right-text2"> <input type="submit" class="butver" value="Ver pedido"> </span>
                                </div>
                            </div>
                        </div>
                    </form>

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