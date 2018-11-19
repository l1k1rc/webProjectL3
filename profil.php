<?php require('displayFunctions.php'); // attention à ne pas mettre un require d'un fichier.php qui possède déjà ce même require
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Rent a Car.</title>
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
    </style>
    <link rel="icon" href="pictures/iconCar.png" />
</head>
<body>
<div class="pictureBackground"></div>
    <div class="ourPage">
    <div class="header">
            <div class="siteTitle">
              <h1>Rent a car .</h1>
            </div>
            <?php displayMenu(); 
              if(!empty($_SESSION['login'])){
                displayConnectedMenu();
              }
              else{
                displayMenu();
                echo '<body onLoad="alert(\'Vous devez être connecté pour accéder à cette page\')">';
                echo '<meta http-equiv="refresh" content="0;URL=connection.php">';
              }
            ?>
             <div class="typeRentChoice">
                <a href='location.php'" class="a1">Proposer une location</a>
                <a href="covoiturage.php" class="a2">Proposer un covoiturage</a>
            </div>
            <div id="resultContainer">
                <?php
                //Profil infos collect
                $array_profil = profilDisplay($_SESSION['login']);
                echo "<p style='font-family: MANIFESTO, sans-serif; font-size: 40px; text-align: center; color: tomato;'>- Profil -</p>
                <center><img src=".$array_profil[6]['profilimgu']." style='  box-shadow: 0 0 20px 0 rgba(0,0,0,0.5), 0 5px 5px rgba(0,0,0,0.5); border: black groove 4px; width: 150px; height: 150px; margin-left:auto; margin-right:auto;'></center>
                <div class='compartments'>
                	  <p style='font-family: MANIFESTO, sans-serif; font-size: 20px; text-align: center; color: tomato; margin-bottom: 15px;'>Details du profil</p>
                    <p class='descriptionAnnounceBis' style='top: 30%;'><b class='motImportant' >Email :</b> ".$array_profil[0]['emailu']."<br /><b class='motImportant' >Nom :</b> ".$array_profil[1]['nameu']." <br /><b class='motImportant' >Prenom :</b> ".$array_profil[2]['surnameu']." <br /> <b class='motImportant' >Age :</b> ".$array_profil[3]['ageu']." <br /><b class='motImportant' >Genre :</b> ".$array_profil[4]['gender']." <br /><b class='motImportant' >Téléphone :</b> ".$array_profil[5]['phoneu']."</p>"
                ?>
                <input type="button" value="Editer le profil" onclick="window.location.href='profilEdit.php'" class="getProfil">
                </div>
                <div class="compartments">
                    <p style="font-family: MANIFESTO, sans-serif; font-size: 20px; text-align: center; color: tomato;">Mes annonces</p>
                    <?php 
                        echo profilUserRentDisplay($_SESSION['login']);
                    ?>
                </div>
                <div class="compartments">
                	  <p style="font-family: MANIFESTO, sans-serif; font-size: 20px; text-align: center; color: tomato;">Mes covoiturages</p>
                </div>
                <div class="compartments">
                	  <p style="font-family: MANIFESTO, sans-serif; font-size: 20px; text-align: center; color: tomato;">Solde du compte</p>
                    <input type="button" value="Recharger le compte" onclick="window.location.href='../index.php'" class="getProfil">
                </div>       
            </div>
    </div>
</div>
</body>
</html>