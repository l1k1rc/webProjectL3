<?php require('displayFunctions.php'); // attention à ne pas mettre un require d'un fichier.php qui possède déjà ce même require
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Rent a Car.</title>
    <link rel="stylesheet" type="text/css" href="withTest.css" media="screen">
    <style>
        .spaceHBuy {
            margin-left : 12%; 
            display : inline;
            color: red;     
            font-weight: bold;
        }

        .spaceHRec{
            margin-left : 52%; 
            display : inline;
            color: red;     
            font-weight: bold;
        }

        .spaceBuy{
            margin-top: 1%;
            margin-left : 6%; 
            display : inline;
        }

        .spaceRec{
            margin-top: 1%;
            margin-left : 40%; 
            display : inline;
        }

        .marge{
            margin-bottom: 1%;
        }
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
                <a href="location.php" class="a1">Proposer une location</a>
                <a href="carpool.php" class="a2">Proposer un covoiturage</a>
            </div>
            <div id="resultContainer">
                <?php
                //Profil infos collect
                $array_profil = profilDisplay($_SESSION['login']);
                echo "<h2 class='marge' >- Profil -</h2>
                <p style='text-align: center;'><img src=".$array_profil[6]['profilimgu']." alt='' style='box-shadow: 0 0 20px 0 rgba(0,0,0,0.5), 0 5px 5px rgba(0,0,0,0.5); border: black groove 4px; width: 150px; height: 150px; margin-left:auto; margin-right:auto;'></p>
                <div class='compartments'>
                	  <h3 class='marge'>Details du profil</h3>
                    <p class='descriptionAnnounceBis' style='top: 30%;'><b class='motImportant' >Email :</b> ".$array_profil[0]['emailu']."<br /><b class='motImportant' >Nom :</b> ".$array_profil[1]['nameu']." <br /><b class='motImportant' >Prenom :</b> ".$array_profil[2]['surnameu']." <br /> <b class='motImportant' >Age :</b> ".$array_profil[3]['ageu']." <br /><b class='motImportant' >Genre :</b> ".$array_profil[4]['gender']." <br /><b class='motImportant' >Téléphone :</b> ".$array_profil[5]['phoneu']."</p>"
                ?>
                <input type="button" value="Editer le profil" onclick="window.location.href='profilEdit.php'" class="getProfil">
                </div>
                <div class="compartments">
                    <h3 class="marge" >Mes annonces</h3>
                    <?php 
                        echo profilUserRentDisplay($_SESSION['login']);
                    ?>
                </div>
                <div class="compartments">
                	  <h3 class="marge" >Mes covoiturages</h3>
                </div>
                <div class="compartments">
                	<h3 class="marge" >Solde du compte</h3>
                    <?php
                        getHistoricalWarehouse($_SESSION['login'],'buyCredit');
                    ?>
                    <p style="text-align: center;"><input type="button" value="Recharger le compte" onclick="window.location.href='./manageWarehouse.php'" class="getProfil2"></p>
                </div> 
                <div class="compartments">
                        <h3 class="marge" >Messagerie</h3>

                        <?php

                            //appel des fonctions en rapport avec les messages
                            $verif=removeMessages();
                            displayMessages();
                            $verif2=sendMessage();

                        ?>

                        <form method="post" action="profil.php" onsubmit="return sendMessage()"; style="text-align: center;">
                            <label for="dest">Veuillez saisir le destinataire de votre message :</label>
                            <br />
                            <input type="text" name="dest" required="required">
                            <br />
                            <label for="commentaryArea">Ecrivez votre message :</label>
                            <br />
                            <textarea name="messageArea" rows="5" cols="80" required="required"></textarea>
                            <br />
                            <input type="submit" value="Envoyer" name="envoyer" id="send_whisper" class="getProfil2">
                            <br />
                        </form>
                            <form method="post" action="profil.php" style="text-align: center;" id="f_prof">
                            <br />
                            <input type="submit" value="Supprimer les messages" name="delete" id="delete_whisper" class="getProfil2">
                        </form>
                        <?php 
                            //en fonction des valeurs retournées des fonctions on a différents évènements
                            if($verif2==1){
                                echo '<p style="color:green;">Message Envoyé !</p>';
                            }
                            if($verif==1){
                                echo '<p style="color:green;">Message(s) Supprimé(s) !</p>';
                            }
                            if($verif2==2){
                                echo '<p style="color:red;">Destinataire introuvable !</p>';
                            }
                        ?>
                </div>      
            </div>
    </div>
</div>
</body>
</html>