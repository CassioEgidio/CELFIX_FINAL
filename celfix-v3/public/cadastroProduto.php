<?php
    $pageTitle = "Cadastro produto";
    $pageCSS = ["cadastroproduto2.css"];
    $pageJS = [""];

    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');

    include_once($BASE_PATH . 'src/DAO/UserDAO.php');
    include_once($BASE_PATH . 'config/db.php');

    $userDao = new UserDAO($conn, $BASE_URL);
    $userData = $userDao->verifyFuncionario(true);

    include $BASE_PATH . 'src/View/header.php';

    $userData = $userDao->verifyFuncionario(true);

?>
    <main>
        
        <form action="<?= $BASE_URL ?>../src/Controller/cadastroprodutoprocess.php" method="post" enctype="multipart/form-data">  

            <input type="hidden" name="type" value="createproduto">

            
            <div class="tudo">
                <div class="esquerda">

                    <div class="tudoesquerda">

                        <p class="pfot">Insira as fotos do produto</p>
                        <p class="pfo">Insira todas as fotos de uma vez</p>

                        <div class="clique" id="div1" onclick="openFileInput()">
                            <img src="<?php $BASE_URL?>imagens/add.png" id="imgPreview1">
                        </div>

                        <div class="restodacaixa">
                            <div class="clique2" id="div2">
                                <img class="imgq" src="<?php $BASE_URL?>imagens/add.png" id="imgPreview2">
                            </div>
                            <div class="clique2" id="div3">
                                <img class="imgq" src="<?php $BASE_URL?>imagens/add.png" id="imgPreview3">
                            </div>
                            <div class="clique2" id="div4">
                                <img class="imgq" src="<?php $BASE_URL?>imagens/add.png" id="imgPreview4">
                            </div>
                            <div class="clique2" id="div5">
                                <img class="imgq" src="<?php $BASE_URL?>imagens/add.png" id="imgPreview5">
                            </div>
                        </div>

                        <input type="file" id="myInput" name="imagens[]" accept="image/*" multiple style="display: none;">

                        <!-- Exibição das imagens selecionadas 
                        <div id="selectedImages"></div>-->

                    </div>

                </div>
                <div class="direita">

                    <div class="parte1">

                        <div class="envolta">
                            <div class="txt_field">
                                <input type="text" id="titulo" name="titulo" required>
                                <span></span>
                                <label>Título</label>
                            </div>

                            <div class="txt_field">
                                <input type="text" id="subtitulo" name="subtitulo" required>
                                <span></span>
                                <label>Sub-título</label>
                            </div>

                            <div class="txt_field">
                                <input type="number" id="precoavista" name="precoavista" required>
                                <span></span>
                                <label>Preço a vista</label>
                            </div>

                            <div class="txt_field">
                                <input type="number" id="precoparcelado" name="precoparcelado" required>
                                <span></span>
                                <label>Preço parcelado</label>
                            </div>

                            <div class="txt_field">
                                <input type="number" id="nparcelas" name="nparcelas" required>
                                <span></span>
                                <label>Numero de parcelas</label>
                            </div>

                            <select id="categoria" name="categoria">
                                <option value="nenhum">Nenhum</option>
                                <option value="celulares">Celulares</option>
                                <option value="fones">Fones</option>
                                <option value="capinhas">Capinhas</option>
                                <option value="acessórios">Acessórios</option>
                                <option value="produtos mais vendidos">Produtos Mais Vendidos</option>
                                <option value="tablets">Tablets</option>
                                <option value="carregadores">Carregadores</option>
                                <option value="adaptadores">Adaptadores</option>
                                <option value="acessórios de jogos">Acessórios de Jogos</option>
                                <option value="microfones">Microfones</option>
                            </select>

                            <div class="frete">
                                <p class="fretetext">Frete grátis</p>
                                <div class="dshdbfhbd">
                                    <input type="radio" id="sim" class="sim" name="frete" value="1" onclick="checkRadioAndChangeLabelStyle()">
                                    <label id="clickLabel1" for="sim">Sim</label>
                                    <input type="radio" id="nao" class="nao" name="frete" value="0" onclick="checkRadioAndChangeLabelStyle()">
                                    <label id="clickLabel2" for="nao">Não</label>
                                </div>
                            </div>

                        </div>
                        
                    </div>

                    <div class="parte2">

                        <div class="envolta">

                            <div class="txt_field">
                                <input type="number" id="estoque" name="estoque" required>
                                <span></span>
                                <label>Estoque</label>
                            </div>

                            <textarea id="descricao" name="descricao" rows="5" cols="50" placeholder="Escreva sua mensagem aqui..."></textarea>
                        </div>
                    </div>

                </div>
                
            </div>

            <div class="divbotao">
                <input class="botao" type="submit" value="Enviar">
            </div>

            

        </form>
    </main>

    <script>
        const inputImagens = document.getElementById("myInput"); // Certifique-se de que o ID do input esteja correto
        let selectedFiles = [];

        // Função para abrir o seletor de arquivos
        function openFileInput() {
            inputImagens.click(); // Simula o clique no campo de input
        }

        // Quando o usuário seleciona novas imagens
        inputImagens.addEventListener("change", (event) => {
            const newFiles = Array.from(event.target.files); // Captura os novos arquivos selecionados

            // Limita o número de arquivos a 5, ou o número máximo de divs que você tem
            const maxFiles = 5;
            const totalFiles = selectedFiles.length + newFiles.length;
            if (totalFiles > maxFiles) {
                alert(`Você só pode selecionar até ${maxFiles} imagens.`);
                return;
            }

            // Adiciona os novos arquivos à lista de arquivos já selecionados
            selectedFiles.push(...newFiles); // Usamos push para adicionar ao array existente

            // Limpa duplicatas (se necessário)
            selectedFiles = Array.from(new Set(selectedFiles));

            // Exibe as imagens nas divs
            selectedFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const imageElement = document.getElementById(`imgPreview${index + 1}`);
                    if (imageElement) {
                        imageElement.src = e.target.result; // Define o src da imagem como a prévia gerada
                    }
                };
                reader.readAsDataURL(file); // Lê o arquivo e gera a prévia
            });
        });

        // Se você ainda quiser resetar o formulário após o envio, mantenha esta parte
        const form = document.getElementById("produtoForm");
        form.addEventListener("submit", (event) => {
            // Aguarda o envio do formulário
            setTimeout(() => {
                // Reseta o formulário e limpa a lista de arquivos selecionados
                form.reset();
                selectedFiles = [];
                // Também pode querer limpar as prévias das imagens
                for (let i = 1; i <= 5; i++) { // Supondo que você tenha 5 divs para imagens
                    const imageElement = document.getElementById(`imgPreview${i}`);
                    if (imageElement) {
                        imageElement.src = ""; // Limpa o src da imagem
                    }
                }
            }, 100); // Dá tempo para o formulário ser enviado antes de limpar
        });



        //script form

        function checkRadioAndChangeLabelStyle() {
            if (document.getElementById('sim').checked) {
                document.getElementById('clickLabel1').style.fontSize = '26px';
                document.getElementById('clickLabel1').style.color = '#30107A';
            } else {
                document.getElementById('clickLabel1').style.fontSize = '22px';
                document.getElementById('clickLabel1').style.color = '#89938F';
            }
        
            if (document.getElementById('nao').checked) {
                document.getElementById('clickLabel2').style.fontSize = '26px';
                document.getElementById('clickLabel2').style.color = '#30107A';
            } else {
                document.getElementById('clickLabel2').style.fontSize = '22px';
                document.getElementById('clickLabel2').style.color = '#89938F';
            }
        }

       
        
    </script>


</body>
</html>