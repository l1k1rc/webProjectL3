<?php 
    require('displayFunctions.php'); // attention à ne pas mettre un require d'un fichier.php qui possède déjà ce même require
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Wanna Drive</title>
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
              <h1>Wanna Drive</h1>
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

            <?php
             $showInfo = getMoneyBack($_SESSION['login']);
             $array_bi = getBankingInformations($_SESSION['login']);
            ?>
            <div id="resultContainer">
                <h2 class="marge" >- Credit -</h2>
                <?php echo "<p style='font-family: MANIFESTO, sans-serif; font-size: 40px; text-align: center; color: white;'>".$array_bi[0]['balancewh']." €</p>" ?>


                <div class='compartments'>
                    <h3 class="marge" >Ajouter du solde</h3>
                    <?php 
                        $containError = buyMoney($_SESSION['login']);
                        if($containError == "null"){
                           header("Refresh:0; url=manageWarehouse.php");
                        }else {
                            echo "$containError";
                        }
                        echo changeCreditCard($array_bi); 
                    ?>
                   
                </div>

                <div class="compartments">
                    <h3 class="marge" >Retirer du solde</h3>
                    <?php 
                        echo $showInfo;
                        echo changeRib($array_bi); 
                    ?>

                </div>
            </div>
    </div>
</div>
</body>
</html>