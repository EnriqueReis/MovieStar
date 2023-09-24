<?php

    class Message{

        private $url;

        public function __construct($baseUrl = "")
        {
            $this->url = rtrim($baseUrl, '/');
        }

        public function setMessage($msg, $type, $redirect = "index.php"){

            $_SESSION["msg"] = $msg;
            $_SESSION["type"] = $type;

            if($redirect != "back"){
                header("Location: " . $this->url . "/" . ltrim($redirect, '/'));
            }else {
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            }


        }

        public function getMessage(){
            if(!empty($_SESSION["msg"])){
                return[
                    "msg" => $_SESSION["msg"],
                    "type" => $_SESSION["type"]
                ];
            }else{
                return false;
            }
        }

        public function clearMessage(){
            $_SESSION["msg"] = "";
            $_SESSION["type"] = "";
        }



    }