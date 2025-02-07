<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
    require_once($BASE_PATH . 'src/Models/Conserto.php');
    require_once($BASE_PATH . 'src/Models/Message.php');

    class ConsertoDAO implements ConsertoDAOInterface {

        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url) {
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }

        public function buildConserto($data) {

            $conserto = new Conserto();
        
            $conserto->id_Concerto = $data["id_Concerto"];
            $conserto->id_User = $data["id_User"];
            $conserto->id_aparelho = $data["id_aparelho"];
            $conserto->Descricao = $data["Descricao"];
            $conserto->Nome = $data["Nome"];
            $conserto->CPF = $data["CPF"];
            $conserto->Nota_Fiscal = $data["Nota_Fiscal"];
            $conserto->Garantia = $data["Garantia"];
            $conserto->Atualizacoes = $data["Atualizacoes"];
            $conserto->Apagar = $data["Apagar"];
            $conserto->Telefone = $data["Telefone"];
            $conserto->Termos = $data["Termos"];
            $conserto->status = $data["status"];
            $conserto->PrecoPeca = $data["PrecoPeca"];
            $conserto->MetodoPagamento = $data["MetodoPagamento"];
            $conserto->Parcelas = $data["Parcelas"];
            $conserto->GarantiaExtendida = $data["GarantiaExtendida"];
            $conserto->PrecoTotal = $data["PrecoTotal"];
           
            return $conserto;

        }
        public function create(Conserto $conserto) {
            try {        
                // Inserir os dados do conserto
                $stmt = $this->conn->prepare("INSERT INTO concerto(
                    id_User, id_aparelho, Descricao, Nome, CPF, Nota_Fiscal, Garantia, Atualizacoes, Apagar, Telefone, Termos
                  ) VALUES(
                    :id_User, :id_aparelho, :Descricao, :Nome, :CPF, :Nota_Fiscal, :Garantia, :Atualizacoes, :Apagar, :Telefone, :Termos
                  )");
        
                $stmt->bindParam(":id_User", $conserto->id_User);
                $stmt->bindParam(":id_aparelho", $conserto->id_aparelho);
                $stmt->bindParam(":Descricao", $conserto->Descricao);
                $stmt->bindParam(":Nome", $conserto->Nome);
                $stmt->bindParam(":CPF", $conserto->CPF);
                $stmt->bindParam(":Nota_Fiscal", $conserto->Nota_Fiscal);
                $stmt->bindParam(":Garantia", $conserto->Garantia);
                $stmt->bindParam(":Atualizacoes", $conserto->Atualizacoes);
                $stmt->bindParam(":Apagar", $conserto->Apagar);
                $stmt->bindParam(":Telefone", $conserto->Telefone);
                $stmt->bindParam(":Termos", $conserto->Termos);

                $stmt->execute();
        
                return true;

            } catch (PDOException $e) {
                return false;
            }
        }

        public function protocolocliente($id) {

            $stmt = $this->conn->prepare("
                SELECT c.*, a.image_aparelho
                FROM concerto c
                JOIN aparelho a ON c.id_aparelho = a.id_aparelho  -- corrigido o campo para 'id_aparelho'
                WHERE c.id_User = :usuario_id
                ORDER BY c.id_Concerto DESC
            ");
        
            $stmt->bindParam(":usuario_id", $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $concertoDataArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Array para armazenar os dados do concerto com os aparelhos e suas imagens
                $concertos = [];
                
                foreach ($concertoDataArray as $concertoData) {
                    // Inicializa um array para o concerto
                    $concertoDataObj = (object) $concertoData;
                    
                    // Se o concerto ainda não tiver sido adicionado, inicializa o array de imagens
                    if (!isset($concertos[$concertoDataObj->id_Concerto])) {
                        $concertoDataObj->imagens = [];
                        if ($concertoDataObj->image_aparelho) {
                            $concertoDataObj->imagens[] = $concertoDataObj->image_aparelho;
                        }
                        // Adiciona o concerto ao array de concertos
                        $concertos[$concertoDataObj->id_Concerto] = $concertoDataObj;
                    } else {
                        // Se o concerto já existir, apenas adiciona a nova imagem
                        if ($concertoDataObj->image_aparelho) {
                            $concertos[$concertoDataObj->id_concerto]->imagens[] = $concertoDataObj->image_aparelho;
                        }
                    }
                }
            
                // Retorna todos os concertos com seus respectivos aparelhos e imagens
                $concerto = array_values($concertos); // Retorna como um array de concertos
            }
            
            return $concerto;
        }

        public function protocoloByID($id) {

            $stmt = $this->conn->prepare("
                SELECT *
                FROM concerto
                WHERE id_Concerto = :id_Concerto
                ORDER BY id_Concerto DESC
            ");
        
            $stmt->bindParam(":id_Concerto", $id);
            $stmt->execute();
                
            if($stmt->rowCount() > 0) {
    
                $data = $stmt->fetchAll();
                $concerto = [];
        
                foreach ($data as $concertoData) {
                    $concerto[] = $this->buildConserto($concertoData);
                }
        
                return $concerto;
            }
            else {
                return false;
            }
        }
    }