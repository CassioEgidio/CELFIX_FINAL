<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
    require_once($BASE_PATH . 'src/Models/Endereco.php');
    require_once($BASE_PATH . 'src/Models/Message.php');

    class EnderecoDAO implements EnderecoDAOInterface {

        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url) {
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }
      
        public function buildEndereco($data) {

            $endereco = new Endereco();

            $endereco->ID_Endereco = $data["ID_Endereco"];
            $endereco->ID_User = $data["ID_User"];
            $endereco->CEP = $data["CEP"];
            $endereco->rua = $data["rua"];
            $endereco->bairro = $data["bairro"];
            $endereco->cidade = $data["cidade"];
            $endereco->estado = $data["estado"];
            $endereco->numero = $data["numero"];
            $endereco->Descricao = $data["Descricao"];

            return $endereco;
        }
        
        public function findByToken($userData) {

            // Corrigindo a consulta SQL para filtrar pelos endereços do usuário com ID_User
            $stmt = $this->conn->prepare("
                SELECT * 
                FROM endereco 
                WHERE ID_User = :ID_User
            ");
            $stmt->bindParam(":ID_User", $userData);
        
            $stmt->execute();
        
            // Verifica se há resultados na consulta
            if($stmt->rowCount() > 0) {
        
                $data = $stmt->fetchAll(); // Pega todos os resultados
                $enderecos = [];
        
                // Cria um objeto Endereco para cada linha de dados retornados
                foreach ($data as $enderecoData) {
                    $enderecos[] = $this->buildEndereco($enderecoData);
                }
        
                return $enderecos; // Retorna um array com os objetos Endereco
            }
            else {
                return false; // Retorna falso se não houver resultados
            }
        }
    }