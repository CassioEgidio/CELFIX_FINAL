<?php
    $pageTitle = "Meu perfil";
    $pageCSS = ["meuperfil5.css"];
    $pageJS = [""];

    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');

    include_once($BASE_PATH . 'src/DAO/UserDAO.php');
    include_once($BASE_PATH . 'src/DAO/EnderecoDAO.php');
    include_once($BASE_PATH . 'config/db.php');

    $userDao = new UserDAO($conn, $BASE_URL);
    $EnderecoDao = new EnderecoDAO($conn, $BASE_URL);
    $userData = $userDao->verifyToken(true);
    $EnderecoData = $EnderecoDao->findByToken($userData->id);

    include $BASE_PATH . 'src/View/header.php';

    //imagem
    if($userData->image == "") {
        $userData->image = "person.svg";
    }
?>

<main>  
            <div class="conteiner">
                <div class="left">
                    <div class="janela">
                        <form id="closeForm">
                            <div class="trocSenha">
                                <button class="btcSenha" id="showButton">Trocar senha</button>
                            </div>
                            <div class="telaTrocaSenha" id="toggleDiv">
                                <div class="fundoSenha"></div>
                                <div class="box">
                                    <p class="ConfirmeEmail">Confirme seu email</p>
                                    <div class="CloseBtn" id="CloseBtn"><img src="imagens/close.svg"></div>

                                    <p class="emailEsc">gui**************com</p>

                                    <input type="text" id="emailConf" name="emailConf" required>
                                    <span></span>
                                    <label>Digite aqui</label>
                                    <br>
                                    <div class="buttonsBox">
                                        <input type="submit" value="Confirmar" class="buttonSenha">
                                    </div>
                                </div>
                            </div>
                        </form>

                        <form id="closeForm2" action="<?= $BASE_URL?>../src/Controller/meuperfil_process.php" method="POST">
                            <div class="ExcConta">
                                <input type="button" class="btcexcluir" id="showButton2" value="Excluir conta">
                            </div>

                            <div class="telaExcCont" id="toggleDiv2">
                                <div class="fundoExc"></div>
                                <div class="box">
                                    <p class="ConfirmeEmail">Deseja Excluir sua Conta</p>
                                    <div class="CloseBtn" id="CloseBtn2" onclick=""><img src="imagens/close.svg"></div>
                                    <div class="buttonsBox">
                                        <input type="hidden" name="type" value="delete">
                                        <input type="submit" value="Sim" class="buttonSenha sim">
                                        <input type="button" id="CloseBtn3" value="Não" class="buttonSenha nao">
                                    </div>
                                </div>
                            </div>
                        </form>

                        <input class="btnEndereco" type="button" value="Gerencir Endereços" onclick="EnderecoTelaAbrir()">
                        <div class="EnderecoTela" id="EnderecoTela">
                            <div class="adds">
                                <form action="<?= $BASE_URL?>../src/Controller/meuperfil_process.php" method="post">
                                    <div class="txt_field">
                                        <input type="number" id="cep" name= "cep" value="" oninput="limitInputLength(this, 8)" required>
                                        <span></span>
                                        <label>CEP</label>
                                    </div>
                                    
                                    <div class="txt_field">
                                        <input type="number" id="num_cep" name="num_cep" value="" required>
                                        <span></span>
                                        <label>Número</label>
                                    </div>

                                    <div class="txt_field">
                                        <input type="text" id="descricao_cep" name="descricao_cep" value="" maxlength="30" required>
                                        <span></span>
                                        <label>Descrição</label>
                                    </div>

                                    <input type="hidden" name="type" value="createEndereco">
                                    <input class="btnCriarEndereco" type="submit" value="Criar Endereço">
                                    <input class="btnCriarEndereco" onclick="EnderecoTelaAbrir()" type="button" value="Sair">
                                </form>
                            </div>
                            <div class="enderecos">
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
                                                <form action="" method="post">
                                                    <input type="submit" value="Editar">
                                                </form>
                                                <form action="" method="post">
                                                    <input type="submit" value="Excluir">
                                                </form>
                                            </div>
                                        </div>
                                    <?php }
                                ?>
                            </div>
                        </div>

                    </div>

     <!--pegando--> <form action="<?= $BASE_URL?>../src/Controller/meuperfil_process.php" method="POST" enctype="multipart/form-data">
                    
                    <div class="cardtamanho">

                        <input type="hidden" name="type" value="update">

                        <div class="txt_field">
                            <input type="text" id="name" name="name" value="<?= $userData->name ?>" required>
                            <span></span>
                            <label>Nome completo</label>
                        </div>

                        <div class="gender">
                            <input type="radio" id="Masculino" class="Masculino" name="sexo" value="Masculino" <?= $userData->sexo === "Masculino" ? "checked" : "" ?> onclick="checkRadioAndChangeLabelStyle()">
                            <label id="clickLabel1" for="Masculino">Masculino</label>
                            <input type="radio" id="Feminino" class="Feminino" name="sexo" value="Feminino" <?= $userData->sexo === "Feminino" ? "checked" : "" ?> onclick="checkRadioAndChangeLabelStyle()">
                            <label id="clickLabel2" for="Feminino">Feminino</label>
                        </div>  

                        <div class="txt_field">
                            <input type="hidden" name="email" value="<?=$userData->email?>">
                            <input type="text" id="email"
                                value="<?php
                                    $numCaracter = strlen($userData->email) * 0.5;
                                    $mail = substr($userData->email, 0, -$numCaracter) . str_repeat("•", $numCaracter);
                                    echo trim($mail);
                                ?>" readonly required>
                            <span></span>
                            <label>Email</label>
                        </div>

                        <div class="txt_field">
                            <input type="text" id="telefone" name="telefone" value="<?= $userData->telefone ?>">
                            <span></span>
                            <label>Telefone</label>
                        </div>

                        <div class="txt_field">
                            <input type="text" id="cpf" name="cpf" value="<?= $userData->cpf ?>" readonly required>
                            <span></span>
                            <label>CPF</label>
                        </div>

                        <div class="txt_field seg6">
                            <input type="date" id="date" name="date" value="<?= $userData->birthdate ?>"  required class="in6">
                            <label>Data de nascimento</label>
                        </div>

                    </div>

                </div>

                <div class="right">

                    <div class="imagemusu">
                        <p class="pright">
                            Extensão de arquivo: .JPEG .PNG<br>
                            Tamanha: 640x480 | 1920x1080
                        </p>

                        <div class="divimagem" id="myDiv" style="background-image: url('<?= $BASE_URL ?>imagens/users/<?= $userData->image ?>')"></div>

                        <input type="file" id="myInput" class="form-control-file" name="image">
                        <p id="fileName" style="text-align: center;"  class="fileText"></p><br>
                    </div>
                </div>
            </div>

            <div class="telaTrocaSenha2" id="senhaconfir">
                <div class="fundoSenha"></div>
                <div class="box">
                    <p class="ConfirmeEmail">Digite sua senha para continuar</p>
                    <div class="CloseBtn" onclick="fecharJanela()"><img src="imagens/close.svg"></div>

                    <p class="emailEsc">
                        <?php
                            $numCaracter = strlen($userData->email) * 0.5;
                        ?>
                        <?= 
                            substr($userData->email, 0, -$numCaracter) .
                            str_repeat("•", $numCaracter);
                        ?>
                    </p>

                    <input type="text" name="senhaConf" required>
                    <span></span>
                    <label>Digite aqui</label>
                    <br>
                    <div class="buttonsBox">
                        <input type="submit" value="Confirmar" class="buttonSenha">
                    </div>
                </div>
            </div>

                            
                            
            <div class="divbotao">
                <input type="button" id="editbutton" value="Salvar" onclick="abrirJanela()">
            </div>
        </form>  <!--acaba aqui-->


    <script> 

        function EnderecoTelaAbrir() {
            var u = document.getElementById('EnderecoTela');
            u.classList.toggle('EnderecoTelaAbrir');
        }

        function limitInputLength(element, maxLength) {
            if (element.value.length > maxLength) {
                element.value = element.value.slice(0, maxLength);
            }
        }

        function abrirJanela() {
            document.getElementById('senhaconfir').style.display = 'flex';
        }
        function fecharJanela() {
            document.getElementById('senhaconfir').style.display = 'none';
        }

        const showButton = document.getElementById('showButton');
        const toggleDiv = document.getElementById('toggleDiv');


        const closeForm = document.getElementById('closeForm');
        const closeBtn = document.getElementById('CloseBtn');

            // Adiciona o evento de clique no botão de mostrar
        showButton.addEventListener('click', function() {
            toggleDiv.style.display = 'flex';
        });

            // Adiciona o evento de envio no formulário para fechar a div
        closeForm.addEventListener('submit', function(event) {
            toggleDiv.style.display = 'none';
        });
        closeBtn.addEventListener('click', function(event) {
            toggleDiv.style.display = 'none';
        });

        const showButton2 = document.getElementById('showButton2');
        const toggleDiv2 = document.getElementById('toggleDiv2');
        const closeForm2 = document.getElementById('closeForm2');
        const closeBtn2 = document.getElementById('CloseBtn2');
        const closeBtn3 = document.getElementById('CloseBtn3');

            // Adiciona o evento de clique no botão de mostrar
        showButton2.addEventListener('click', function() {
            toggleDiv2.style.display = 'flex';
        });
       

            // Adiciona o evento de envio no formulário para fechar a div
        closeForm2.addEventListener('submit', function(event) {
            toggleDiv2.style.display = 'none';
        });
        closeBtn2.addEventListener('click', function(event) {
            toggleDiv2.style.display = 'none';
        });
        closeBtn3.addEventListener('click', function(event) {
            toggleDiv2.style.display = 'none';
        });

        document.querySelectorAll('.txt_field input').forEach(input => {
            input.addEventListener('focus', () => {
                input.classList.add('focused');
            });
        
            input.addEventListener('blur', () => {
                input.classList.remove('focused');
                if (input.value !== '') {
                    input.classList.add('filled');
                } else {
                    input.classList.remove('filled');
                }
            });
        });

        document.querySelectorAll('.box input[type="text"]').forEach(input => {
            input.addEventListener('focus', () => {
                input.classList.add('focused');
            });
        
            input.addEventListener('blur', () => {
                input.classList.remove('focused');
                if (input.value !== '') {
                    input.classList.add('filled');
                } else {
                    input.classList.remove('filled');
                }
            });
        });

        document.getElementById('clickLabel1').addEventListener('click', function() {
            document.getElementById('Masculino').checked = true;
        });
        
        document.getElementById('clickLabel2').addEventListener('click', function() {
            document.getElementById('Feminino').checked = true;
        });

        function checkRadioAndChangeLabelStyle() {
            if (document.getElementById('Masculino').checked) {
                document.getElementById('clickLabel1').style.fontSize = '26px';
                document.getElementById('clickLabel1').style.color = '#30107A';
            } else {
                document.getElementById('clickLabel1').style.fontSize = '22px';
                document.getElementById('clickLabel1').style.color = '#89938F';
            }
        
            if (document.getElementById('Feminino').checked) {
                document.getElementById('clickLabel2').style.fontSize = '26px';
                document.getElementById('clickLabel2').style.color = '#30107A';
            } else {
                document.getElementById('clickLabel2').style.fontSize = '22px';
                document.getElementById('clickLabel2').style.color = '#89938F';
            }
        }

        // Adiciona os event listeners após o carregamento da página
    window.onload = function() {
        document.getElementById('Masculino').addEventListener('change', checkRadioAndChangeLabelStyle);
        document.getElementById('Feminino').addEventListener('change', checkRadioAndChangeLabelStyle);

        // Chama a função uma vez ao carregar a página para definir o estilo correto
        checkRadioAndChangeLabelStyle();
    };

        document.getElementById('myDiv').addEventListener('click', function() {
            document.getElementById('myInput').click();
        });

        document.getElementById('myInput').addEventListener('change', function() {
            var file = document.getElementById('myInput').files[0];
            var arqName = "<span style='font-size: 18px; color: #30107A; font-weight: 600;'>Arquivo selecionado - </span>";

            if (file) {
                // Exibe o nome do arquivo
                document.getElementById('fileName').innerHTML = arqName + file.name + "</span>";
            } else {
                // Limpa o texto e mantém o item escondido caso não haja arquivo selecionado
                document.getElementById('fileName').textContent = '';
            }
        });

        document.querySelectorAll('.txt_field input').forEach(input => {
    input.addEventListener('focus', () => {
        input.classList.add('focused');
    });

    input.addEventListener('blur', () => {
        input.classList.remove('focused');
        if (input.value !== '') {
            input.classList.add('filled');
        } else {
            input.classList.remove('filled');
        }
    });

    // Adiciona a classe 'filled' se o input já tiver valor ao carregar a página
    if (input.value !== '') {
        input.classList.add('filled');
    }
});

    </script>

</main>

</body>

</html>