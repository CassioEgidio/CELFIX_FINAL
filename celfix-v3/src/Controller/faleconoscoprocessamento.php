<?php

    include_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
    include_once($BASE_PATH . 'config/db.php');
    include_once($BASE_PATH . 'src/Models/Message.php');
    include_once($BASE_PATH . 'src/DAO/FaleConoscoDAO.php');
    include_once($BASE_PATH . 'src/Models/FaleConosco.php');

    $message = new Message($BASE_URL);
    $faleconoscoDao = new FaleConoscoDAO($conn, $BASE_URL);
    $faleconosco = new FaleConosco();

    //resgata o tipo do formulario
    $type = filter_input(INPUT_POST, "type");

    if($type === "faleconosco") {

        //receber dados do post
        $nome = filter_input(INPUT_POST, "nome");
        $email = filter_input(INPUT_POST, "email");
        $mensagem = filter_input(INPUT_POST, "mensagem");

        if($nome && $email && $message) {

            //preencher dados do aparelho
            $faleconosco->nome = $nome;
            $faleconosco->email = $email;
            $faleconosco->mensagem = $mensagem;

            $pro = $faleconoscoDao->create($faleconosco);

            if($pro) {
                $message->setMessage("Mensagem enviada.", "success", "back");
                exit();
            }
            else {
                $message->setMessage("Erro ao enviar a mensagem.", "error", "back");
                exit();
            }

            
        }
        else {
            $message->setMessage("Preencha todos os dados.", "error", "back");
        }
    }
    else {
        $message->setMessage("Dados inválidos.", "error", "index.php");
    }