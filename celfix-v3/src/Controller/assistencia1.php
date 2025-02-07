<?php
   include_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
   include_once($BASE_PATH . 'config/db.php');
   include_once($BASE_PATH . 'src/Models/Message.php');

   include_once($BASE_PATH . 'src/DAO/UserDAO.php');

   include_once($BASE_PATH . 'src/Models/Conserto.php');
   include_once($BASE_PATH . 'src/DAO/ConsertoDAO.php');

   $message = new Message($BASE_URL);

   $consertoDao = new ConsertoDAO($conn, $BASE_URL);
   $conserto = new Conserto();

   //resgata o tipo do formulario
   $type = filter_input(INPUT_POST, "type");

   if($type === "assistencia") {

      $marca = filter_input(INPUT_POST, "marca");
      $aparelho = filter_input(INPUT_POST, "aparelho");
      $descricao = filter_input(INPUT_POST, "descricao");
      $idaparelho = filter_input(INPUT_POST, "idapar");
      $idusuario = filter_input(INPUT_POST, "idusuario");
      $Nome = filter_input(INPUT_POST, "Nome");
      $CPF = filter_input(INPUT_POST, "CPF");
      $notafiscal = filter_input(INPUT_POST, "nota-fiscal");
      $garantia = filter_input(INPUT_POST, "garantia");
      $Atualizacoes = filter_input(INPUT_POST, "Atualizacoes");
      $Apagar = filter_input(INPUT_POST, "Apagar");
      $Telefone = filter_input(INPUT_POST, "Telefone");
      $Termos = filter_input(INPUT_POST, "Termos");

      if(!isset($Atualizacoes)) {
         $Atualizacoes = false;
      }
      
      if($marca && $aparelho && $descricao && $idaparelho && $idusuario && $Nome && $CPF && $Telefone) {
         
         $conserto->id_User = $idusuario;
         $conserto->id_aparelho = $idaparelho;
         $conserto->Descricao = $descricao;
         $conserto->Nome = $Nome;
         $conserto->CPF = $CPF;
         $conserto->Nota_Fiscal = $notafiscal;
         $conserto->Garantia = $garantia;
         $conserto->Atualizacoes = $Atualizacoes;
         $conserto->Apagar = $Apagar;
         $conserto->Telefone = $Telefone;
         $conserto->Termos = $Termos;

         $pro = $consertoDao->create($conserto);

            if($pro) {
                $message->setMessage("Protocolo criado com sucesso!", "success", "index.php");
                exit();
            }
            else {
                $message->setMessage("Erro no conserto.", "error", "back");
                exit();
            }
      }
      else {
         $message->setMessage("Preencha todos os campos.", "error", "back");
      }
   }
   else {
      $message->setMessage("Dados inválidos.", "error", "index.php");
   }