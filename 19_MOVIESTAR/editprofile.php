<?php
    
    require_once("templates/header.php");
    require_once("dao/UserDAO.php");

    $userData = new UserDAO($conn, "header.php");

    $userData = $userData->verifyToken(true);

    

?>


    <div id="main-container" class="container-fluid">
        <h1>Edição de perfil</h1>
    </div>


<?php

    require_once("templates/footer.php")

?>
