<?php 

    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');

    include_once($BASE_PATH . 'src/Models/Carrinho.php');
    include_once($BASE_PATH . 'src/DAO/CarrinhoDAO.php');
    include_once($BASE_PATH . 'config/db.php');
    include_once($BASE_PATH . 'src/Models/Message.php');

    $message = new Message($BASE_URL);


    $carrinhoDao = new CarrinhoDAO($conn, $BASE_URL);

    $idcarrinho = filter_input(INPUT_POST, "idcarrinho");

    $teste = $carrinhoDao->deleteCarrinho($idcarrinho);

    if($teste) {
        $message->setMessage("Produto deletado.", "success", "back"); 
    }
    else {
        $message->setMessage("Erro.", "error", "back");

    }