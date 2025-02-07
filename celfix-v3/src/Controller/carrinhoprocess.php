<?php
    $pageTitle = "Visão do produto";
    $pageCSS = ["visao11.css"];
    $pageJS = ["visao.js"];

    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
    include_once($BASE_PATH . 'config/db.php');
    include_once($BASE_PATH . 'src/Models/Message.php');

    include_once($BASE_PATH . 'src/Models/Produto.php');
    include_once($BASE_PATH . 'src/DAO/ProdutoDAO.php');

    $message = new Message($BASE_URL);

    //processamento produto
    $produtoDao = new ProdutoDAO($conn, $BASE_URL);

    $id = filter_input(INPUT_GET, "Product");

    $produto;

    if(empty($id)) {
        $message->setMessage("O produto não foi encontrado.", "error", "index.php");
        exit();
    }
    else {
        $produto = $produtoDao->findById($id);

        //verifica se o filme existe
        if(!$produto) {
            $message->setMessage("O produto não foi encontrado.", "error", "index.php");
            exit();
        }
    }

    include_once($BASE_PATH . 'src/DAO/UserDAO.php');
    include_once($BASE_PATH . 'src/Models/User.php');

    $userDao = new UserDAO($conn, $BASE_URL);
    $user = new User();

    $userData = $userDao->verifyToken();

    if($userData->id == "") {

        $message->setMessage("Você precisa estar logado.", "error", "back");
        exit();

    }

    include_once($BASE_PATH . 'src/Models/Carrinho.php');
    include_once($BASE_PATH . 'src/DAO/CarrinhoDAO.php');

    $carrinhoDao = new CarrinhoDAO($conn, $BASE_URL);

    $teste = $carrinhoDao->create($userData->id, $produto->id);

    if($teste) {
        $message->setMessage("Produto adicionado ao carrinho.", "success", "back");
        exit();
    }
    else {
        $message->setMessage("Erro ao adicionar ao carrinho.", "error", "back");
        exit();
    }


