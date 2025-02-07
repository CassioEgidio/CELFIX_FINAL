<?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
    require_once($BASE_PATH . 'src/Models/Message.php');
    include_once($BASE_PATH . 'src/DAO/UserDAO.php');
    include_once($BASE_PATH . 'config/db.php');

    $userDao = new UserDAO($conn, $BASE_URL);

    $message = new Message($BASE_URL);
    
    $userData = $userDao->verifyFuncionario(true); //verifica se é funcionario

    $flassMessage = $message->getMessage();

    if(!empty($flassMessage["msg"])) {
        //limpar a mensagem
        $message->clearMessage();
    }
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

    <link rel="stylesheet" href="<?= $BASE_URL?>css/style-header-simples.css">
    <script src="<?= $BASE_URL?>js/cpf.js"></script>

    <?php 
    if (isset($pageCSS) && is_array($pageCSS)) {
        foreach ($pageCSS as $cssFile) {
            echo '<link rel="stylesheet" href="' . htmlspecialchars($BASE_URL . 'css/' . $cssFile) . '">';
        }
    }
    ?>

    <link rel="stylesheet" href="<?= $BASE_URL?>css/msgcadastrofuncionario2.css">

    <title><?= htmlspecialchars($pageTitle) ?></title>
</head>

<header>
        <nav class="navbar">
            <a href="<?= $BASE_URL?>index.php" class="logo">
                <img src="<?= $BASE_URL?>imagens/logo.svg" alt="Logo CelFix" title="Voltar para menu CelFix" class="logo1">
            </a>         
        </nav>
</header>