<?php require('displayFunctions.php'); 
  if(empty($_SESSION['login'])){
    header('location: index.php');
  }
?>
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
          border-radius: 4px;¸2É
          box-sizing: border-box;
        }
    </style>
    <link rel="icon" href="iconCar.png" />
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
            <div id="adminPart">
              <div id="statistic">
                <?php 
                  echo '<img src="./graph.php" >'; 
                ?>
              </div>
              <div id="statistic2">
                <?php 
                  echo '<img src="./pieChart.php" >'; 
                ?>
              </div>
              
                                      <!-- PARTIE A REMPLIR -->



            </div>
    </div>
</div>
</body>
</html>