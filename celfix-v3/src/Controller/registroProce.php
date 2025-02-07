<?php

    include_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
    include_once($BASE_PATH . 'config/db.php');
    include_once($BASE_PATH . 'src/Models/Message.php');
    include_once($BASE_PATH . 'src/DAO/UserDAO.php');
    include_once($BASE_PATH . 'src/Models/User.php');

    $message = new Message($BASE_URL);
    $userDao = new UserDAO($conn, $BASE_URL);
    $user = new User();

    $type = filter_input(INPUT_POST, "type");

    if($type === "register") {

        $name = filter_input(INPUT_POST, "name");
        $email = filter_input(INPUT_POST, "email");
        $birthdate = filter_input(INPUT_POST, "date");
        $cpf = filter_input(INPUT_POST, "cpf");
        $password = filter_input(INPUT_POST, "password");
        $user_type = "1"; 

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
                            $user->birthdate = $birthdate; //ver
                            $user->cpf = $cpfLimpo;
                            $user->password = $finalPassword;
                            $user->token = $userToken;
                            $user->user_type = $user_type;
        
                            $auth = true; 
        
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
    else if($type === "login") {

        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");
    
        if($userDao->authenticateUser($email, $password)) {
                
            $message->setMessage("Seja bem vindo!", "success", "index.php");
    
        }
        else { 
            $message->setMessage("Usuario e/ou senha incorretos.", "error", "back");
        }
    
    }
    else {
        $message->setMessage("Informações invalidas.", "error", "index.php");
    }
        
