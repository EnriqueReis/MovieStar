<?php

    require_once("globals.php");
    require_once("db.php");
    require_once("models/User.php");
    require_once("models/Message.php");
    require_once("dao/UserDAO.php");

    $message = new Message("index.php");

    $userDao = new UserDAO($conn, "auth_process.php");
    

    //verifica o tipo de formulario

    $type = filter_input(INPUT_POST, "type");

    // verificação do tipo de formulário

    if($type === "register"){

        $name = filter_input(INPUT_POST, "name");
        $lastname = filter_input(INPUT_POST, "lastname");
        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");
        $confirmpassword = filter_input(INPUT_POST, "confirmpassword");


        //verificação de dados minimos

        if($name && $lastname && $email && $password){

            if($password === $confirmpassword){

                //verificar se o e-mail já esta cadastrado no sistema.
                if($userDao->findByEmail($email) === false){

                    $user = new User();

                    //Criação de Token e senha

                    $userToken = $user->genereteToken();
                    $finalPassword = $user->generetePassword($password);


                    $user->name = $name;
                    $user->lastname = $lastname;
                    $user->email = $email;
                    $user->password = $finalPassword;
                    $user->token = $userToken;

                    $auth = true;
                    
                    $userDao->create($user, $auth);

                }else{
                    //enviar mensagem de erro usuário já existe
                    $message->setMessage("E-mail já cadastrado, tente outro e-mail.", "error", "back");
                }

            }else{
                //enviar mensagem de erro que as senhas não são iguais
                $message->setMessage("As senhas não são iguais ", "error", "back");
            }

        }else{
            //enviar mensagem de erro de dados faltantes
            $message->setMessage("Por favor, preencha todos os campos", "error", "back");

        }

    }else if ($type === "login"){

    }
    