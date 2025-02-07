<?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
    require_once($BASE_PATH . 'src/Models/Message.php');

    $message = new Message($BASE_URL);
    
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            $message->setMessage("Você já está logado!", "error", "index.php");
            exit;
        }

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

    <link rel="stylesheet" href="<?= $BASE_URL?>css/msgcadastro2.css">

    <title><?= htmlspecialchars($pageTitle) ?></title>
</head>