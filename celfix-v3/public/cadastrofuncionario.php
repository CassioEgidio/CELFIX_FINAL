<?php  
    $pageTitle = "Cadastro Funcionario";
    $pageCSS = ["cadastrofuncv22.css"];
    $pageJS = [""];

    include_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
    include $BASE_PATH . 'src/View/simpleheaderfuncionario.php';
?>

<body>

    <main>
        <div class="left">
            <div class="logo-maior">
                <center><img src="imagens/logo.svg" alt="logo"></center>
            </div>
        </div>

        <div class="card-login">

            <div class="msg-container">
                <?php if(!empty($flassMessage["msg"])): ?>
                <p class="msg <?= $flassMessage["type"] ?>"><?= $flassMessage["msg"] ?></p>
                <?php endif; ?>
            </div>

            <div class="separador"></div>

            <div class="conhece">
                <h1>Cadastre um novo funcionário!</h1>
            </div>

            <form action="<?= $BASE_URL ?>../src/Controller/registroFuncionario.php" method="POST">

                <input type="hidden" name="type" value="registroFuncionario">

                <div class="txt_field">
                    <input type="text" id="name" name="name" required>
                    <span></span>
                    <label>Nome completo</label>
                </div>
                <div class="txt_field">
                    <input type="email" id="email" name="email" required>
                    <span></span>
                    <label>Email</label>
                </div>

                <div class="txt_field">
                    <input type="text" id="cpf" name="cpf" maxlength="14" required>
                    <span></span>
                    <label>CPF</label>
                </div>
                <div class="txt_field">
                    <input type="password" id="password" name="password" required>
                    <span></span>
                    <label>Senha</label>
                </div>

                <div class="txt_field">
                    <input type="date" id="date" name="date" required>
                    <label class="dataNasc">Data de Nascimento</label>
                </div>

                <div class="termos">
                    <div>
                        <input type="checkbox" class="checkboxTerm" required>
                        <label>Aceito os termos e condições</label>
                    </div>
                    <a href="ter">Ver termos</a>
                </div><br>

                <input type="submit" value="Cadastrar">


            </form>

        </div>

    </main>


</body>

</html>