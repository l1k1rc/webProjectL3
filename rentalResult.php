<?php require('displayFunctions.php'); 
ini_set("display_errors",0);error_reporting(0);?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Résultat(s) de la recherche</title>
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
              }
            ?>
             <div id="shoppingCart">
                    <p style="font-size: 25px; color: tomato;text-align: center;">Achat 1 : <br /><B>19,80$</B><br /> Achat 2 : <br /><B>20,20$</B></p>
              </div>
            <input id="wallet" type="button" value="#" onClick="AfficherMasquer()" />
            <script>

            function AfficherMasquer()
            {
                divInfo = document.getElementById('shoppingCart');
                 
                if (divInfo.style.display == 'none')
                    divInfo.style.display = 'block';
                else
                    divInfo.style.display = 'none';
            }
            </script>
            
             
            
            <div id="resultContainer">
                <p style="font-family: MANIFESTO, sans-serif; font-size: 30px; text-align: center; color: tomato;">- Resultat(s) de la recherche : -</p>
           <!-- <div class="compartments">
                    <img src="pictures/pagani.jpg" style="  box-shadow: 0 0 20px 0 rgba(0,0,0,0.5), 0 5px 5px rgba(0,0,0,0.5); border: black groove 4px; width: 230px; height: 150px;">
                    <p class="descriptionAnnounce">Type : Super car<br />Transmission : Semi-automatique <br />Carburant : essence <br />Modèle : </p>
                    <p class="userProfilAccess">Utilisateur : <a href="#">Jean-Michel</a></p>
                    <a href="detailedAnnounce.php" class="getProfil">Voir annonce</a>
                </div> -->
                <?php echo searchByFilter(); ?>
            </div>
    </div>
</div>
</body>
</html>