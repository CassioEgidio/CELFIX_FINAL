<?php    
    $pageTitle = "Meu pedido";
    $pageCSS = ["VisaoCompra.css"];
    $pageJS = [""];

    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');

    include_once($BASE_PATH . 'src/DAO/UserDAO.php');
    include_once($BASE_PATH . 'src/DAO/EnderecoDAO.php');
    include_once($BASE_PATH . 'config/db.php');

    $userDao = new UserDAO($conn, $BASE_URL);
    $EnderecoDao = new EnderecoDAO($conn, $BASE_URL);
    $userData = $userDao->verifyToken(true);
    

    include $BASE_PATH . 'src/View/header.php';

    include_once($BASE_PATH . 'src/Models/Produto.php');

    include_once($BASE_PATH . 'src/DAO/ProdutoDAO.php');
    include_once($BASE_PATH . 'src/DAO/PagamentoProdutoDAO.php');

    //processamento do protocolo
    $produtoDao = new ProdutoDAO($conn, $BASE_URL);
    $compraDao = new PagamentoProdutoDAO($conn, $BASE_URL);

    $COMPRA = $_POST['ID_COMPRA'];

    $compras = $compraDao->listarProtocolosporcliente($userData->id);
    $EnderecoData = $EnderecoDao->findByToken($userData->id);
?>
    <main>
        <?php foreach($compras as $compra): ?>
            <?php if ($compra->id_compra == $COMPRA): ?>
                <div class="back-main">
                    <div class="status estagio<?=$compra->Status?>">
                        <div class="line">  
                            <div class="separacao">
                                <img src="<?= $BASE_URL?>imagens/conveyor_belt.svg" alt="Separação">
                                <span>Em Separação</span>
                            </div>
                            <div class="logistica">
                                <img src="<?= $BASE_URL?>imagens/moving_ministry.svg" alt="Logistica">
                                <span>Centro de Logística</span>
                            </div>
                            <div class="rota">
                                <img src="<?= $BASE_URL?>imagens/local_shipping.svg" alt="Rota de entrega">
                                <span>Saiu para entrega</span>
                            </div>
                            <div class="entregue">
                                <img src="<?= $BASE_URL?>imagens/check_circle.svg" alt="Entregue">
                            </div>
                        </div>
                        <div class="entregado">
                            <img src="<?= $BASE_URL?>imagens/check_circle(Green).svg" alt="Entregue">
                            <span>Pedido Entregue!</span>
                        </div>
                        <div class="cancelado">
                            <img src="<?= $BASE_URL?>imagens/cancel.svg" alt="Cancelado">
                            <span>Pedido Cancelado!</span>
                        </div>
                    </div>
                    <div class="infos">
                        <div class="imgProd">
                            <img src="<?= $BASE_URL?>imagens/produtos/<?= $compra->imagens[0]?>" alt="Produto Imagem" style="width: auto; height: 100%;">
                        </div>
                        <div class="detalhes">
                            <span><span><?=$compra->qtde_pecas_compradas?>x</span> <?=$compra->titulo?></span>
                            <div class="detalhamentos">
                                <div class="left">
                                    <span style="color: #30107A; font-size: 20px;">Detalhes da Compra</span><br>
                                    &nbsp;&nbsp;&nbsp;<span style="color: #666666; font-size: 15px;">Feito - <?=$compra->data_compra?></span><br>
                                    &nbsp;&nbsp;&nbsp;<span style="color: #666666; font-size: 15px;">Pedido - <?=$compra->id_compra?></span><br><br>

                                    <span style="color: #30107A; font-size: 20px;">Informações de envio</span><br>
                                    &nbsp;&nbsp;&nbsp;<span style="color: #666666; font-size: 15px;">Entregue por - Celfix</span><br>
                                    &nbsp;&nbsp;&nbsp;<span style="color: #666666; font-size: 15px;">Tipo - Padrão</span><br>
                                    &nbsp;&nbsp;&nbsp;<span style="color: #666666; font-size: 15px;">Código de Rastreio - Entregue pela Celfix</span>
                                </div>
                                <div class="right">
                                    <?php foreach($EnderecoData as $endereco): ?>
                                        <?php if($endereco->ID_Endereco == $compra->id_endereco): ?>
                                            <span style="color: #30107A; font-size: 20px;">Destinatário</span><br>
                                            &nbsp;&nbsp;&nbsp;<span style="color: #666666; font-size: 15px;"><?=$compra->name?></span><br>
                                            &nbsp;&nbsp;&nbsp;<span style="color: #666666; font-size: 15px;"><?=$endereco->cidade?>, <?=$endereco->estado?></span><br>
                                            &nbsp;&nbsp;&nbsp;<span style="color: #666666; font-size: 15px;"><?=$endereco->rua?>, <?=$endereco->numero?></span><br>
                                            &nbsp;&nbsp;&nbsp;<span style="color: #666666; font-size: 15px;">CEP - <?=$endereco->CEP?></span><br>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                    <span style="color: #30107A; font-size: 20px;">Pagamento</span><br>
                                    &nbsp;&nbsp;&nbsp;<span style="color: #666666; font-size: 15px;">Metódo - <?=$compra->tipo_pagamento?></span><br>
                                    <?php
                                        if($compra->tipo_pagamento == "Cartão de crédito") {
                                    ?>
                                            &nbsp;&nbsp;&nbsp;<span style="color: #666666; font-size: 15px;">Parcelas - <?=$compra->n_parcelas?>x de R$ <?=sprintf('%.2f', ($compra->preco_total/$compra->n_parcelas))?></span><br>
                                    <?php
                                        }
                                    ?>
                                    &nbsp;&nbsp;&nbsp;<span style="color: #666666; font-size: 15px;">Valor do Produto - R$<?=$compra->precoavista?></span><br>
                                    &nbsp;&nbsp;&nbsp;<span style="color: #666666; font-size: 15px;">Frete - 
                                        <?php
                                            if($compra->frete == 0) {
                                                echo "R$ " . sprintf('%.2f', 25.90);
                                            } else {
                                                echo "Grátis";
                                            }
                                        ?></span><br>
                                    &nbsp;&nbsp;&nbsp;<span style="color: #000000; font-size: 15px;">Valor Pago - R$<?=$compra->preco_total?></span>
                                </div>
                            </div>
                        </div>
                        <?php
                            if($compra->Status != 4 && $compra->Status != 5) {
                                ?>
                                    <div class="divisoria"></div>
                                    <div class="estado">
                                        <center>
                                            <span style="font-size: 28px;">Data de entrega</span><br>
                                            <p style="color: #30107A; font-size: 20px;">
                                                <?php
                                                    echo $compra->data_entrega;
                                                ?>
                                            </p>

                                            <br><br>

                                            <span style="font-size: 28px;">Estado</span><br>
                                            <span style="color: #30107A; font-size: 20px;">
                                                <?php
                                                    switch($compra->Status) {
                                                        case 1:
                                                            ?>Em separação<?php 
                                                        break;
                                                        case 2:
                                                            ?>Centro de Logística<?php 
                                                        break;
                                                        case 3:
                                                            ?>Saiu para entrega<?php 
                                                        break;
                                                    }
                                                ?>
                                            </span><br>
                                            <p style="color: #666666; font-size: 15px;">
                                            <?php
                                                    switch($compra->Status) {
                                                        case 1:
                                                            ?>Sua compra já foi contabilizada e está<br>no processo de separação e em breve<br>ira ao nosso centro de logística.<?php 
                                                        break;
                                                        case 2:
                                                            ?>Sua compra está em nosso centro de<br>logística e está sendo preparada para<br>envio. Em breve, estará a caminho da<br>sua casa!<?php 
                                                        break;
                                                        case 3:
                                                            ?>Sua compra já está a caminho!<br>O pedido saiu do centro de logística e<br>está em rota de entrega para o<br>endereço fornecido.<?php 
                                                        break;
                                                    }
                                                ?>
                                            </p>
                                        </center>
                                    </div>
                                <?php
                            }
                        ?>
                    </div>
                    <?php if ($compra->Status == 1): ?>
                        <div class="cancelar">
                            <form action="<?= $BASE_URL ?>../src/Controller/pagamentoProcess.php" method="post">
                                <input type="hidden" name="type" value="Cancelar">
                                <input type="hidden" name="idCompra" value="<?=$compra->id_compra?>">
                                <input type="submit" value="Cancelar">
                            </form>
                        </div>
                    <?php endif; ?>

                    <?php if ($compra->Status == 3): ?>
                        <div class="confirmar">
                            <form action="<?= $BASE_URL ?>../src/Controller/pagamentoProcess.php" method="post">
                                <input type="hidden" name="type" value="Confirmar">
                                <input type="hidden" name="idCompra" value="<?=$compra->id_compra?>">
                                <input type="submit" value="Confirmar entrega">
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </main>

    <?php
        include '../src/View/footer.php';
    ?>