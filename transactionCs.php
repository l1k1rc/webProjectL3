<?php require('displayFunctions.php'); ?>
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
                <h3>Informations acheteur  :</h3>
                <?php infoSessionCs(); ?>
              </div>
              <div id="rightSide">
                <h3>Informations achat :</h3><br >
                <?php echo infoAchatCs(); ?>
              </div>
              <?php validCarpool(); ?>
            </div>
    </div>
</div>
</body>
</html>