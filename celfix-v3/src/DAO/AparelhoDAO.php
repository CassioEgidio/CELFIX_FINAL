<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
    require_once($BASE_PATH . 'src/Models/Aparelho.php');
    require_once($BASE_PATH . 'src/Models/Message.php');

    class AparelhoDAO implements AparelhoDAOInterface {

        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url) {
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }

        public function buildAparelho($data) {

            $aparelho = new Aparelho();
        
            $aparelho->id_aparelho = $data["id_aparelho"];
            $aparelho->Descricao = $data["Descricao"];
            $aparelho->Marca = $data["Marca"];
            $aparelho->image_aparelho = $data["image_aparelho"];

           
            return $aparelho;

        }
        public function create(Aparelho $aparelho) {
            try {        
                // Inserir os dados do produto
                $stmt = $this->conn->prepare("INSERT INTO aparelho(
                    Descricao, Marca, image_aparelho
                  ) VALUES(
                    :Descricao, :Marca, :image_aparelho
                  )");
        
                $stmt->bindParam(":Descricao", $aparelho->Descricao);
                $stmt->bindParam(":Marca", $aparelho->Marca);
                $stmt->bindParam(":image_aparelho", $aparelho->image_aparelho);

                $stmt->execute();
        
                return true;

            } catch (PDOException $e) {
                // Reverter a transação em caso de erro
                return false;
            }
        }

        public function findAll() {
            $aparelhos = [];
            $stmt = $this->conn->query("SELECT * FROM aparelho ORDER BY id_aparelho DESC");
            $stmt->execute();

            if($stmt->rowCount() > 0) {

                $aparelhosArray = $stmt->fetchAll();

                foreach($aparelhosArray as $aparelho) {
                    $aparelhos[] = $this->buildAparelho($aparelho);
                }
            }

            return $aparelhos;
        }
    }