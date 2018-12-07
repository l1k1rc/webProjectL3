<?php require('displayFunctions.php'); 
?> 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Connexion</title>
    <link rel="stylesheet" type="text/css" href="withTest.css" media="screen">
    <style>
        input[type=text], input[type=password]{
            width: 100%;
            padding :12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        form{ /* pour le compartiment "conexion" */
            min-width: 600px;
            opacity: 0.85;
            width: 100%;
            padding: 20px;
            border-radius: 4px;
            background: #303030;
            box-shadow: 0 0 20px 0 rgba(0,0,0,0.2), 0 5px 5px rgba(0,0,0,0.24);
            -webkit-animation-name: etu-log-animation; 
            -webkit-animation-duration: 1s; 
            animation-name: etu-log-animation;
            animation-duration: 1s;
            position: relative;
        }
        input[type=submit]{
            background-color: tomato;
            color: white;
            padding: 7px 21px;
            margin: 8px 0;
            border: 1px solid tomato;
            border-radius:4px;
            cursor: pointer;
            width: 100%;
            box-shadow: 0 0 20px 0 rgba(0,0,0,0.2), 0 5px 5px rgba(0,0,0,0.24);
        }
        input[type=submit]:hover{
            background-color: white;
            color: tomato;
            border: 1px solid tomato;
            border-radius:4px;
        }
    </style>
    <link rel="icon" href="picture/iconCar.png" />
</head>
<body>
<div class="pictureBackground"></div>
    <div class="ourPage">
    <div class="header">
            <div class="siteTitle">
              <h1>Wanna Drive</h1>
            </div>
            <?php displayMenu(); 
              if(!empty($_SESSION['login'])){
                displayConnectedMenu();
              }
              else{
                displayMenu();
              }
            ?> <!-- PARTIE ADMIN CONNEXION PARTICULIERE , si celui-ci est connecté, alors sa variable de session sera $_SESSION['login']=admin, dans ce cas si cet utilisateur est connecté alors il est reconnu des les pages "start_session()" dans ce cas, certains button s'affichent lui permettant d'avoir accès à certaines fonctionnalités comme la suppression d'un commentaire, d'une location  -->
            <div id="contain">
              <form action="session.php" method="post">
                <h2>Connexion</h2>

                <label><b>Login :</b></label>
                <input type="text" name="login" placeholder="Entrez votre login" required="" <?php 
                if(!empty($_COOKIE['log']['login'])){
                echo 'value="'.$_COOKIE['log']['login'].'">';
                }else{ echo '>';} ?>
                             
                <label><b>Password :</b></label>
                <input type="password" name="pass" placeholder="Entrez votre mot de passe" required="" <?php 
                if(!empty($_COOKIE['log']['psw'])){
                echo 'value="'.$_COOKIE['log']['psw'].'">';
                }else{ echo '>';} ?>

                <br />
                <input type="checkbox" id="remember" name="remember">
                <label style="color:white; cursor: pointer;" for="remember">Se souvenir de moi</label>

                <input type="submit" name="valid" value="LOGIN">
               </form>
          </div>
    </div>
</div>
</body>
</html>