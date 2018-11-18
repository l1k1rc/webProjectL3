<?php require('displayFunctions.php'); 
ini_set("display_errors",0);error_reporting(0);?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Rent a car.</title>
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
        input{
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
            <div class="typeRentChoice">
                <a href="?var=v1" class="a1">Location d'un véhicule</a>
                <a href="?var=v2" class="a2">Recherche d'un covoiturage</a>
            </div>
            <?php if($_GET['var']=='v1'){ //display the page, it depends of the type asked
                displayForTheFirstChoice();
              }
            else if($_GET['var']=='v2'){
                displayForTheSecondChoice();
              }
            else{
                displayForTheFirstChoice();// to avoid a bad posting if the $_GET variable are modified
            }
           ?>
           <script type="text/javascript">
//confirm=oui ou non, prompt=scanf, alert= printf
         
           </script>
    </div>
</div>
</body>
</html>
