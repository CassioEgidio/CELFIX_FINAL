<?php
    $pageTitle = "Pagamento";
    $pageCSS = ["pagamento.css"];
    $pageJS = ["pagamento11.js"];

    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');

    include_once($BASE_PATH . 'src/Models/PagamentoProduto.php');
    include_once($BASE_PATH . 'src/DAO/UserDAO.php');
    include_once($BASE_PATH . 'src/DAO/EnderecoDAO.php');
    include_once($BASE_PATH . 'config/db.php');

    $pagamentoProduto = new PagamentoProduto();
    $userDao = new UserDAO($conn, $BASE_URL);
    $EnderecoDao = new EnderecoDAO($conn, $BASE_URL);
    $userData = $userDao->verifyToken(true);
    $EnderecoData = $EnderecoDao->findByToken($userData->id);

    include $BASE_PATH . 'src/View/header.php';

    include_once($BASE_PATH . 'src/Models/Produto.php');
    include_once($BASE_PATH . 'src/DAO/ProdutoDAO.php');

    //processamento produto
    $produtoDao = new ProdutoDAO($conn, $BASE_URL);

    $ID_Produto = filter_input(INPUT_GET, "Product");

    $produto;

    if(empty($ID_Produto)) {
        $message->setMessage("O produto não foi encontrado.", "error", "index.php");
        exit();
    }
    else {
        $produto = $produtoDao->findById($ID_Produto);

        if(!$produto) {
            $message->setMessage("O produto não foi encontrado.", "error", "index.php");
            exit();
        }
    }

    $ID_Endereco = $EnderecoData["0"]->ID_Endereco;

    $Pagamento = $_SESSION['Pagamento'];
    $Preco = $produto->precoavista;
    $Quantidade = 1;

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $ID_Endereco = filter_input(INPUT_POST, "ID_Endereco");
    }
?>
    <main>
        <div class="container">
            <div class="enderecos EnderecoTela" id="EnderecoTela">
                <input type="button" value="Voltar" onclick="abrir('EnderecoTela', 'EnderecoTela')">
                <?php
                    foreach($EnderecoData as $Endereco) { 
                        ?>
                        <div class="enderecoCase">
                            <div class="informacoes">
                                <span style="color: #30107A; font-size: 18px; font-weight: bold;"><?=$Endereco->Descricao?></span>
                                <span style="color: #666666; font-size: 15px;">&nbsp;&nbsp;&nbsp;<?=$Endereco->bairro?></span>
                                <span style="color: #666666; font-size: 15px;">&nbsp;&nbsp;&nbsp;<?=$Endereco->rua?> | <?=$Endereco->numero?></span>
                                <span style="color: #666666; font-size: 15px;">&nbsp;&nbsp;&nbsp;<?=$Endereco->cidade?>, <?=$Endereco->estado?></span>
                                <span style="color: #666666; font-size: 15px;">&nbsp;&nbsp;&nbsp;<?=$Endereco->CEP?></span>
                            </div>
                            <div class="Operacoes">
                                <form method="post">
                                    <input type="hidden" name="ID_Endereco" value="<?=$Endereco->ID_Endereco?>">
                                    <input type="submit" value="Selecionar">
                                </form>
                            </div>
                        </div>
                    <?php }
                ?>
            </div>
            <div class="metodos MetodosTela" id="MetodosTela">
                <input type="button" value="Voltar" onclick="abrir('MetodosTela', 'MetodosTela')">
                <div class="MetodoCase">
                    <div class="infos">
                        <span style="color: #000000; font-size: 30px; margin-left: 20px; font-weight: bold;"><img src="<?= $BASE_URL?>imagens/credit_card.svg" alt="Cartão" style="width: 100px; height: 100px;">&nbsp;&nbsp;Cartão de crédito</span>
                    </div>
                    <div class="Ope">
                        <form method="post">
                            <input type="hidden" name="Pagamento" value="1">
                            <input type="button" value="Selecionar" onclick="Pagamento1()">
                        </form>
                    </div>
                </div>
                <div class="MetodoCase">
                    <div class="infos">
                        <span style="color: #000000; font-size: 30px; margin-left: 20px; font-weight: bold;"><img src="<?= $BASE_URL?>imagens/pix.svg" alt="Cartão" style="width: 100px; height: 100px;">&nbsp;&nbsp;Pix</span>
                    </div>
                    <div class="Ope">
                        <form method="post">
                            <input type="hidden" name="Pagamento" value="2">
                            <input type="button" value="Selecionar" onclick="Pagamento2()">
                        </form>
                    </div>
                </div>
                <div class="MetodoCase">
                    <div class="infos">
                        <span style="color: #000000; font-size: 30px; margin-left: 20px; font-weight: bold;"><img src="<?= $BASE_URL?>imagens/request_quote.svg" alt="Cartão" style="width: 100px; height: 100px;">&nbsp;&nbsp;Boleto Bancário</span>
                    </div>
                    <div class="Ope">
                        <form method="post">
                            <input type="hidden" name="Pagamento" value="3">
                            <input type="button" value="Selecionar" onclick="Pagamento3()">
                        </form>
                    </div>
                </div>
                <div class="MetodoCase">
                    <div class="infos">
                        <span style="color: #000000; font-size: 30px; margin-left: 20px; font-weight: bold;"><img src="<?= $BASE_URL?>imagens/CelfixPay.svg" alt="Cartão" style="width: 300px; height: 100px;"></span>
                    </div>
                    <div class="Ope">
                        <form method="post">
                            <input type="hidden" name="Pagamento" value="4">
                            <input type="button" value="Selecionar" onclick="Pagamento4()">
                        </form>
                    </div>
                </div>
            </div>
            <div class="left">
                <div class="endereco">
                    <div class="infos">
                        <?php
                            foreach($EnderecoData as $Endereco) { 
                                if($Endereco->ID_Endereco == $ID_Endereco) {?>
                                    <span style="color: #000000; font-size: 25px; font-weight: bold;">Endereço para Envio</span><br>
                                    &nbsp;&nbsp;&nbsp;<span style="color: #000000; font-size: 20px; font-weight: bold;">• </span><span style="color: #30107A; font-size: 20px; font-weight: bold;"><?=$userData->name?></span><span style="color: #000000; font-size: 20px;"> | <?=$userData->telefone?></span><br>
                                    &nbsp;&nbsp;&nbsp;<span style="color: #000000; font-size: 20px; font-weight: bold;">• </span><span style="color: #000000; font-size: 20px;"><?=$Endereco->rua?> <?=$Endereco->numero?>, <?=$Endereco->cidade?> <?=$Endereco->estado?> | </span><span style="color: #30107A; font-size: 20px; font-weight: bold;"><?=$Endereco->Descricao?></span>
                            <?php }
                            }
                        ?>
                    </div>

                    <div class="btnEndereco"><input type="button" value="Trocar" onclick="abrir('EnderecoTela', 'EnderecoTela')"></div>
                </div>
                <div class="metodo">
                    <div class="infos">
                        <span style="color: #000000; font-size: 25px; font-weight: bold;">Metodos de pagamento</span><br>
                        <div class="info2">
                            <span style="color: #000000; font-size: 20px; margin-left: 20px;" id="SpanMetodo"></span>&nbsp;&nbsp;
                            <select id="categoria" name="categoria" onchange="nParcelas()">
                                <?php
                                    for($i = 2; $i <= $produto->nparcelas; $i++) {
                                ?>
                                        <option value="<?=$i?>">x<?=$i?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="btnMetodo"><input type="button" value="Trocar" onclick="abrir('MetodosTela', 'MetodosTela')"></div>
                </div>
                <div class="produto">
                    <div class="prod">
                        <div class="esquerda">
                            <div class="imagem">
                                <img src="<?= $BASE_URL ?>imagens/produtos/<?= $produto->imagens[0]?>" alt="Produto Imagem" style="width: auto; height: 100%;">
                            </div>

                            <div class="infos">
                                <span style="color: #000000; font-size: 25px; font-weight: bold;"><?=$produto->titulo?></span><br>
                                &nbsp;&nbsp;&nbsp;<span style="color: #000000; font-size: 20px; font-weight: bold;">• </span><span style="color: #000000; font-size: 20px;" id="precoProd">R$ <?=$Preco?></span><br>
                                &nbsp;&nbsp;&nbsp;<span style="color: #000000; font-size: 20px; font-weight: bold;">• </span><span style="color: #000000; font-size: 20px;">Frete - </span><span style="color: #30107A; font-size: 20px; font-weight: bold;">
                                    <?php
                                        if($produto->frete == false) {
                                            echo "R$ 25,90";
                                        } else {
                                            echo "Grátis";
                                        }
                                    ?>
                                </span><br><br>
                                <span style="color: #8E918F; font-size: 16px;">Estimativa de entrega <?=$pagamentoProduto->getFutureDate()?></span><br>
                            </div>
                        </div>
                        
                        <div class="adicionar">
                            <input type="button" value="-" onclick="addProd('-')">
                            <span style="color: #000000; font-size: 25px; font-weight: bold;" id="Quant"><?=$Quantidade?></span>
                            <input type="button" value="+" onclick="addProd('+')">
                        </div>
                    </div>
                </div>
            </div>
            <div class="right">
                <div class="resumo">
                    <span style="color: #30107A; font-size: 30px; font-weight: bold;">Resumo</span>
                    <div class="grade">
                        <div class="esq">
                            <span style="color: #000000; font-size: 25px; font-weight: bold;">&nbsp;&nbsp;&nbsp;Subtotal</span>
                            
                            <span style="color: #000000; font-size: 25px; font-weight: bold;">&nbsp;&nbsp;&nbsp;Frete</span>
                        </div>
                        <div class="dir">
                            <span style="color: #8E918F; font-size: 20px;" id="PrecoResumo">R$ <?=$Preco?></span>
                            <span style="color: #8E918F; font-size: 20px;">
                                <?php
                                    if($produto->frete == false) {
                                        echo "R$ 25,90";
                                    } else {
                                        echo "R$ 0,00 (Grátis)";
                                    }
                                ?>
                            </span>
                        </div>
                    </div>
                    
                    

                    <div class="buttonPagar">
                        <div class="Total">
                            <span style="color: #30107A; font-size: 30px; font-weight: bold;">Total <br> <span style="color: #000000; font-size: 20px; display: none;" id="ParcelaRes">&nbsp;&nbsp;&nbsp;Parcelas</span></span>
                            <div>
                                <span style="color: #000000; font-size: 25px; font-weight: bold;" id="Total">
                                    <?php
                                        if($produto->frete == false) {
                                            $Frete = 25.90;
                                        } else {
                                            $Frete = 0.00;
                                        }

                                        echo "R$ " . sprintf('%.2f', ($Preco + $Frete));
                                    ?>
                                </span><span style="color: #8E918F; font-size: 20px; display: none;" id="ParcelaResumo"></span>
                            </div>
                            
                        </div>

                        <form action="<?= $BASE_URL?>../src/Controller/pagamentoProcess.php" method="post">
                            <input type="hidden" name="type" value="pagamentoproduto">

                            <input type="hidden" name="dataField1" id="preco" value="<?=$Preco?>">
                            <input type="hidden" name="dataField2" id="Itens" value="1">
                            <input type="hidden" name="dataField3" id="Paga" value="<?=$Pagamento?>">
                            <input type="hidden" name="dataField4" id="ProdID" value="<?=$produto->id?>">
                            <input type="hidden" name="dataField5" id="EndeID" value="<?=$ID_Endereco?>">
                            <input type="hidden" name="dataField6" id="Parcelas" value="null">

                            <input type="submit" value="Pagar Agora" class="Pagar">
                        </form>
                    </div>
                    
                </div>
                <div class="certificado">
                    <img src="<?= $BASE_URL?>imagens/Verificado.svg" alt="Verificado">
                    <span style="color: #000000; font-size: 25px;">Compra e entrega feita por <span style="color: #30107A; font-size: 30px; font-weight: bold;">CELFIX</span></span>
                </div>
            </div>
        </div>
    </main>

    <script>
        function addProd(operacao) {
            var quantidade = document.getElementById('Quant').textContent;
            quantidade = parseInt(quantidade, 10);

            if (operacao === '+'  && quantidade < 10) {
                // Incrementa a quantidade
                document.getElementById('Quant').innerHTML = (quantidade + 1);
                document.getElementById('Itens').value = (quantidade + 1);
            } else if (operacao === '-' && quantidade > 1) {
                // Decrementa a quantidade apenas se maior que 1
                document.getElementById('Quant').innerHTML = (quantidade - 1);
                document.getElementById('Itens').value = (quantidade - 1);
            }

            var metodo = document.getElementById('Paga').value;

            if(metodo == "Cartão de crédito") {
                document.getElementById('preco').value = ((<?= $produto->precoparcelado ?>*parseInt(document.getElementById('Quant').textContent, 10))+<?=$Frete?>).toFixed(2);
                document.getElementById('Total').innerHTML = "R$ "+((<?= $produto->precoparcelado ?>*parseInt(document.getElementById('Quant').textContent, 10))+<?=$Frete?>).toFixed(2);
                document.getElementById('PrecoResumo').innerHTML = "R$ "+(<?= $produto->precoparcelado ?>*parseInt(document.getElementById('Quant').textContent, 10)).toFixed(2);

                var parcelas = document.getElementById('categoria').value;
                document.getElementById('ParcelaResumo').innerHTML = parcelas+"x de R$ "+(((<?= $produto->precoparcelado ?>*parseInt(document.getElementById('Quant').textContent, 10))+<?=$Frete?>)/parcelas).toFixed(2);
            } else {
                document.getElementById('preco').value = ((<?= $Preco ?>*parseInt(document.getElementById('Quant').textContent, 10))+<?=$Frete?>).toFixed(2);
                document.getElementById('Total').innerHTML = "R$ "+((<?= $Preco ?>*parseInt(document.getElementById('Quant').textContent, 10))+<?=$Frete?>).toFixed(2);
                document.getElementById('PrecoResumo').innerHTML = "R$ "+(<?= $Preco ?>*parseInt(document.getElementById('Quant').textContent, 10)).toFixed(2);
            }
        }

        function nParcelas() {
            document.getElementById('Parcelas').value = document.getElementById('categoria').value;

            var parcelas = document.getElementById('categoria').value;

            document.getElementById('ParcelaResumo').innerHTML = parcelas+"x de R$ "+(((<?= $produto->precoparcelado ?>*parseInt(document.getElementById('Quant').textContent, 10))+<?=$Frete?>)/parcelas).toFixed(2);
        }

        function abrir(Tela, Desaparecer) {
            var u = document.getElementById(Tela);
            u.classList.toggle(Desaparecer);
        }

        function Pagamento1() {
            <?php
                $_SESSION['Pagamento'] = "Cartão de crédito";
                $Pagamento = $_SESSION['Pagamento'];
                $Preco = $produto->precoparcelado;
                if($produto->frete == false) {
                    $Frete = 25.90;
                } else {
                    $Frete = 0.00;
                }
            ?>
            abrir('MetodosTela', 'MetodosTela');
            document.getElementById('SpanMetodo').innerHTML = "<img src='<?= $BASE_URL ?>imagens/credit_card.svg' alt='Cartão' style='width: 40px; height: 40px;'>&nbsp;&nbsp;<?= $Pagamento ?>";
            document.getElementById('categoria').style = 'display: block;';
            document.getElementById('precoProd').innerHTML = "R$ <?= $Preco ?>";
            document.getElementById('preco').value = ((<?= $Preco ?>*parseInt(document.getElementById('Quant').textContent, 10))+<?=$Frete?>).toFixed(2);
            document.getElementById('Paga').value = "<?=$Pagamento?>";
            document.getElementById('Parcelas').value = document.getElementById('categoria').value;

            var parcelas = document.getElementById('categoria').value;

            document.getElementById('ParcelaResumo').innerHTML = parcelas+"x de R$ "+(((<?= $Preco ?>*parseInt(document.getElementById('Quant').textContent, 10))+<?=$Frete?>)/parcelas).toFixed(2);
            
            document.getElementById('Total').innerHTML = "R$ "+((<?= $Preco ?>*parseInt(document.getElementById('Quant').textContent, 10))+<?=$Frete?>).toFixed(2);

            document.getElementById('PrecoResumo').innerHTML = "R$ "+(<?= $Preco ?>*parseInt(document.getElementById('Quant').textContent, 10)).toFixed(2);
            document.getElementById('ParcelaResumo').style = "color: #8E918F; font-size: 20px; display: block;";
            document.getElementById('ParcelaRes').style = "color: #000000; font-size: 20px; display: block;";
        }

        function Pagamento2() {
            <?php
                $_SESSION['Pagamento'] = "Pix";
                $Pagamento = $_SESSION['Pagamento'];
                $Preco = $produto->precoavista;
                if($produto->frete == false) {
                    $Frete = 25.90;
                } else {
                    $Frete = 0.00;
                }
            ?>
            abrir('MetodosTela', 'MetodosTela');
            document.getElementById('SpanMetodo').innerHTML = "<img src='<?= $BASE_URL ?>imagens/pix.svg' alt='Pix' style='width: 40px; height: 40px;'>&nbsp;&nbsp;<?= $Pagamento ?>";
            document.getElementById('categoria').style = 'display: none;';
            document.getElementById('precoProd').innerHTML = "R$ <?= $Preco ?>";
            document.getElementById('preco').value = ((<?= $Preco ?>*parseInt(document.getElementById('Quant').textContent, 10))+<?=$Frete?>).toFixed(2);
            document.getElementById('Paga').value = "<?=$Pagamento?>";

            document.getElementById('Total').innerHTML = "R$ "+((<?= $Preco ?>*parseInt(document.getElementById('Quant').textContent, 10))+<?=$Frete?>).toFixed(2);

            document.getElementById('PrecoResumo').innerHTML = "R$ "+(<?= $Preco ?>*parseInt(document.getElementById('Quant').textContent, 10)).toFixed(2);
            document.getElementById('ParcelaResumo').style = "color: #8E918F; font-size: 20px; display: none;";
            document.getElementById('ParcelaRes').style = "color: #000000; font-size: 20px; display: none;";
        }

        function Pagamento3() {
            <?php
                $_SESSION['Pagamento'] = "Boleto Bancário";
                $Pagamento = $_SESSION['Pagamento'];
                $Preco = $produto->precoavista;
                if($produto->frete == false) {
                    $Frete = 25.90;
                } else {
                    $Frete = 0.00;
                }
            ?>
            abrir('MetodosTela', 'MetodosTela');
            document.getElementById('SpanMetodo').innerHTML = "<img src='<?= $BASE_URL ?>imagens/request_quote.svg' alt='Boleto Bancário' style='width: 40px; height: 40px;'>&nbsp;&nbsp;<?= $Pagamento ?>";
            document.getElementById('categoria').style = 'display: none;';
            document.getElementById('precoProd').innerHTML = "R$ <?= $Preco ?>";
            document.getElementById('preco').value = ((<?= $Preco ?>*parseInt(document.getElementById('Quant').textContent, 10))+<?=$Frete?>).toFixed(2);
            document.getElementById('Paga').value = "<?=$Pagamento?>";

            document.getElementById('Total').innerHTML = "R$ "+((<?= $Preco ?>*parseInt(document.getElementById('Quant').textContent, 10))+<?=$Frete?>).toFixed(2);

            document.getElementById('PrecoResumo').innerHTML = "R$ "+(<?= $Preco ?>*parseInt(document.getElementById('Quant').textContent, 10)).toFixed(2);
            document.getElementById('ParcelaResumo').style = "color: #8E918F; font-size: 20px; display: none;";
            document.getElementById('ParcelaRes').style = "color: #000000; font-size: 20px; display: none;";
        }

        function Pagamento4() {
            <?php
                $_SESSION['Pagamento'] = "CelfixPay";
                $Pagamento = $_SESSION['Pagamento'];
                $Preco = $produto->precoavista;
                if($produto->frete == false) {
                    $Frete = 25.90;
                } else {
                    $Frete = 0.00;
                }
            ?>
            abrir('MetodosTela', 'MetodosTela');
            document.getElementById('SpanMetodo').innerHTML = "<img src='<?= $BASE_URL ?>imagens/CelfixPay.svg' alt='CelfixPay' style='width: 180px; height: 40px;'>&nbsp;&nbsp;";
            document.getElementById('categoria').style = 'display: none;';
            document.getElementById('precoProd').innerHTML = "R$ <?= $Preco ?>";
            document.getElementById('preco').value = ((<?= $Preco ?>*parseInt(document.getElementById('Quant').textContent, 10))+<?=$Frete?>).toFixed(2);
            document.getElementById('Paga').value = "<?=$Pagamento?>";

            document.getElementById('Total').innerHTML = "R$ "+((<?= $Preco ?>*parseInt(document.getElementById('Quant').textContent, 10))+<?=$Frete?>).toFixed(2);

            document.getElementById('PrecoResumo').innerHTML = "R$ "+(<?= $Preco ?>*parseInt(document.getElementById('Quant').textContent, 10)).toFixed(2);
            document.getElementById('ParcelaResumo').style = "color: #8E918F; font-size: 20px; display: none;";
            document.getElementById('ParcelaRes').style = "color: #000000; font-size: 20px; display: none;";
        }
        <?php
            $Quantidade = 1;
        ?>
        document.getElementById('SpanMetodo').innerHTML = "<img src='<?= $BASE_URL ?>imagens/CelfixPay.svg' alt='CelfixPay' style='width: 180px; height: 40px;'>&nbsp;&nbsp;";
    </script>
</body>
</html>