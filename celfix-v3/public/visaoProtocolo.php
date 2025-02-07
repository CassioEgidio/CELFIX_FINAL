<?php
    $pageTitle = "Celfix";
    $pageCSS = ["visaoProtocolo.css"];
    $pageJS = [""];

    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');

    include_once($BASE_PATH . 'config/db.php');
    include_once($BASE_PATH . 'src/DAO/UserDAO.php');
    include_once($BASE_PATH . 'src/DAO/ConsertoDAO.php');

    $userDao = new UserDAO($conn, $BASE_URL);
    $userData = $userDao->verifyToken(true);

    $consertoDao = new ConsertoDAO($conn, $BASE_URL);
    $consertoData = $consertoDao->protocoloByID(25);

    include $BASE_PATH . 'src/View/header.php';

    $Quantidade = 0;
?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>


    <div class="container">
        <div class="esquerda">
            <div class="status estagio<?=$consertoData[0]->status?>">
                <div class="centralizadora">
                    <div class="identificacao">
                        <div class="cima">
                            <span style="color: #000000; font-size: 30px; font-weight: bold;">Apresente esse codigo ao técnico de nossa filial</span><br><br>
                            <span style="color: #30107A; font-size: 35px; font-weight: bold;"><?=$consertoData[0]->id_Concerto?></span><br><br>
                            <span style="color: #8E918F; font-size: 15px;">Marcamos nossas filiais no mapa abaixo</span>
                        </div>
                        <div class="baixo">
                            <div id="map">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="line">
                    <div class="separacao">
                        <img src="<?= $BASE_URL?>imagens/manage_search.svg" alt="Analise">
                    </div>
                    <div class="logistica">
                        <img src="<?= $BASE_URL?>imagens/attach_money.svg" alt="Resumo">
                    </div>
                    <div class="rota">
                        <img src="<?= $BASE_URL?>imagens/build.svg" alt="Reparando">
                    </div>
                    <div class="entregue">
                        <img src="<?= $BASE_URL?>imagens/check_circle.svg" alt="Concluido">
                    </div>
                </div>

                <div class="TelaAnalise">
                    <p style="color: #30107A; font-size: 30px; font-weight: bold; border-bottom: 1px #000000 solid; width: 100%;">Em Análise</p><br>
                    <div class="infos">
                        <p>Gostaríamos de informar que recebemos o seu produto e, no momento, nossa equipe técnica está realizando uma análise detalhada do problema relatado. Assim que a avaliação for concluída, nossos funcionários relatório completo com as informações sobre o diagnóstico e as possíveis soluções.<br><span style="color: #30107A; font-size: 13px; font-weight: bold;">(Qualquer dúvida contate-nos via chat)</span></p>
                        <div style="width: 200px; height: 200px;">
                            <img src="<?= $BASE_URL?>imagens/procurar.gif" alt="Em Analise" style="width: auto; height: 100%;">
                        </div>
                    </div>
                </div>

                <div class="TelaResumo">
                    <div class="metodo">
                        <div class="infos">
                            <span style="color: #000000; font-size: 25px; font-weight: bold;">Metodos de pagamento</span><br>
                        </div>
                        <div class="info2">
                            <span style="color: #000000; font-size: 20px; margin-left: 20px;" id="SpanMetodo"></span>
                            <select id="categoria" name="categoria" onchange="nParcelas()">
                                <?php
                                    for($i = 2; $i <= 10; $i++) {
                                ?>
                                        <option value="<?=$i?>">x<?=$i?></option>
                                <?php
                                    }
                                ?>
                            </select>
                            <div class="btnMetodo"><input type="button" value="Trocar" onclick="abrir('MetodosTela', 'MetodosTela')"></div>
                        </div>
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

                    <div class="resumo">
                        <span style="color: #000000; font-size: 30px; font-weight: bold; margin-left: 15px;">Resumo</span>
                        <span style="color: #8E918F; font-size: 18px; margin-left: 35px;">Reposição de peças - R$ <?=$consertoData[0]->PrecoPeca?></span>
                        <span style="color: #8E918F; font-size: 18px; margin-left: 35px;">Mão de obra (20%) - R$ <?=(($consertoData[0]->PrecoPeca/100)*20)?></span><br>
                        <span style="color: #30107A; font-size: 25px; font-weight: bold; margin-left: 15px;">Total do reparo - R$ <?=(($consertoData[0]->PrecoPeca/100)*20)+$consertoData[0]->PrecoPeca?></span>
                        
                        <form action="" method="post">
                            <div class="garantia">
                                <label class="nota-fiscal-label">Garantia <span style="color: #8E918F; font-size: 12px; font-weight: 100;">(+ R$25,90)</span></label>
                                <div class="radio-group">
                                    <input type="radio" name="garantia" value="1" class="radio" id="garantia-sim" required> 
                                    <label class="item" for="garantia-sim">Sim</label>
                                    <div class="separator">|</div>
                                    <input type="radio" name="garantia" value="0" class="radio" id="garantia-nao" required>
                                    <label class="item" for="garantia-nao">Não</label>
                                </div>
                            </div>
                            
                            <div class="total">
                                <span style="color: #30107A; font-size: 35px; font-weight: bold; margin-left: 15px;">Total - R$ <?=(($consertoData[0]->PrecoPeca/100)*20)+$consertoData[0]->PrecoPeca?></span>

                                <input type="hidden" id="Parcelas" name="Parcelas" value="">
                                <input type="hidden" id="MetodoPagamento" name="MetodoPagamento" value="CelfixPay">
                                <input type="submit" value="Pagar Agora">
                            </div>
                        </form>

                    </div>
                </div>

                <div class="TelaReparo">
                    <p style="color: #30107A; font-size: 30px; font-weight: bold; border-bottom: 1px #000000 solid; width: 100%;">Em reparo</p><br>
                    <div class="infos">
                        <p>Confirmamos o recebimento do seu pagamento e informamos que, neste momento, nossa equipe está em processo de preparação e reparo do seu aparelho. Estamos comprometidos em garantir que o serviço seja realizado com o máximo de cuidado e dentro dos prazos previstos.<br><span style="color: #30107A; font-size: 13px; font-weight: bold;">(Qualquer dúvida contate-nos via chat)</span></p>
                        <div style="width: 200px; height: 200px;">
                            <img src="<?= $BASE_URL?>imagens/ferramentas-de-reparacao.gif" alt="Em Analise" style="width: auto; height: 100%;">
                        </div>
                    </div>
                </div>

                <div class="TelaConcluido">
                    <p style="color: #30107A; font-size: 30px; font-weight: bold; border-bottom: 1px #000000 solid; width: 100%;">Reparo Concluido</p><br>
                    
                    <div class="infos">
                        <p>Temos o prazer de informar que o reparo do seu aparelho foi concluído com sucesso. Para sua maior conveniência, oferecemos a opção de realizar a entrega diretamente na porta da sua casa, garantindo assim mais comodidade no recebimento do produto.<br><span style="color: #30107A; font-size: 13px; font-weight: bold;">(Qualquer dúvida contate-nos via chat)</span></p>

                        <div style="width: 150px; height: 150px;">
                            <img src="<?= $BASE_URL?>imagens/caminhao-de-entrega.gif" alt="Em Analise" style="width: auto; height: 100%;">
                        </div>
                    </div>

                    <form action="">
                        <div class="entrega">
                            <label class="nota-fiscal-label">Entrega <span style="color: #8E918F; font-size: 12px; font-weight: 100;">(grátis)</span></label>
                            <div class="radio-group">
                                <input type="radio" name="entrega" value="1" class="radio" id="entrega-sim" required>
                                <label class="item" for="entrega-sim">Sim</label>
                                <div class="separator">|</div>
                                <input type="radio" name="entrega" value="0" class="radio" id="entrega-nao" required>
                                <label class="item" for="entrega-nao">Não</label>
                            </div>
                        </div>

                        <input type="submit" value="Solicitar">
                    </form>
                        
                </div>

            </div>
        </div>
        <div class="direita">
            <div class="chatBox">
                <div class="mensagens">

                </div>
                <form action="" method="">
                    <input type="hidden" name="">
                    <input type="text" name="" id="" placeholder="Envie mensagens">
                    <input type="submit" value="">
                </form>
            </div>
        </div>
    </div>

    <script>
        var map = L.map('map').setView([-23.546235736986706, -46.50203815310063], 13);
        var layer = L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.{ext}', {
            minZoom: 10,
            maxZoom: 20,
            ext: 'png'
        });
        layer.addTo(map);

        var icon = L.icon({
            iconUrl: '<?= $BASE_URL ?>imagens/distance.svg', 

            iconSize:     [35, 40], // size of the icon
            iconAnchor:   [35, 40], // point of the icon which will correspond to marker's location
            popupAnchor:  [-18, -40] // point from which the popup should open relative to the iconAnchor
        });

        L.marker([-23.546235736986706, -46.50203815310063], {icon: icon}).addTo(map).bindPopup("<b>Unidade Vila Nhocuné</b><br>R. Padre Antônio de Andrade, 133 - Vila Nhocuné, São Paulo - SP, 03559-080");
        L.marker([-23.526311210493187, -46.46974633243943], {icon: icon}).addTo(map).bindPopup("<b>Unidade A.E Carvalho 1</b><br>R. Santos Dumont, 351 - Cidade Antônio Estêvão de Carvalho, São Paulo - SP, 08223-268");
        L.marker([-23.537265857420483, -46.46896180804703], {icon: icon}).addTo(map).bindPopup("<b>Unidade A.E Carvalho 2</b><br>Rua Surucuás, 268 - Cidade Antônio Estêvão de Carvalho, São Paulo - SP, 08220-000");
        L.marker([-23.504361678301763, -46.412721144409375], {icon: icon}).addTo(map).bindPopup("<b>Unidade Jardim dos Ipes</b><br>R. Erva Cigana, 23 - Jardim dos Ipes, São Paulo - SP, 08161-370");
        L.marker([-23.531910957331714, -46.46207175632541], {icon: icon}).addTo(map).bindPopup("<b>Unidade Jardim Itapemirim</b><br>R. Alexandre Dias, 277 - Jardim Itapemirim, São Paulo - SP, 08225-250");

        function abrir(Tela, Desaparecer) {
            var u = document.getElementById(Tela);
            u.classList.toggle(Desaparecer);
        }

        const garantiaItems = document.querySelectorAll('.garantia .item');

        garantiaItems.forEach(item => {
            item.addEventListener('click', () => {
                garantiaItems.forEach(i => i.classList.remove('active'));
                item.classList.add('active');
                document.getElementById(item.getAttribute('for')).checked = true;
                checkFormCompletion(); // Verifica se todos os campos estão preenchidos
            });
        });

        const entregaItems = document.querySelectorAll('.entrega .item');

        entregaItems.forEach(item => {
            item.addEventListener('click', () => {
                entregaItems.forEach(i => i.classList.remove('active'));
                item.classList.add('active');
                document.getElementById(item.getAttribute('for')).checked = true;
                checkFormCompletion(); // Verifica se todos os campos estão preenchidos
            });
        });

        function Pagamento1() {
            <?php
                $_SESSION['Pagamento'] = "Cartão de crédito";
                $Pagamento = $_SESSION['Pagamento'];
            ?>
            abrir('MetodosTela', 'MetodosTela');
            document.getElementById('SpanMetodo').innerHTML = "<img src='<?= $BASE_URL ?>imagens/credit_card.svg' alt='Cartão' style='width: 40px; height: 40px;'>&nbsp;&nbsp;<?= $Pagamento ?>";
            document.getElementById('categoria').style = 'display: block;';
            document.getElementById('Parcelas').value = document.getElementById('categoria').value
            document.getElementById('MetodoPagamento').value = '<?=$Pagamento?>';
        }

        function Pagamento2() {
            <?php
                $_SESSION['Pagamento'] = "Pix";
                $Pagamento = $_SESSION['Pagamento'];
            ?>
            abrir('MetodosTela', 'MetodosTela');
            document.getElementById('SpanMetodo').innerHTML = "<img src='<?= $BASE_URL ?>imagens/pix.svg' alt='Pix' style='width: 40px; height: 40px;'>&nbsp;&nbsp;<?= $Pagamento ?>";
            document.getElementById('categoria').style = 'display: none;';
            document.getElementById('Parcelas').value = 1;
            document.getElementById('MetodoPagamento').value = '<?=$Pagamento?>';
        }
        
        function Pagamento3() {
            <?php
                $_SESSION['Pagamento'] = "Boleto Bancário";
                $Pagamento = $_SESSION['Pagamento'];
            ?>
            abrir('MetodosTela', 'MetodosTela');
            document.getElementById('SpanMetodo').innerHTML = "<img src='<?= $BASE_URL ?>imagens/request_quote.svg' alt='Boleto Bancário' style='width: 40px; height: 40px;'>&nbsp;&nbsp;<?= $Pagamento ?>";
            document.getElementById('categoria').style = 'display: none;';
            document.getElementById('Parcelas').value = 1;
            document.getElementById('MetodoPagamento').value = '<?=$Pagamento?>';
        }

        function Pagamento4() {
            <?php
                $_SESSION['Pagamento'] = "CelfixPay";
                $Pagamento = $_SESSION['Pagamento'];
            ?>
            abrir('MetodosTela', 'MetodosTela');
            document.getElementById('SpanMetodo').innerHTML = "<img src='<?= $BASE_URL ?>imagens/CelfixPay.svg' alt='CelfixPay' style='width: 180px; height: 40px;'>&nbsp;&nbsp;";
            document.getElementById('categoria').style = 'display: none;';
            document.getElementById('Parcelas').value = 1;
            document.getElementById('MetodoPagamento').value = '<?=$Pagamento?>';
        }

        document.getElementById('SpanMetodo').innerHTML = "<img src='<?= $BASE_URL ?>imagens/CelfixPay.svg' alt='CelfixPay' style='width: 180px; height: 40px;'>&nbsp;&nbsp;";
    </script>