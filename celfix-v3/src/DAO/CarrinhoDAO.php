<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
    require_once($BASE_PATH . 'src/Models/Carrinho.php');
    require_once($BASE_PATH . 'src/Models/Message.php');

    class CarrinhoDAO implements CarrinhoDAOInterface {

        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url) {
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }
      
        public function buildCarrinho($data) {

            $carrinho = new Carrinho();

            $carrinho->id_Carrinho = $data["id_Carrinho"];
            $carrinho->Id_User = $data["Id_User"];
            $carrinho->Id_Prod = $data["Id_Prod"];
        
            return $carrinho;
        }

        public function create($id_user, $id_produto) {

            try{

                $stmt = $this->conn->prepare("INSERT INTO carrinho(
                    id_User, id_Prod
                ) VALUES(
                    :id_User, :id_Prod
                )");

                $stmt->bindParam(":id_User", $id_user);          
                $stmt->bindParam(":id_Prod", $id_produto);
                $stmt->execute();

                return true;


            } catch (PDOException $e) {
                return false;
            }   
        }

        /*public function findcarrinhoporid($user_id) {
            if($user_id != "") {

                $carrinho = [];

                $stmt = $this->conn->prepare("SELECT * FROM Carrinho WHERE id_User = :id_User");
                $stmt->bindParam(":id_User", $user_id);

                $stmt->execute();

                if($stmt->rowCount() > 0) {

                    $carrinhos = $stmt->fetchAll();
    
                    foreach($carrinhos as $carrinho) {
                        $carrinho[] = $this->buildCarrinho($carrinho);
                    }
                }
    
                return $carrinho;
               
            }
            else {
                return false;
            }
        }*/
        public function findCarrinhoPorId($user_id) {
            $carrinho = null; // Inicializa como null para o caso de não encontrar registros
        
            $stmt = $this->conn->prepare("
                SELECT 
                    c.id_Carrinho,
                    c.Id_User,
                    c.Id_Prod,
                    p.titulo,
                    p.subtitulo,
                    p.precoavista,
                    p.precoparcelado,
                    p.nparcelas,
                    p.categoria,
                    p.estoque,
                    p.descricao,
                    p.frete,
                    i.nome_imagem AS foto_url
                FROM 
                    carrinho c
                JOIN 
                    produtos p ON c.Id_Prod = p.id
                LEFT JOIN 
                    imagens_produto i ON p.id = i.produto_id
                WHERE 
                    c.Id_User = :user_id
                ORDER BY 
                    c.id_Carrinho DESC
            ");
        
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();
        
            if ($stmt->rowCount() > 0) {
                $produtoDataArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
                // Array para armazenar os dados do carrinho com os produtos e suas imagens
                $carrinhos = [];
        
                foreach ($produtoDataArray as $produtoData) {
                    // Inicializa um objeto para o carrinho
                    $carrinhoData = (object) $produtoData;
        
                    // Se o carrinho ainda não tiver sido adicionado, inicializa o array de imagens
                    if (!isset($carrinhos[$carrinhoData->id_Carrinho])) {
                        $carrinhoData->imagens = [];
                        if ($carrinhoData->foto_url) {
                            $carrinhoData->imagens[] = $carrinhoData->foto_url;
                        }
                        // Adiciona o carrinho ao array de carrinhos
                        $carrinhos[$carrinhoData->id_Carrinho] = $carrinhoData;
                    } else {
                        // Se o carrinho já existir, apenas adiciona a nova imagem
                        if ($carrinhoData->foto_url) {
                            $carrinhos[$carrinhoData->id_Carrinho]->imagens[] = $carrinhoData->foto_url;
                        }
                    }
                }
        
                // Retorna todos os carrinhos com seus respectivos produtos e imagens
                $carrinho = array_values($carrinhos); // Converte o array associativo em um array indexado
            }
        
            return $carrinho;
        }
        
        public function deleteCarrinho($id_carrinho) {
            try {
                // Prepara a query para deletar o item do carrinho
                $stmt = $this->conn->prepare("
                    DELETE FROM 
                        Carrinho
                    WHERE 
                        id_Carrinho = :id_carrinho
                ");
        
                // Associa o valor do parâmetro
                $stmt->bindParam(":id_carrinho", $id_carrinho);
        
                // Executa a consulta
                $stmt->execute();
        
                // Retorna verdadeiro se a exclusão afetou uma ou mais linhas
                return true;
            } catch (PDOException $e) {
                // Captura e exibe erros em caso de falha
                return false;
            }
        }
        
        
    }