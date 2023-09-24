<?php
    require_once("globals.php");
    require_once("db.php");
    require_once("models/Message.php");
    require_once("dao/UserDAO.php");

    
    $message = new Message("index.php");

    $flassMenssage = $message->getMessage();

    if(!empty($flassMenssage["msg"])){
        //Limpar a mensagem
        $message->clearMessage();
    }


    $userDao = new UserDAO($conn, "header.php");

    $userData = $userDao->verifyToken(false);

    

    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieStar</title>
    <link rel="short icon" href="img/moviestar.ico" />
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.css" integrity="sha512-lp6wLpq/o3UVdgb9txVgXUTsvs0Fj1YfelAbza2Kl/aQHbNnfTYPMLiQRvy3i+3IigMby34mtcvcrh31U50nRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS DO PROJETO -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav id="main-navbar" class="navbar navbar-expand-lg">
            <a href="index.php" class="navbar-brand">
            <img src="img/logo(1).svg" alt="MovieStar" id="logo">
            <span id="moviestar-title">MovieStar</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <form action=""  method="GET" id="search-form" class="form-inline my-2 my-lg-0">
                <input type="text" name="q" id="search" class="form-control mr-sm-2" type="search" placeholder="Buscar filme" aria-label="Search">
                <button class="btn my-2 mt-sm-0" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav">
                    <?php if($userData):?>
                        <li class="nav-item">
                        <a href="newmovie.php" class="nav-link">
                            <i class="far fa-plus-square"></i> Incluir filme
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link">Meus filmes</a>
                    </li>
                    <li class="nav-item">
                        <a href="editprofile.php" class="nav-link"><?= $userData->name?></a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link">Sair</a>
                    </li>
                    <?php else: ?>
                        <li class="nav-item">
                        <a href="auth.php" class="nav-link">Entrar / Cadastrar</a>
                    </li>
                    <?php endif; ?>

                </ul>
            </div>

        </nav>
    </header>
    <?php if(!empty($flassMenssage["msg"])):?>
    <div class="msg-container">
        <p class="msg <?=$flassMenssage['type']?>"><?=$flassMenssage['msg']?></p>
    </div>
<?php endif; ?>

