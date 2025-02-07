<?php

    class User {

        /*novo telefone, endereço, sexo*/

        public $id;
        public $name;
        public $email;
        public $cpf;
        public $birthdate;
        public $password;
        public $image;
        public $token;
        public $user_type;
        public $telefone;
        public $endereco; //novo
        public $sexo;  //novo      

        /*public function getFullName($user) {
            return $user->name . " " . $user->lastname;
        }*/

        public function generateToken() {
            return bin2hex(random_bytes(50));
        }

        public function generatePassword($password) {
            return password_hash($password, PASSWORD_DEFAULT);
        }

        public function imageGenerateName() {
            return bin2hex(random_bytes(60)) . ".jpg";
        }

        public function timecookie() {
            return time() + (86400 * 30);  //isso é novo
        }

        public function databirthday($data) {
            $nascimento = new DateTime($data);
            $hoje = new DateTime(); 
            $idade = $hoje->diff($nascimento)->y; 
            $idadeMinima = 14;  
            if ($idade >= $idadeMinima) {
                return true;
            } else {
                return false;
            }
        }

        public function validarCPF($cpf) {
            $cpf = preg_replace('/\D/', '', $cpf);
        
            if (strlen($cpf) != 11 || preg_match('/^(\d)\1+$/', $cpf)) {
                return false;
            }
        
            $soma = 0;
            for ($i = 0; $i < 9; $i++) {
                $soma += (10 - $i) * intval($cpf[$i]);
            }
            $resto = $soma % 11;
            $digito1 = ($resto < 2) ? 0 : 11 - $resto;
        
            $soma = 0;
            for ($i = 0; $i < 10; $i++) {
                $soma += (11 - $i) * intval($cpf[$i]);
            }
            $resto = $soma % 11;
            $digito2 = ($resto < 2) ? 0 : 11 - $resto;
        
            if ($cpf[9] == $digito1 && $cpf[10] == $digito2) {
                return $cpf; // Retorna o CPF sem pontos ou traços
            } else {
                return false;
            }
        }

    }

    interface UserDAOInterface {

        public function buildUser($data);
        public function create(User $user, $authUser = false);
        public function update(User $user, $redirect = true);
        public function verifyToken($protected = false);
        public function verifyFuncionario($protected = false);
        public function setTokenToSession($token, $redirect = true);
        public function authenticateUser($email, $password);
        public function authenticatePassword($email, $password);
        public function findByEmail($email);
        public function findById($id);
        public function findByToken($token);
        public function findByCPF($cpf);
        public function destroyToken();
        public function destroySessao();
        public function changePassword(User $user);
        public function deleteaccont(User $user);
        public function contadeleteda($email);
        public function createEndereco(User $user, $CEP, $rua, $bairro, $cidade, $estado, $numero, $Descricao);
    }