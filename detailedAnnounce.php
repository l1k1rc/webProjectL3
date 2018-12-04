<?php require('displayFunctions.php'); 
  //Attention pas besoin de mettre le session_start() car celui-ci se trouve dans postgres.func.php qui est lui-même appelé par displayFunction.php 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Rent a car.</title>
    <link rel="stylesheet" type="text/css" href="withTest.css" media="screen">
    <style>
        input[type=text]{
            width: 35%;
            padding :12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type=submit]{
            background-color: tomato;
            color: white;
            padding: 7px 21px;
            margin: 8px 0;
            border: 1px solid tomato;
            border-radius:4px;
            cursor: pointer;
            width: 40%;
            box-shadow: 0 0 20px 0 rgba(0,0,0,0.2), 0 5px 5px rgba(0,0,0,0.24);
        }
        input[type=submit]:hover{
            background-color: white;
            color: tomato;
            border: 1px solid tomato;
            border-radius:4px;
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
            <div class="detailedPart">
              <?php echo displayDetailedPart($_GET['psd']); 
                
              ?>
              <hr />
              <h3>Photo(s) du véhicule :</h3><br />
              <?php 
                echo getPicturesForRent();
              ?>
                <button class="leftB" onclick="plusDivs(-1)">&#10094;</button>
                <button class="rightB" onclick="plusDivs(1)">&#10095;</button>
              <script>
                  var slideIndex = 1;
                  showDivs(slideIndex);

                  function plusDivs(n) {
                    showDivs(slideIndex += n);
                  }

                  function showDivs(n) {
                    var i;
                    var x = document.getElementsByClassName("mySlides"); // on prend l'elt HTML via sa classe qu'on stocke dans le tableau x
                    if (n > x.length) {slideIndex = 1}  // si on dépasse la taille de x c'est qu'on n'a plus d'image, on retourne à la première  
                    if (n < 1) {slideIndex = x.length} // dans les autres cas, on met n à la taille de x
                    for (i = 0; i < x.length; i++) {
                       x[i].style.display = "none";  
                    }
                    x[slideIndex-1].style.display = "block";  
                  }
              </script>
              <?php
                if(!empty($_SESSION['login'])){ 
                 echo "<form action='transaction.php?psd=".$_GET['psd']."'' method='post' style='text-align: center;'>
                  <input type='hidden' name='submitRent-1' value='".$_GET['psd']."'>
                  <input type='submit' name='submitRent-2' value='Effectuer la location'>
                </form>";
              }
              ?>
              <hr />
              </div>
              <?php dateHeure(); ?>
              <h3>Commentaires :</h3>
              <?php displayCommentInDetailedPart(); ?>
                <br />
              <hr />
              <?php accessComment() ?>
              <hr />
            </div>
            
    </div>
</div>
</body>
</html>
