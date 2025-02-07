<?php

    include_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
    include_once($BASE_PATH . 'config/db.php');
    include_once($BASE_PATH . 'src/Models/Message.php');
    include_once($BASE_PATH . 'src/DAO/UserDAO.php');
    include_once($BASE_PATH . 'src/Models/User.php');

    $message = new Message($BASE_URL);
    $userDao = new UserDAO($conn, $BASE_URL);
    $user = new User();

    $userData = $userDao->verifyFuncionario(true); //verifica se é funcionario


    $type = filter_input(INPUT_POST, "type");

    if($type === "registroFuncionario") {

        $name = filter_input(INPUT_POST, "name");
        $email = filter_input(INPUT_POST, "email");
        $birthdate = filter_input(INPUT_POST, "date");
        $cpf = filter_input(INPUT_POST, "cpf");
        $password = filter_input(INPUT_POST, "password");
        $user_type = "2"; 

        if($name && $email &&$birthdate && $cpf && $password && $user_type) {

            if($user->databirthday($birthdate)) {

                if($userDao->findByEmail($email) === false) {

                    $cpfLimpo = $user->validarCPF($cpf);
    
                    if($cpfLimpo) {
    
                        /*aqui tem ter um if find by cpf*/
                        if($userDao->findByCPF($cpfLimpo) === false) {
    
                            $userToken = $user->generateToken();
                            $finalPassword = $user->generatePassword($password);
        
                            $user->name = $name;
                            $user->email = $email;
                            $user->birthdate = $birthdate;
                            $user->cpf = $cpfLimpo;
                            $user->password = $finalPassword;
                            $user->token = $userToken;
                            $user->user_type = $user_type;
        
                            $auth = false; 
        
                            $userDao->create($user, $auth);
    
                        }
                        else {
                            $message->setMessage("CPF já cadastrado.", "error", "back");
                        }
                    }
                    else {
                        $message->setMessage("CPF invalido.", "error", "back");
                    }
                }
                else {
                    $message->setMessage("Usuário ja cadastrado, tente outro email.", "error", "back");
                }
            }  
            else {
                $message->setMessage("você precisa ser maior de 14 anos.", "error", "back");
            }
        }
        else {
            $message->setMessage("Preencha todos os campos.", "error", "back");
        }    
    }
    else {
        $message->setMessage("Dados inválidos.", "error", "back");
    }

?>