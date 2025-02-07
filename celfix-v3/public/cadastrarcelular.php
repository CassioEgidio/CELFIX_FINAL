<?php
    $pageTitle = "Celfix";
    $pageCSS = ["cadastroproduto2.css"];
    $pageJS = [""];

    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
    include_once($BASE_PATH . 'config/db.php');

    include_once($BASE_PATH . 'src/DAO/UserDAO.php');

    $userDao = new UserDAO($conn, $BASE_URL);
    $userData = $userDao->verifyFuncionario(true);

    include $BASE_PATH . 'src/View/header.php';
  
?>
<main>
        
        <form action="<?= $BASE_URL ?>../src/Controller/cadastrarcelular.php" method="post" enctype="multipart/form-data">  

            <input type="hidden" name="type" value="createcelular">

            <div class="tudo">
                <div class="esquerda">

                    <div class="tudoesquerda">

                        <p class="pfot">Insira uma fotos do celular</p>

                        <div class="clique" onclick="openFileInput()">
                            <img src="<?= $BASE_URL ?>imagens/add.png" id="imgPreview" class="preview">
                        </div>

                        <input type="file" id="myInput" name="imagem" accept="image/*" style="display: none;">


                        <!-- Exibição das imagens selecionadas 
                        <div id="selectedImages"></div>-->

                    </div>

                </div>
                <div class="direita">

                    <div class="parte1">

                        <div class="envolta">

 
                            <select id="categoria" name="categoria">
                                <option value="">Nenhum</option>
                                <option value="Apple">Apple</option>
                                <option value="Samsung">Samsung</option>
                                <option value="Motorola">Motorola</option>
                                <option value="LG">LG</option>
                                <option value="Realme">Realme</option>
                                <option value="Xiaomi">Xiaomi</option>
                                <option value="Sony">Sony</option>
                            </select>

                            <div class="txt_field">
                                <input type="text" id="subtitulo" name="subtitulo" required>
                                <span></span>
                                <label>Modelo do aparelho</label>
                            </div>
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
        const inputImagens = document.getElementById("myInput");
        const imgPreview = document.getElementById("imgPreview");

        function openFileInput() {
            inputImagens.click();
        }

        inputImagens.addEventListener("change", (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    imgPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                imgPreview.src = "<?= $BASE_URL ?>imagens/add.png";
            }
        });
    </script>


</body>
</html>