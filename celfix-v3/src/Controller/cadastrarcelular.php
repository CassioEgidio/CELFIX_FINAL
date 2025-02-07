<?php

    include_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
    include_once($BASE_PATH . 'config/db.php');
    include_once($BASE_PATH . 'src/Models/Message.php');
    include_once($BASE_PATH . 'src/DAO/AparelhoDAO.php');
    include_once($BASE_PATH . 'src/Models/Aparelho.php');

    $message = new Message($BASE_URL);
    $aparelhoDao = new AparelhoDAO($conn, $BASE_URL);
    $aparelho = new Aparelho();

    //resgata o tipo do formulario
    $type = filter_input(INPUT_POST, "type");

    if($type === "createcelular") {

        //receber dados do post
        $categoria = filter_input(INPUT_POST, "categoria");
        $subtitulo = filter_input(INPUT_POST, "subtitulo");
       

        if($categoria && $subtitulo) {

            //preencher dados do aparelho
            $aparelho->Marca = $categoria;
            $aparelho->Descricao = $subtitulo;
            

            if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] == 0) {
                $image = [
                    "tmp_name" => $_FILES["imagem"]["tmp_name"],  // Acesso direto ao array sem [0]
                    "type" => $_FILES["imagem"]["type"],
                    "name" => $_FILES["imagem"]["name"]
                ];
                
                $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
                $jpgArray = ["image/jpeg", "image/jpg"];
            
                // Checagem de tipo de imagem
                if (in_array($image["type"], $imageTypes)) {
                    
                    // Verifica se é JPG
                    if (in_array($image["type"], $jpgArray)) {
                        $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                    } else { // Se não, verifica se é PNG
                        $imageFile = imagecreatefrompng($image["tmp_name"]);
                    }
            
                    // Usa o nome original da imagem para salvar
                    $imageName = $image["name"];
                    
                    // Caminho completo para salvar a imagem
                    $imagePath = $BASE_PATH . "public/imagens/aparelhos/" . $imageName;  //criar a pasta
            
                    // Salvar a imagem em alta qualidade
                    imagejpeg($imageFile, $imagePath, 100); // O número é a qualidade, 100 é o máximo
            
                    // Adiciona o nome da imagem ao array de imagens para o banco de dados
                    $aparelho->image_aparelho = $imageName;
            
                    // Libera a memória associada à imagem
                    imagedestroy($imageFile);
                } else {
                    // Tratar erro de tipo de imagem, se necessário
                    $message->setMessage("Tipo de imagem não suportado.", "error", "back");
                }
            } else {
                $message->setMessage("Nenhuma imagem foi enviada.", "error", "back");
            }
            
            $pro = $aparelhoDao->create($aparelho);

            if($pro) {
                $message->setMessage("Celular cadastrado.", "success", "back");
                exit();
            }
            else {
                $message->setMessage("Erro ao cadastrar celular.", "error", "back");
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