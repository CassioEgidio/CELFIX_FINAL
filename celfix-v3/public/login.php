<?php  
    $pageTitle = "Login";
    $pageCSS = ["logincssful.css"];
    $pageJS = [""];

    include_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
    include $BASE_PATH . 'src/View/simpleheader.php';
?>

<body>

    <header>
        <nav class="navbar">
            <a href="<?= $BASE_URL?>index.php" class="logo">
                <img src="<?= $BASE_URL?>imagens/logo.svg" alt="Logo CelFix" title="Voltar para menu CelFix" class="logo1">
            </a>         
        </nav>

    </header>

    <main>
        <div class="left">
            <div class="logo-maior">
                <center><img src="<?= $BASE_URL?>imagens/CelfixTrans (1).png" alt="logo" width="auto" height="100%"></center>
            </div>

        </div>

        <div class="right">
            <div class="teto">
                <div class="ola">
                    <h1>Olá!</h1>
                </div>

                <div class="conhece">
                    <h1>Já nos conhece?</h1>
                </div>
            </div>

            
            <div class="msg-container">
                <?php if(!empty($flassMessage["msg"])): ?>
                    <p class="msg <?= $flassMessage["type"] ?>"><?= $flassMessage["msg"] ?></p>
                <?php endif; ?>
            </div>
           

            <div class="card-login">

                <div class="entre">
                    <h1>Entre na sua conta</h1>
                </div>


                <form action="<?= $BASE_URL ?>../src/Controller/registroProce.php" method="POST"> 

                    <input type="hidden" name="type" value="login">

                    <div class="txt_field">
                    <input type="email" id="email" name="email" required>
                    <span></span>
                        <label>Email</label>
                    </div>

                    <div class="txt_field">
                    <input type="password" id="password" name="password" required>
                    <span></span>
                        <label>Senha</label>
                    </div>

                    <div class="pass">Esqueceu a Senha?</div>

                    <input type="submit" value="Entrar">

                    <div class="signup_link">
                        Não é cadastrado? <a href="<?= $BASE_URL?>cadastro.php">Cadastre-se</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

</body>

</html>