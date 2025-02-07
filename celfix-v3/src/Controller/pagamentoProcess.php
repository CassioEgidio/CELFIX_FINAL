<?php

use function PHPSTORM_META\type;

    include_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
    include_once($BASE_PATH . 'config/db.php');
    include_once($BASE_PATH . 'src/Models/Message.php');

    include_once($BASE_PATH . 'src/DAO/ProdutoDAO.php');
    include_once($BASE_PATH . 'src/Models/Produto.php');

    include_once($BASE_PATH . 'src/DAO/PagamentoProdutoDAO.php');
    include_once($BASE_PATH . 'src/Models/PagamentoProduto.php');

    include_once($BASE_PATH . 'src/DAO/UserDAO.php');
    include_once($BASE_PATH . 'src/Models/User.php');

    $message = new Message($BASE_URL);

    $ProdutoDAO = new ProdutoDAO($conn, $BASE_URL);
    $Produto = new Produto();

    $pagamentoProdutoDAO = new PagamentoProdutoDAO($conn, $BASE_URL);
    $pagamentoProduto = new PagamentoProduto();

    $userDao = new UserDAO($conn, $BASE_URL);
    $user = new User();

    $userData = $userDao->verifyToken();

    //resgata o tipo do formulario
    $type = filter_input(INPUT_POST, "type");

    if($type === "pagamentoproduto") {

            //receber dados do post
            $valortotal = filter_input(INPUT_POST, "dataField1");
            $qtdepecas = filter_input(INPUT_POST, "dataField2");
            $metodopagamento = filter_input(INPUT_POST, "dataField3");
            $idproduto = filter_input(INPUT_POST, "dataField4");
            $idendereco = filter_input(INPUT_POST, "dataField5");
            $nparcelas = filter_input(INPUT_POST, "dataField6");

            if($ProdutoDAO->findbyid($idproduto)) {

                $ProdutoData = $ProdutoDAO->findbyid($idproduto);

                if($userData && $valortotal && $qtdepecas && $metodopagamento && $idproduto && $idendereco && $nparcelas) {
                    
                    if($metodopagamento != "Cartão de crédito") {
                        $nparcelas = 1;
                    }
        
                    //gerar data entrega
                    $dataEntrega =  $pagamentoProduto->getFutureDate();

                    $pagamentoProduto->id_produto = $idproduto;
                    $pagamentoProduto->id_usuario = $userData->id;
                    $pagamentoProduto->id_endereco = $idendereco;
                    $pagamentoProduto->preco_total = $valortotal;
                    $pagamentoProduto->Status = 1;
                    $pagamentoProduto->tipo_pagamento = $metodopagamento;
                    $pagamentoProduto->n_parcelas = $nparcelas; //mandei a qtde de parcelas
                    $pagamentoProduto->qtde_pecas_compradas = $qtdepecas;
                    $pagamentoProduto->data_entrega = $dataEntrega;

                    $validar = $pagamentoProdutoDAO->create($pagamentoProduto);

                    if($validar) {
                        $message->setMessage("Compra realizada com sucesso.", "success", "meuspedidos.php"); //mudar
                        exit();
                    }
                    else {
                        $message->setMessage("Erro ao fazer a compra.", "error", "back");
                        exit();
                    }
        
                }
                else {
                    $message->setMessage("Dados inválidos.", "error", "index.php");
                    exit();
                }

            }
            else {
                $message->setMessage("O produto não foi encontrado.", "error", "index.php");
                exit();
            }
    }
    if($type === "Cancelar") {
        $idCompra = filter_input(INPUT_POST, "idCompra");

        $validar = $pagamentoProdutoDAO->AtualizarStatus(5, $idCompra);

        if($validar) {
            $message->setMessage("Compra cancelada!", "error", "meuspedidos.php");
            exit();
        } else {
            $message->setMessage("Erro ao cancelar a compra.", "error", "meuspedidos.php");
            exit();
        }
    }

    if($type === "Confirmar") {
        $idCompra = filter_input(INPUT_POST, "idCompra");

        $validar = $pagamentoProdutoDAO->AtualizarStatus(4, $idCompra);

        if($validar) {
            $message->setMessage("Entrega confirmada!", "success", "meuspedidos.php");
            exit();
        } else {
            $message->setMessage("Erro ao confrimar a entrega.", "success", "meuspedidos.php");
            exit();
        }
    }
?>