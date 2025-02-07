<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
    require_once($BASE_PATH . 'src/Models/FaleConosco.php');
    require_once($BASE_PATH . 'src/Models/Message.php');

    class FaleConoscoDAO implements FaleConoscoDAOInterface {

        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url) {
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }

        public function buildFale($data) {

            $faleconosco = new FaleConosco();
        
            $faleconosco->id_fale = $data["id_fale"];
            $faleconosco->nome = $data["nome"];
            $faleconosco->email = $data["email"];
            $faleconosco->mensagem = $data["mensagem"];
           
            return $faleconosco;

        }

        public function create(FaleConosco $fale) {

            try {        
                // Inserir os dados do produto
                $stmt = $this->conn->prepare("INSERT INTO faleconosco(
                    nome, email, mensagem
                  ) VALUES(
                    :nome, :email, :mensagem
                  )");
        
                $stmt->bindParam(":nome", $fale->nome);
                $stmt->bindParam(":email", $fale->email);
                $stmt->bindParam(":mensagem", $fale->mensagem);

                $stmt->execute();
        
                return true;

            } catch (PDOException $e) {
                // Reverter a transação em caso de erro
                return false;
            }

        }

        public function listar() {

        }

    }