<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
    require_once($BASE_PATH . 'src/Models/Produto.php');
    require_once($BASE_PATH . 'src/Models/Message.php');

    class ProdutoDAO implements ProdutoDAOInterface {

        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url) {
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }

        public function buildProduto($data) {

            $produto = new Produto();
        
            $produto->id = $data["id"];
            $produto->titulo = $data["titulo"];
            $produto->subtitulo = $data["subtitulo"];
            $produto->precoavista = $data["precoavista"];
            $produto->precoparcelado = $data["precoparcelado"];
            $produto->nparcelas = $data["nparcelas"];
            $produto->categoria = $data["categoria"];
            $produto->estoque = $data["estoque"];
            $produto->descricao = $data["descricao"];
            $produto->frete = $data["frete"];
            $produto->data_criacao = $data["data_criacao"]; // Pode ser gerado automaticamente
            $produto->imagens = $data["imagens"]; // Supondo que você passe um array de imagens
            $produto->produtos_comprados = $data["produtos_comprados"];

            return $produto;

        }
        public function create(Produto $produto) {
            try {
                // Iniciar transação
                $this->conn->beginTransaction();
        
                // Inserir os dados do produto
                $stmt = $this->conn->prepare("INSERT INTO produtos(
                    titulo, subtitulo, precoavista, precoparcelado, nparcelas, categoria, estoque, descricao, frete
                  ) VALUES(
                    :titulo, :subtitulo, :precoavista, :precoparcelado, :nparcelas, :categoria, :estoque, :descricao, :frete
                  )");
        
                $stmt->bindParam(":titulo", $produto->titulo);
                $stmt->bindParam(":subtitulo", $produto->subtitulo);
                $stmt->bindParam(":precoavista", $produto->precoavista);
                $stmt->bindParam(":precoparcelado", $produto->precoparcelado);
                $stmt->bindParam(":nparcelas", $produto->nparcelas);
                $stmt->bindParam(":categoria", $produto->categoria);
                $stmt->bindParam(":estoque", $produto->estoque);
                $stmt->bindParam(":descricao", $produto->descricao);
                $stmt->bindParam(":frete", $produto->frete);
        
                $stmt->execute();
        
                // Obter o ID do produto recém-inserido
                $produtoId = $this->conn->lastInsertId();
        
                // Inserir as imagens relacionadas ao produto
                foreach ($produto->imagens as $savedImageName) {
                    $stmt = $this->conn->prepare("INSERT INTO imagens_produto (produto_id, nome_imagem) 
                                                  VALUES (:produto_id, :nome_imagem)");
                
                    $stmt->bindParam(":produto_id", $produtoId);
                    $stmt->bindParam(":nome_imagem", $savedImageName);
                
                    $stmt->execute();
                }
        
                // Confirmar a transação
                $this->conn->commit();
        
                return true;//$produtoId; //esta retornando o id do produto 
        
            } catch (PDOException $e) {
                // Reverter a transação em caso de erro
                $this->conn->rollBack();
                return false;
            }
        }
        

        public function update(Produto $produto) {

        }


        public function getProdutoByCategory($category) {

            $produtos = [];
            $stmt = $this->conn->prepare("
                SELECT p.*, i.nome_imagem AS foto_url 
                FROM produtos p
                LEFT JOIN imagens_produto i ON p.id = i.produto_id 
                WHERE p.categoria = :categoria 
                ORDER BY p.id DESC
            ");
            $stmt->bindParam(":categoria", $category);
            $stmt->execute();
        
            if ($stmt->rowCount() > 0) {
                $produtosArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Agrupar produtos e suas fotos
                $produtosMap = [];
                
                foreach ($produtosArray as $produtoData) {
                    $produtoId = $produtoData['id'];
                
                    if (!isset($produtosMap[$produtoId])) {
                        // Inicializa o array de imagens, incluindo o nome da imagem se existir
                        $produtoData['imagens'] = [];
                
                        // Adiciona a imagem se existir
                        if ($produtoData['foto_url']) {
                            $produtoData['imagens'][] = $produtoData['foto_url'];
                        }
                
                        // Cria o produto e armazena no map
                        $produtosMap[$produtoId] = $this->buildProduto($produtoData);
                    } else {
                        // Se o produto já existir, apenas adiciona a nova imagem
                        if ($produtoData['foto_url']) {
                            $produtosMap[$produtoId]->imagens[] = $produtoData['foto_url'];
                        }
                    }
                }
        
                $produtos = array_values($produtosMap); // Converte de volta para um array numérico
            }
        
            return $produtos;   
        }
            
        
        public function findAll() {

            $produtos = [];
            $stmt = $this->conn->prepare("
                SELECT p.*, i.nome_imagem AS foto_url 
                FROM produtos p
                LEFT JOIN imagens_produto i ON p.id = i.produto_id 
                ORDER BY p.id DESC
            ");
            
            $stmt->execute();
        
            if ($stmt->rowCount() > 0) {
                $produtosArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Agrupar produtos e suas fotos
                $produtosMap = [];
                
                foreach ($produtosArray as $produtoData) {
                    $produtoId = $produtoData['id'];
                
                    if (!isset($produtosMap[$produtoId])) {
                        // Inicializa o array de imagens, incluindo o nome da imagem se existir
                        $produtoData['imagens'] = [];
                
                        // Adiciona a imagem se existir
                        if ($produtoData['foto_url']) {
                            $produtoData['imagens'][] = $produtoData['foto_url'];
                        }
                
                        // Cria o produto e armazena no map
                        $produtosMap[$produtoId] = $this->buildProduto($produtoData);
                    } else {
                        // Se o produto já existir, apenas adiciona a nova imagem
                        if ($produtoData['foto_url']) {
                            $produtosMap[$produtoId]->imagens[] = $produtoData['foto_url'];
                        }
                    }
                }
        
                $produtos = array_values($produtosMap); // Converte de volta para um array numérico
            }
        
            return $produtos;

        }


        public function findbytitle($title) {

            $produtos = [];
            $stmt = $this->conn->prepare("
                SELECT p.*, i.nome_imagem AS foto_url 
                FROM produtos p
                LEFT JOIN imagens_produto i ON p.id = i.produto_id 
                WHERE p.titulo LIKE :titulo 
                ORDER BY p.id DESC
            ");
            $searchTitle = "%" . $title . "%";
            $stmt->bindParam(":titulo", $searchTitle);
            $stmt->execute();
        
            if ($stmt->rowCount() > 0) {
                $produtosArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Agrupar produtos e suas fotos
                $produtosMap = [];
                
                foreach ($produtosArray as $produtoData) {
                    $produtoId = $produtoData['id'];
                
                    if (!isset($produtosMap[$produtoId])) {
                        // Inicializa o array de imagens, incluindo o nome da imagem se existir
                        $produtoData['imagens'] = [];
                
                        // Adiciona a imagem se existir
                        if ($produtoData['foto_url']) {
                            $produtoData['imagens'][] = $produtoData['foto_url'];
                        }
                
                        // Cria o produto e armazena no map
                        $produtosMap[$produtoId] = $this->buildProduto($produtoData);
                    } else {
                        // Se o produto já existir, apenas adiciona a nova imagem
                        if ($produtoData['foto_url']) {
                            $produtosMap[$produtoId]->imagens[] = $produtoData['foto_url'];
                        }
                    }
                }
        
                $produtos = array_values($produtosMap); // Converte de volta para um array numérico
            }
        
            return $produtos;

        }

        public function findbyid($id) {
            $produto = null; // Inicializa como null para o caso de não encontrar o produto
            
            $stmt = $this->conn->prepare("
                SELECT p.*, i.nome_imagem AS foto_url 
                FROM produtos p
                LEFT JOIN imagens_produto i ON p.id = i.produto_id 
                WHERE p.id = :id
            ");
            
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $produtoDataArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Inicializa o produto com imagens
                $produtoMap = null;
                
                foreach ($produtoDataArray as $produtoData) {
                    // Se o produto ainda não foi processado
                    if (!$produtoMap) {
                        // Inicializa o array de imagens, incluindo a imagem se existir
                        $produtoData['imagens'] = [];
                        if ($produtoData['foto_url']) {
                            $produtoData['imagens'][] = $produtoData['foto_url'];
                        }

                        // Cria o produto usando o método buildProduto()
                        $produtoMap = $this->buildProduto($produtoData);
                    } else {
                        // Se o produto já existir, adiciona a imagem ao array de imagens
                        if ($produtoData['foto_url']) {
                            $produtoMap->imagens[] = $produtoData['foto_url'];
                        }
                    }
                }

                // Retorna o produto com todas as imagens
                $produto = $produtoMap;
                }

            return $produto; // Retorna o produto ou null se não for encontrado
        }  



        public function destroy($id) {
            
        }

        public function novacompraproduto($id) {

            try {
                $stmt = $this->conn->prepare("UPDATE produtos SET produtos_comprados = produtos_comprados + 1 WHERE id = :produto_id");
                $stmt->bindParam(':produto_id', $id);
                $stmt->execute();
                
                // Confirmação
                if ($stmt->rowCount() > 0) {
                    return true;
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                // Exibe a mensagem de erro caso ocorra algum problema
                return false;
            }

        }

    }