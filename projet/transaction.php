<?php require('displayFunctions.php'); 
ini_set("display_errors",0);error_reporting(0);?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Rent a car.</title>
    <link rel="stylesheet" type="text/css" href="withTest.css" media="screen">
    <link rel="icon" href="pictures/iconCar.png" />
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
            <div id="transact_info">
              <div id="leftSide">
                <h3>Informations  :</h3>
                <form action="transaction.php" method="post">
                  <label for="tsct_email">Email :</label>
                  <input type="email" name="tsct_email"><br />
                  <label for="tsct_name">Nom :</label>
                  <input type="text" name="tsct_name"><br />
                  <label for="tsct_surname">Prénom :</label>
                  <input type="text" name="tsct_surname"><br />
                  <label for="tsct_adresse">Adresse de facturation :</label>
                  <input type="text" name="tsct_adresse"><br />
                  <input type="submit" name="tsct_valid" value="Valider la transaction"><br />
                </form>
              </div>
              <div id="rightSide">
                
              </div>
            </div>
    </div>
</div>
</body>
</html>
