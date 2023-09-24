<?php

    class User{
        public $id;
        public $name;
        public $lastname;
        public $email;
        public $password;
        public $image;
        public $bio;
        public $token;

        public function genereteToken(){
            return bin2hex(random_bytes(50));
        }

        public function generetePassword($password){
            return password_hash($password, PASSWORD_DEFAULT);

        }

    }

    interface UserDAOInterface {
        
        public function BuidUser($data);
        public function create(User $user, $authUser = false);
        public function update(User $user);
        public function changePassword(User $user);
        public function verifyToken($protected = false);
        public function setTokenSession($token, $redirect = true);
        public function authenticateUser($email, $password);
        public function destroyToken();
        public function findByEmail($email);
        public function findById($id);
        public function findByToken($Token);
       
            
            
        

    }