<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
    require_once($BASE_PATH . 'src/Models/PagamentoProduto.php');
    require_once($BASE_PATH . 'src/Models/Message.php');

    class PagamentoProdutoDAO implements PagamentoProdutoDAOInterface {

        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url) {
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }

        public function buildPagamento($data) {

            $pagamentoProduto = new PagamentoProduto();
        
            $pagamentoProduto->id_compra = $data["id_compra"];
            $pagamentoProduto->id_usuario = $data["id_usuario"];
            $pagamentoProduto->id_produto = $data["id_produto"];
            $pagamentoProduto->id_endereco = $data["id_endereco"];
            $pagamentoProduto->Status = $data["Status"];
            $pagamentoProduto->preco_total = $data["preco_total"];
            $pagamentoProduto->tipo_pagamento = $data["tipo_pagamento"];
            $pagamentoProduto->n_parcelas = $data["n_parcelas"];
            $pagamentoProduto->qtde_pecas_compradas = $data["qtde_pecas_compradas"];
            $pagamentoProduto->data_entrega = $data["data_entrega"];
            $pagamentoProduto->data_compra = $data["data_compra"];
           
            return $pagamentoProduto;

        }

        public function create(PagamentoProduto $pagamento) {

            try {

                $stmt = $this->conn->prepare("INSERT INTO compra(
                    id_produto, id_usuario, id_endereco, Status, preco_total, tipo_pagamento, n_parcelas, qtde_pecas_compradas, data_entrega	
                  ) VALUES(
                    :id_produto, :id_usuario, :id_endereco, :Status, :preco_total, :tipo_pagamento ,:n_parcelas, :qtde_pecas_compradas, :data_entrega
                  )");//esta totalmente errado
    
              $stmt->bindParam(":id_produto", $pagamento->id_produto);
              $stmt->bindParam(":id_usuario", $pagamento->id_usuario);
              $stmt->bindParam(":id_endereco", $pagamento->id_endereco);
              $stmt->bindParam(":preco_total", $pagamento->preco_total);
              $stmt->bindParam(":Status", $pagamento->Status);
              $stmt->bindParam(":tipo_pagamento", $pagamento->tipo_pagamento);
              $stmt->bindParam(":n_parcelas", $pagamento->n_parcelas);
              $stmt->bindParam(":qtde_pecas_compradas", $pagamento->qtde_pecas_compradas);
              $stmt->bindParam(":data_entrega", $pagamento->data_entrega);
            
              $stmt->execute();

              return true;

            }
            catch (PDOException $e) {

                return false;

            }

        }
        public function listarProtocolosporcliente($id) {

            $produto = null; // Inicializa como null para o caso de não encontrar o produto

            $stmt = $this->conn->prepare("
                SELECT c.*, p.*, u.*, i.nome_imagem AS foto_url
                FROM compra c
                JOIN produtos p ON c.id_produto = p.id
                LEFT JOIN imagens_produto i ON p.id = i.produto_id
                LEFT JOIN users u ON c.id_usuario = u.id
                WHERE c.id_usuario = :usuario_id
                ORDER BY c.id_compra DESC
            ");

            $stmt->bindParam(":usuario_id", $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $produtoDataArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Array para armazenar os dados da compra com os produtos e suas imagens
                $compras = [];
                
                foreach ($produtoDataArray as $produtoData) {
                    // Inicializa um array para a compra
                    $compraData = (object) $produtoData;
                    
                    // Se a compra ainda não tiver sido adicionada, inicializa o array de imagens
                    if (!isset($compras[$compraData->id_compra])) {
                        $compraData->imagens = [];
                        if ($compraData->foto_url) {
                            $compraData->imagens[] = $compraData->foto_url;
                        }
                        // Adiciona a compra ao array de compras
                        $compras[$compraData->id_compra] = $compraData;
                    } else {
                        // Se a compra já existir, apenas adiciona a nova imagem
                        if ($compraData->foto_url) {
                            $compras[$compraData->id_compra]->imagens[] = $compraData->foto_url;
                        }
                    }
                }

                // Retorna todas as compras com seus respectivos produtos e imagens
                $produto = array_values($compras); // Retorna como um array de compras
            }

            return $produto;

        }

        public function listarProtocolosporaadm() {

            $produto = null; // Inicializa como null para o caso de não encontrar o produto

            $stmt = $this->conn->prepare("
                SELECT c.*, p.*, i.nome_imagem AS foto_url, u.id AS usuario_id, u.name AS usuario_nome, u.email AS usuario_email
                FROM compra c
                JOIN produtos p ON c.id_produto = p.id
                LEFT JOIN imagens_produto i ON p.id = i.produto_id
                JOIN users u ON c.id_usuario = u.id
                ORDER BY c.id_compra DESC
            ");

            $stmt->execute();

            
            if ($stmt->rowCount() > 0) {
                $produtoDataArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Array para armazenar os dados da compra com os produtos, imagens e dados do usuário
                $compras = [];
                
                foreach ($produtoDataArray as $produtoData) {
                    // Inicializa um array para a compra
                    $compraData = (object) $produtoData;
                    
                    // Se a compra ainda não tiver sido adicionada, inicializa o array de imagens
                    if (!isset($compras[$compraData->id_compra])) {
                        $compraData->imagens = [];
                        if ($compraData->foto_url) {
                            $compraData->imagens[] = $compraData->foto_url;
                        }
                        
                        // Inclui os dados do usuário
                        $compraData->usuario_id = $produtoData['usuario_id'];
                        $compraData->usuario_nome = $produtoData['usuario_nome'];
                        $compraData->usuario_email = $produtoData['usuario_email'];
                        
                        // Adiciona a compra ao array de compras
                        $compras[$compraData->id_compra] = $compraData;
                    } else {
                        // Se a compra já existir, apenas adiciona a nova imagem
                        if ($compraData->foto_url) {
                            $compras[$compraData->id_compra]->imagens[] = $compraData->foto_url;
                        }
                    }
                }
            
                // Retorna todas as compras com seus respectivos produtos, imagens e dados do usuário
                $produto = array_values($compras); // Retorna como um array de compras
            }
            
            return $produto;
            
        }

        public function AtualizarStatus($Status, $ID_Compra) {
            try {
                $stmt = $this->conn->prepare("UPDATE compra SET Status = :Status WHERE id_compra = :id_compra");
                
                $stmt->bindParam(":Status", $Status);
                $stmt->bindParam(":id_compra", $ID_Compra);
                
                $stmt->execute();
        
                return true;
                
            } catch(PDOException $e) {
                return false;
            }
        }
    }