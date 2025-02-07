<?php

    include_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
    include_once($BASE_PATH . 'config/db.php');
    include_once($BASE_PATH . 'src/Models/Message.php');
    include_once($BASE_PATH . 'src/DAO/UserDAO.php');
    include_once($BASE_PATH . 'src/Models/User.php');

    $message = new Message($BASE_URL);
    $userDao = new UserDAO($conn, $BASE_URL);
    $user = new User();

    //resgata o tipo do formulario
    $type = filter_input(INPUT_POST, "type");

    //atualiza usuario
    if($type === "update") {

        //resgata dados do usuario
        $userData = $userDao->verifyToken();

        //recebe dados post
        $name = filter_input(INPUT_POST, "name");
        $sexo = filter_input(INPUT_POST, "sexo"); 
        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");
        $telefone = filter_input(INPUT_POST, "telefone");
        $cpf = filter_input(INPUT_POST, "cpf");
        $date = filter_input(INPUT_POST, "date");

        $password = filter_input(INPUT_POST, "senhaConf"); //senha

        //preencher dados do usuario
        $userData->name = $name;
        $userData->sexo = $sexo;
        $userData->email = $email;
        $userData->telefone = $telefone;
        $userData->cpf = $cpf;  //talvez ter q mexer
        $userData->birthdate = $date;

        if($userDao->authenticatePassword($email, $password)) {
            //update da imagem
            if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {

                $image = $_FILES["image"];
                $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
                $jpgArray = ["image/jpeg", "image/jpg"];

                //checagem de tipo de image
                if(in_array($image["type"], $imageTypes)) {

                    //checar se é jpg
                    if(in_array($image["type"], $jpgArray)) {

                    $imageFile = imagecreatefromjpeg($image["tmp_name"]);

                    }
                    else { //ver se é png

                        $imageFile = imagecreatefrompng($image["tmp_name"]);

                    }

                    $imageName = $user->imageGenerateName(); 

                    // Caminho completo para salvar a imagem
                    $imagePath = $BASE_PATH . "public/imagens/users/" . $imageName;

                    // Salvar a imagem em alta qualidade
                    imagejpeg($imageFile, $imagePath, 100); // O número é a qualidade, 100 é o máximo

                    $userData->image = $imageName;


                }
                else {
                    $message->setMessage("Tipo inválido de imagem, insira png ou jpg", "error", "back");
                }
            }

            $userDao->update($userData);
        }
        else {
            $message->setMessage("Senha incorreta", "   ", "back");
        }

    }
    else if($type === "delete") {

        //resgata dados do usuario
        $userData = $userDao->verifyToken();

        $userDao->deleteaccont($userData);

    }

    if($type === "createEndereco") {
        //recebe dados post
        $CEP = filter_input(INPUT_POST, "cep");
        $numero = filter_input(INPUT_POST, "num_cep"); 
        $Descricao = filter_input(INPUT_POST, "descricao_cep");

        // URL da API ViaCEP com o CEP especificado
        $url = "https://viacep.com.br/ws/{$CEP}/json/";

        // Verificar se o CEP tem 8 dígitos
        if (strlen($CEP) !== 8) {
            echo "CEP inválido. Deve conter 8 dígitos.";
            return;
        }

        // Fazendo a requisição
        $response = file_get_contents($url);

        // Verificando se a resposta foi bem-sucedida
        if ($response === FALSE) {
            $message->setMessage("Erro ao buscar CEP!", "error", "back");
            return;
        }

        // Decodificando a resposta JSON para um array associativo
        $date = json_decode($response, true);

        // Verificar se o CEP foi encontrado (a API retorna 'erro' se não existir)
        if(isset($date['erro'])) {
            $message->setMessage("CEP inválido!", "error", "back");
        } else {
            // Exibindo os dados do endereço
            $rua = $date['logradouro'];
            $bairro = $date['bairro'];
            $cidade = $date['localidade'];
            $estado = $date['uf'];
        }

        $userData = $userDao->verifyToken();

        $error = $userDao->createEndereco($userData, $CEP, $rua, $bairro, $cidade, $estado, $numero, $Descricao);

        if($error) {
            $message->setMessage("Cadastro de endereço feito com sucesso!", "success", "meuperfil.php");
        } else {
            $message->setMessage("Erro ao cadastrar!", "error", "back");
        }
    }

    else {
        $message->setMessage("Informações invalidas.", "error", "index.php");
    }