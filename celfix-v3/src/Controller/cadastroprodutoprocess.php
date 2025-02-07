<?php

    include_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
    include_once($BASE_PATH . 'config/db.php');
    include_once($BASE_PATH . 'src/Models/Message.php');
    include_once($BASE_PATH . 'src/DAO/ProdutoDAO.php');
    include_once($BASE_PATH . 'src/Models/Produto.php');

    $message = new Message($BASE_URL);
    $produtoDao = new ProdutoDAO($conn, $BASE_URL);
    $produto = new Produto();

    //resgata o tipo do formulario
    $type = filter_input(INPUT_POST, "type");

    if($type === "createproduto") {

        //receber dados do post
        $titulo = filter_input(INPUT_POST, "titulo");
        $subtitulo = filter_input(INPUT_POST, "subtitulo");
        $precoavista = filter_input(INPUT_POST, "precoavista");
        $precoparcelado = filter_input(INPUT_POST, "precoparcelado");
        $nparcelas = filter_input(INPUT_POST, "nparcelas");
        $categoria = filter_input(INPUT_POST, "categoria"); //check box
        $estoque = filter_input(INPUT_POST, "estoque");
        $descricao = filter_input(INPUT_POST, "descricao");
        $frete = filter_input(INPUT_POST, "frete"); //vendo

        if(isset($titulo) && isset($subtitulo) && isset($precoavista) && isset($precoparcelado) && isset($nparcelas) && isset($categoria) && isset($estoque) && isset($descricao) && isset($frete)) {

            //preencher dados do produto
            $produto->titulo = $titulo;
            $produto->subtitulo = $subtitulo;
            $produto->precoavista = $precoavista;
            $produto->precoparcelado = $precoparcelado;
            $produto->nparcelas = $nparcelas;
            $produto->categoria = $categoria;
            $produto->estoque = $estoque;
            $produto->descricao = $descricao;
            $produto->frete = $frete;

           // Verifica se existem imagens enviadas e se não estão vazias
            if (isset($_FILES["imagens"]) && !empty($_FILES["imagens"]["tmp_name"][0])) {
                
                $images = $_FILES["imagens"];
                $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
                $jpgArray = ["image/jpeg", "image/jpg"];
                $uploadedImagesCount = 0; // Contador de imagens válidas

                // Loop através de cada imagem enviada
                for ($i = 0; $i < count($images["tmp_name"]); $i++) {
                    // Checa se a imagem atual não está vazia
                    if (!empty($images["tmp_name"][$i])) {
                        $image = [
                            "tmp_name" => $images["tmp_name"][$i],
                            "type" => $images["type"][$i]
                        ];

                        // Checagem de tipo de imagem
                        if (in_array($image["type"], $imageTypes)) {
                            // Verifica se é JPG
                            if (in_array($image["type"], $jpgArray)) {
                                $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                            } else { // Se não, verifica se é PNG
                                $imageFile = imagecreatefrompng($image["tmp_name"]);
                            }

                            // Gera um nome único para a imagem
                            $imageName = $produto->imageGenerateName(); 
                            
                            // Caminho completo para salvar a imagem
                            $imagePath = $BASE_PATH . "public/imagens/produtos/" . $imageName;

                            // Salvar a imagem em alta qualidade
                            imagejpeg($imageFile, $imagePath, 100); // O número é a qualidade, 100 é o máximo

                            // Adiciona o nome da imagem ao array de imagens para o banco de dados
                            $produto->imagens[] = $imageName;

                            // Incrementa o contador de imagens válidas
                            $uploadedImagesCount++;

                            // Libera a memória associada à imagem
                            imagedestroy($imageFile);
                        }
                        else {
                            // Tratar erro de tipo de imagem, se necessário
                            $message->setMessage("Tipo de imagem não suportado.", "error", "back");
                        }
                    }
                }

                // Verifica se o número de imagens válidas é igual a 5
                if ($uploadedImagesCount !== 5) {
                    $message->setMessage("Você deve enviar exatamente 5 imagens.", "error", "back");
                    exit();
                }
            }

            $pro = $produtoDao->create($produto);

            if($pro) {
                $message->setMessage("Produto cadastrado.", "success", "back");
                exit();
            }
            else {
                $message->setMessage("Erro ao cadastrar produto.", "error", "back");
                exit();
            }

        }
        else {
            $message->setMessage("Preencha todos os campos.", "error", "back");
        }

    }