<?php

    require_once($_SERVER['DOCUMENT_ROOT'] . '/filegator/repository/GrupoCelfix/celfix-v3/config/globals.php');
    require_once($BASE_PATH . 'src/Models/User.php');
    require_once($BASE_PATH . 'src/Models/Message.php');

    class UserDAO implements UserDAOInterface {

        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url) {
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }
      
        public function buildUser($data) {

            $user = new User();
            
            $user->id = $data["id"];
            $user->name = $data["name"];
            $user->email = $data["email"];
            $user->cpf = $data["cpf"];
            $user->birthdate = $data["birthdate"];
            $user->password = $data["password"];
            $user->image = $data["image"];
            $user->token = $data["token"];
            $user->user_type = $data["user_type"];

            //novo

            $user->telefone = $data["telefone"];
            $user->sexo = $data["sexo"];
            
            return $user;

        }

        public function create(User $user, $authUser = false) {

            $stmt = $this->conn->prepare("INSERT INTO users(
                  name, email, cpf, birthdate, password, token, user_type, telefone, sexo
                ) VALUES(
                  :name, :email, :cpf, :birthdate ,:password, :token, :user_type, :telefone, :sexo
                )");

            $stmt->bindParam(":name", $user->name);          
            $stmt->bindParam(":email", $user->email);
            $stmt->bindParam(":cpf", $user->cpf);
            $stmt->bindParam(":birthdate", $user->birthdate);
            $stmt->bindParam(":password", $user->password);
            $stmt->bindParam(":token", $user->token);
            $stmt->bindParam(":user_type", $user->user_type);

            //novo

            $stmt->bindParam(":telefone", $user->telefone);
            $stmt->bindParam(":sexo", $user->sexo);


            $stmt->execute();

            //autenticar usuario caso auth seja true
            if($authUser) {
                $this->setTokenToSession($user->token);
            }
            else {
                $this->message->setMessage("Sucesso ao cadastrar o novo funcionário.", "success", "back");
            }
        }

        public function update(User $user, $redirect = true) { //estou mexendo

            $stmt = $this->conn->prepare("UPDATE users SET
                name = :name,
                email = :email,
                cpf = :cpf,
                birthdate = :birthdate,
                image = :image,
                token = :token,
                telefone = :telefone,
                sexo = :sexo

                WHERE id = :id
            "); //parei no token

            $stmt->bindParam(":name", $user->name);
            $stmt->bindParam(":email", $user->email);
            $stmt->bindParam(":cpf", $user->cpf);
            $stmt->bindParam(":birthdate", $user->birthdate);
            $stmt->bindParam(":image", $user->image);
            $stmt->bindParam(":token", $user->token);
            $stmt->bindParam(":telefone", $user->telefone);
            $stmt->bindParam(":sexo", $user->sexo);
            $stmt->bindParam(":id", $user->id);

            $stmt->execute();

            if($redirect) {

                //redireciona para o perfil do usuario
                $this->message->setMessage("Dados atualizados com sucesso!", "success", "meuperfil.php");

            }

        }

        public function verifyToken($protected = false) {  //aparentemente pegando

            if (!empty($_SESSION["token"])) {
                // Pega o token da sessão
                $token = $_SESSION["token"];
                $user = $this->findByToken($token);
        
                if ($user) {
                    return $user;
                } else if ($protected) {
                    // Redireciona usuário não autenticado
                    $this->message->setMessage("Faça a autenticação para acessar esta página!", "error", "login.php");
                    exit();
                }
            } elseif (isset($_COOKIE["login_token"])) {
                // Se a sessão expirou, mas o cookie existe
                $token = $_COOKIE["login_token"];
                $user = $this->findByToken($token);
        
                if ($user) {
                    // Recria a sessão
                    $_SESSION["token"] = $token;
                    $_SESSION["loggedin"] = true;
        
                    return $user;
                } else if ($protected) {
                    // Token inválido no cookie, redireciona usuário não autenticado
                    $this->message->setMessage("Faça a autenticação para acessar esta página!", "error", "index.php");
                    exit();
                }
            } elseif ($protected) {
                // Sem sessão e sem cookie, redireciona usuário não autenticado
                $this->message->setMessage("Faça a autenticação para acessar esta página!", "error", "index.php");
                exit();
            }
        }
        
        
        public function verifyFuncionario($protected = false) {
            if (!empty($_SESSION["token"])) {
                // Pega o token da sessão
                $token = $_SESSION["token"];
                $user = $this->findByToken($token);
        
                if ($user) {
                    if ($user->user_type === 2) {
                        return $user; // Usuário é administrador
                    } else {
                        // Usuário não é administrador
                        $this->message->setMessage("Você precisa ser um administrador para acessar esta página!", "error", "index.php");
                        exit();
                    }
                } else if ($protected) {
                    // Redireciona usuário não autenticado
                    $this->message->setMessage("Faça a autenticação para acessar esta página!", "error", "index.php");
                    exit();
                }
            } elseif (isset($_COOKIE["login_token"])) {
                // Se a sessão expirou, mas o cookie existe
                $token = $_COOKIE["login_token"];
                $user = $this->findByToken($token);
        
                if ($user) {
                    if ($user->user_type === 2) {
                        // Recria a sessão para administradores
                        $_SESSION["token"] = $token;
                        $_SESSION["loggedin"] = true;
        
                        return $user; // Usuário é administrador
                    } else {
                        // Usuário não é administrador
                        $this->message->setMessage("Você precisa ser um administrador para acessar esta página!", "error", "index.php");
                        exit();
                    }
                } else if ($protected) {
                    // Token inválido no cookie
                    $this->message->setMessage("Faça a autenticação para acessar esta página!", "error", "index.php");
                    exit();
                }
            } elseif ($protected) {
                // Sem sessão e sem cookie, redireciona usuário não autenticado
                $this->message->setMessage("Faça a autenticação para acessar esta página!", "error", "index.php");
                exit();
            }
        }
        

        public function setTokenToSession($token, $redirect = true) {

            // Cria o cookie
            $user = new User();
            setcookie('login_token', $token, $user->timecookie(), "/", "", false, true); //isso é novo

            //salvat token na session
            $_SESSION["token"] = $token;
            $_SESSION["loggedin"] = true;

            if($redirect) {

                //redireciona para o perfil do usuario
                $this->message->setMessage("seja bem vindo!", "success", "index.php");

            }

        }

        public function authenticateUser($email, $password) {

            $user = $this->findByEmail($email);

            if($user) {
                 //checar se as senhas batem
                 if(password_verify($password, $user->password)) {

                    //gerar um token e inserir na session
                    $token = $user->generateToken();

                    $this->setTokenToSession($token, false);

                    //atualizar token no usuario
                    $user->token = $token;

                    $this->update($user, false);

                    $_SESSION["loggedin"] = true;

                    return true;
                }
                else {
                    return false;
                }

            }
            else {

                $var = $this->contadeleteda($email);

                if($var) {
                    $this->message->setMessage("Conta banida ou deletada!", "error", "back");
                    exit();
                }
                else {
                    return false;
                }
            }
        }

        public function authenticatePassword($email, $password) {

            $user = $this->findByEmail($email);

            if($user) {
                if(password_verify($password, $user->password)) {
                    return true;
                }
                else {
                    return false;
                }
            }
            else {
                return false; //não conseguiu autenticar
            }
        }


        public function findByEmail($email) {

            if($email != "") {

                $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email AND is_deleted = FALSE");
                $stmt->bindParam(":email", $email);

                $stmt->execute();

                if($stmt->rowCount() > 0) {

                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);

                    return $user;
                }
                else {
                    //procegue para o cadastro
                    return false;
                }
            }
            else {
                return false;
            }

        }

        public function findByCPF($cpf) {

            if($cpf != "") {

                $stmt = $this->conn->prepare("SELECT * FROM users WHERE cpf = :cpf AND is_deleted = FALSE");
                $stmt->bindParam(":cpf", $cpf);

                $stmt->execute();

                if($stmt->rowCount() > 0) {

                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);

                    return $user;
                }
                else {
                    //procegue para o cadastro
                    return false;
                }
            }
            else {
                return false;
            }
        }


        public function findById($id) {

            if($id != "") {

                $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id AND is_deleted = FALSE");
                $stmt->bindParam(":id", $id);

                $stmt->execute();

                if($stmt->rowCount() > 0) {

                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);

                    return $user;
                }
                else {
                    //procegue para o cadastro
                    return false;
                }
            }
            else {
                return false;
            }

        }

        public function findByToken($token) {

            if($token != "") {

                $stmt = $this->conn->prepare("
                    SELECT users.*, endereco.* 
                    FROM users 
                    LEFT JOIN endereco ON endereco.ID_User = users.id 
                    WHERE users.token = :token AND users.is_deleted = FALSE
                ");
                $stmt->bindParam(":token", $token);

                $stmt->execute();

                if($stmt->rowCount() > 0) {

                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);

                    return $user;
                }
                else {
                    //procegue para o cadastro
                    return false;
                }
            }
            else {
                return false;
            }

        }

        public function destroyToken() {

            // Apaga o cookie
            setcookie('login_token', '', time() - 3600, "/"); //isso é novo

            //remove token da session
            $_SESSION["token"] = "";
            $_SESSION["loggedin"] = "";

            //redireciona e apresenta a imagem de sucesso
            $this->message->setMessage("Voce fez o logout com sucesso!", "success", "index.php");
        }

        public function destroySessao() {

            // Apaga o cookie
            setcookie('login_token', '', time() - 3600, "/"); //isso é novo

            //remove token da session
            $_SESSION["token"] = "";
            $_SESSION["loggedin"] = "";

            //redireciona e apresenta a imagem de sucesso
            $this->message->setMessage("Voce excluiu sua conta com sucesso!", "success", "index.php");
        }


        public function changePassword(User $user) {

            $stmt = $this->conn->prepare("UPDATE users SET
               password = :password
               WHERE id = :id
            ");

            $stmt->bindParam(":password", $user->password);
            $stmt->bindParam(":id", $user->id);

            $stmt->execute();

            //redireciona e apresenta a imagem de sucesso
            $this->message->setMessage("Senha alterado com sucesso!", "success", "editprofile.php");
        }

        public function deleteaccont(User $user) {

            // Atualizar a conta do usuário para deletada
            $stmt = $this->conn->prepare("UPDATE users SET is_deleted = TRUE WHERE id = :id");
            $stmt->bindParam(":id", $user->id);

            $stmt->execute();

            $this->destroySessao();

        }

        public function contadeleteda($email) {

            $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email AND is_deleted = TRUE");
            $stmt->bindParam(":email", $email);

            $stmt->execute();

            if($stmt->rowCount() > 0) {

                $data = $stmt->fetch();

                return true; //conta deletada
            }
            else {
                return false; //so da usuario ou senha incorreta
            }

        }

        public function createEndereco(User $user, $CEP, $rua, $bairro, $cidade, $estado, $numero, $Descricao) {
            try {
                $stmt = $this->conn->prepare("INSERT INTO endereco(
                    ID_User, CEP, rua, bairro, cidade, estado, numero, Descricao
                  ) VALUES(
                    :ID_User, :CEP, :rua, :bairro ,:cidade, :estado, :numero, :Descricao
                  )");
  
                $stmt->bindParam(":ID_User", $user->id);          
                $stmt->bindParam(":CEP", $CEP);
                $stmt->bindParam(":rua", $rua);
                $stmt->bindParam(":bairro", $bairro);
                $stmt->bindParam(":cidade", $cidade);
                $stmt->bindParam(":estado", $estado);
                $stmt->bindParam(":numero", $numero);
                $stmt->bindParam(":Descricao", $Descricao);
    
                $stmt->execute();

                return true;
            } catch(PDOException $e) {
                return false;
            }
        }
    }