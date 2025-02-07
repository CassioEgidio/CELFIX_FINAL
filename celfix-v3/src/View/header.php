<?php

    include_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
    include_once($BASE_PATH . 'config/db.php');
    include_once($BASE_PATH . 'src/Models/Message.php');
    include_once($BASE_PATH . 'src/DAO/UserDAO.php');

    $message = new Message($BASE_URL);
    $flassMessage = $message->getMessage();

    if(!empty($flassMessage["msg"])) {
        //limpar a mensagem
        $message->clearMessage();
    }

    $userDao = new UserDAO($conn, $BASE_URL);
    $userData = $userDao->verifyToken(false);


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alata&family=Jost&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="<?= $BASE_URL?>imagens/LogoGG.png">

    <script src="<?= $BASE_URL?>js/autocompletar.js" defer></script>
    <script src="<?= $BASE_URL?>js/header-footer1.js" defer></script>

    <?php 
    if (isset($pageJS) && is_array($pageJS)) {
        foreach ($pageJS as $jsFile) {
            echo '<script src="' . htmlspecialchars($BASE_URL . 'js/' . $jsFile) . '" defer></script>';
        }
    }
    ?>
  
    <link rel="stylesheet" href="<?= $BASE_URL?>css/headertest.css">

    <?php 
    if (isset($pageCSS) && is_array($pageCSS)) {
        foreach ($pageCSS as $cssFile) {
            echo '<link rel="stylesheet" href="' . htmlspecialchars($BASE_URL . 'css/' . $cssFile) . '">';
        }
    }
    ?>

    <link rel="stylesheet" href="<?= $BASE_URL?>css/footer11.css">


    
    <title><?= htmlspecialchars($pageTitle) ?></title>
</head>
<body>
    <header>
        <nav class="navbar">
            <a href="<?= $BASE_URL?>index.php" class="logo">
                <img src="<?= $BASE_URL?>imagens/logo.svg" alt="Logo CelFix" title="Voltar para menu CelFix" class="logo1">
                <img src="<?= $BASE_URL?>imagens/logoGG.svg" alt="Logo grande" title="Voltar para menu CelFix" class="logo2">
            </a>
            <ul class="nav-menu">  
                <li class="searchbar">
                    <div class="search">
                        <div class="back"><img src="<?= $BASE_URL?>imagens/close_FILL0_wght400_GRAD0_opsz24.svg"><a>Desculpe, não encontramos nenhum produto.</a></div>
                        <input id="searchInput" onkeyup="filtrar()" type="text" name="" placeholder="Pesquisar" class="search-box">
                        <ul class="list">
                        </ul>
                    </div>
                        <a class="searchbtn" target="_blank"><img src="<?= $BASE_URL?>imagens/search.svg" alt="Pesquise"><div class="searchbnt-a" title="Pesquisar"></div></a> <!--aqui-->
                        <a class="microfone" id="voiceBtn"><img src="<?= $BASE_URL?>imagens/mic_none_black_24dp.svg" alt="Microfone" title="Pesquisar por voz" class="mic"><img src="<?= $BASE_URL?>imagens/micred.svg" class="micred"><div class="searchbnt-b"></div></a>
                </li>
            </ul>
            <ul class="nav-list">
                <?php if($userData): ?>
                    <li><a href="meuperfil.php" class="meu-perfil"><div class="back1"><img src="<?= $BASE_URL?>imagens/person white.svg" alt="Foto do perfil"></div><div class="name-meu_perfil">Meu perfil</div></a></li>
                <?php else: ?>
                    <li><a href="login.php" class="meu-perfil"><div class="back1"><img src="<?= $BASE_URL?>imagens/person white.svg" alt="Foto do perfil"></div><div class="name-meu_perfil">Fazer login</div></a></li>
                <?php endif ?>
                <hr>

                <?php if($userData): ?>
                    <li><a href="<?= $BASE_URL?>meuspedidos.php"><img src="<?= $BASE_URL?>imagens/help.svg" class="IMG4">Meus pedidos</a></li>
                <?php endif ?>

                <li><a href="mapa.php"><img src="<?= $BASE_URL?>imagens/map.svg" class="IMG2">    Mapa</a></li>
                <li><a href="faleconosco.php"><img src="<?= $BASE_URL?>imagens/ques.svg" class="IMG3">    Dúvidas frequêntes</a></li>
                <li><a href="faleconosco.php"><img src="<?= $BASE_URL?>imagens/help.svg" class="IMG4">    Suporte</a></li>
                <?php if($userData && $userData->user_type == 2): ?>
                    <li><a href="<?= $BASE_URL?>cadastrofuncionario.php"><img src="<?= $BASE_URL?>imagens/help.svg" class="IMG4">Cadastrar funcionario</a></li>
                    <li><a href="<?= $BASE_URL?>cadastroProduto.php"><img src="<?= $BASE_URL?>imagens/help.svg" class="IMG4">Cadastrar produto</a></li>
                    <li><a href="<?= $BASE_URL?>pedidosclientes.php"><img src="<?= $BASE_URL?>imagens/help.svg" class="IMG4">Pedidos dos clientes</a></li>
                <?php endif ?>

                <?php if($userData): ?>
                    <li><a href="<?= $BASE_URL?>../src/Controller/logout.php"><img src="<?= $BASE_URL?>imagens/help.svg" class="IMG4">Sair</a></li>
                <?php endif ?>
            </ul>
            <div class="fotoperfil">
                <a class="menu"><img src="<?= $BASE_URL?>imagens/person.svg" alt="perfil" class="boneco"><img src="<?= $BASE_URL?>imagens/close_FILL0_wght400_GRAD0_opsz24.svg" alt="Fechar" class="xis"></a>
            </div>
            <div class="menu-perfil" id="elemento-acionador" title="Menu">
                <a class="menu iconeuser" >

                <?php if ($userData): ?>
                    <?php 
                        if($userData->image == "" ) {
                        $userData->image = "person.svg";
                        }
                    ?>
                <img src="<?= $BASE_URL ?>imagens/users/<?= $userData->image ?>" alt="perfil" class="boneco">
                <?php else: ?>
                    
                <img src="<?= $BASE_URL ?>imagens/person.svg" alt="perfil" class="boneco">
                <?php endif; ?>

                    <img src="<?= $BASE_URL?>imagens/close_FILL0_wght400_GRAD0_opsz24.svg" alt="Fechar" class="xis"></a>

                <div class="menuhover" id="elemento-oculto">
                    <a href="<?= $BASE_URL?>meuspedidos.php" class="caixa"><img src="<?= $BASE_URL?>imagens/box.svg" alt="pedidos" title="Meus pedidos"></a>
                    <a href="Carrinho.php" class="sacola"><img src="<?= $BASE_URL?>imagens/shopping-bag.svg" alt="sacola" title="Sacola de compras"></a>
                </div>
            </div>
        </nav>
    </header>
    <div class="complemento"></div>
    <div class="nav-cat">
        <li class="nav-item"><a href="#" class="nav-link">Mais vendidos</a></li>
        <li class="nav-item"><a href="#" class="nav-link">Ofertas diárias</a></li>
        <li class="nav-item"><a href="#" class="nav-link">Frete grátis</a></li>
        <li class="nav-item"><a href="#" class="nav-link">Para presente</a></li>
        <li class="nav-item"><a href="#" class="nav-link">Celulares</a></li>
        <li class="nav-item"><a href="#" class="nav-link">Acessórios</a></li>
        <li class="nav-item"><a href="#" class="nav-link">Fones de ouvido</a></li>
    </div>

    <?php if(!empty($flassMessage["msg"])): 

        if($flassMessage["type"] == "success") {

            $type = "Sucesso";

        }
        else{

            $type = "Erro";

        }
        ?>

        <div class="toast active">
        <div class="toast-content ">
            <i class="fas fa-check check <?= $type ?>"></i>
            <div class="message">
                <span class="text text-1"><?= $type ?></span>
                <span class="text text-2"><?= $flassMessage["msg"]; ?></span>
            </div>
        </div>
        <div class="close">&times;</div>
        <div class="progress active"></div>
        </div>
        <?php $message->clearMessage(); // Limpa a mensagem após exibir ?>
    <?php endif; ?>