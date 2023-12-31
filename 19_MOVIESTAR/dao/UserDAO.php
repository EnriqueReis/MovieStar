<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once("models/User.php");
    require_once("models/Message.php");
    require_once("globals.php");

    class UserDAO implements UserDAOInterface{

        private $conn;
        private $url;
        private $message;
        


        public function __construct(PDO $conn, $url)
        {
            $this->conn = $conn;
            $this->url = $url;
            $baseUrl = "http://127.0.0.1/curso_php/19_MOVIESTAR/";
            $this->message = new Message($baseUrl);
            
        }


        public function BuidUser($data){

            $user = new User();

            $user->id = $data["id"];
            $user->name = $data["name"];
            $user->lastname = $data["lastname"];
            $user->email = $data["email"];
            $user->password = $data["password"];
            $user->image = $data["image"];
            $user->bio = $data["bio"];
            $user->token = $data["token"];

            return $user;
        }

        public function create(User $user, $authUser = false){

            $stmt = $this->conn->prepare("INSERT INTO users(name, lastname, email, password, token) 
                VALUES (
                :name, :lastname, :email, :password, :token)");

            $stmt->bindParam(":name", $user->name);
            $stmt->bindParam(":lastname", $user->lastname);
            $stmt->bindParam(":email", $user->email);
            $stmt->bindParam(":password", $user->password);
            $stmt->bindParam(":token", $user->token);

            $stmt->execute();

            // Autenticar usuário, caso auth seja true

            if($authUser){
                $this->setTokenSession($user->token);
            }

        }

        public function update(User $user){

        }

        public function changePassword(User $user){

        }

        public function verifyToken($protected = false){

            if(!empty($_SESSION["token"])){

                //pegar o token da session
                $token = $_SESSION["token"];

                $user = $this->findByToken($token);

                if($user){
                    return $user;
                }else if($protected){
                    //Redireciona usuário não autenticado
                    $this->message->setMessage("Faça a autenticação para acessar essa pagina", "error", "index.php");
                }

            }else if ($protected){
                $this->message->setMessage("Faça a autenticação para acessar essa pagina", "error", "index.php");
                
            }

        }

        public function setTokenSession($token, $redirect = true){

            //Salvar token na session
            $_SESSION["token"] = $token;

            echo "Antes do redirecionamento";

            if($redirect){

                //Redireciona para o perfil do usuário
                $this->message->setMessage("Sejá bem-vindo", "success", "./editprofile.php");
            }else{
                echo "não é true";
            }

            

        }

        public function authenticateUser($email, $password){

        }


        public function destroyToken()
        {
            //remove token da session
            $_SESSION["token"] = "";
            //redireciona e apresenta a mensagem de sucesso

            $this->message->setMessage("Você fez logout com sucesso!", "success", "index.php");
        }



        public function findByEmail($email){
            if($email != ""){

                $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");

                $stmt->bindParam(":email", $email);

                $stmt->execute();

                if($stmt->rowCount() > 0){
                    $data = $stmt->fetch();
                    $user = $this->BuidUser($data);

                    return $user;
                }else{
                    return false;
                }

            }else{
                return false;
            }
        }

        public function findById($id){

        }

        public function findByToken($token){

            if($token != ""){

                $stmt = $this->conn->prepare("SELECT * FROM users WHERE token = :token");

                $stmt->bindParam(":token", $token);

                $stmt->execute();

                if($stmt->rowCount() > 0){
                    $data = $stmt->fetch();
                    $user = $this->BuidUser($data);

                    return $user;
                }else{
                    return false;
                }

            }else{
                return false;
            }
            
        }
    }