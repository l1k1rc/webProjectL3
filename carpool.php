<?php 
    require('registerFunctions.php');

    function loclogin(){
        if(!empty($_SESSION['login'])){
           return '<input type="text" name="email" style="width: 300px; margin-left: 98px" required="" value="'.$_SESSION['login'].'">';
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Rent a Car</title>
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
            <div id="resultContainer">
                <p style="font-family: MANIFESTO, sans-serif; font-size: 40px; text-align: center; color: tomato; margin-bottom: 50px;">- Proposer un covoiturage -</p>
                <form enctype="multipart/form-data" action="registerFunctions.php" method="POST">
                    <label id="type">Veuillez choisir la catégorie de votre voiture :</label>
                    <select name="type" style="width: 150px; margin-left: 80px">
                        <option value="citadine">Citadine</option>
                        <option value="suv">SUV</option>
                        <option value="4x4">4x4</option>
                        <option value="monospace">Monospace</option>
                        <option value="cabriolet">Cabriolet</option>
                        <option value="sportive">Sportive</option>
                        <option value="utilitaire">Utilitaire</option>
                    </select>
                    <br />
                    <label id="titleCarPool">Veuillez saisir le titre de votre covoiturage :</label>
                    <input type="text" name="titleCarPool" style="width: 300px; margin-left: 100px" required="">
                    <br />
                    <label id="places">Veuillez saisir le nombre de places disponible :</label>
                    <input type="number" name="places" min="1" max="7" style="width: 300px; margin-left: 140px; height: 50px; margin-bottom: 0.2cm" required="">
                    <br />
                    <label id="departure">Veuillez saisir votre point de départ :</label>
                    <input type="text" name="departure" style="width: 300px; margin-left: 140px; height: 50px; margin-bottom: 0.2cm" required="">
                    <br />
                    <label id="destination">Veuillez saisir votre destination :</label>
                    <input type="text" name="destination" style="width: 300px; margin-left: 140px; height: 50px; margin-bottom: 0.2cm" required="">
                    <br />
                    <label id="email">Veuillez saisir l'E-Mail lié à votre compte :</label>
                    <?php echo loclogin(); ?>
                    <br />
                    <label id="price">Veuillez saisir le prix du covoiturage :</label>
                    <input type="text" name="price" style="margin-bottom: 100px; width: 100px; margin-left: 137px" required="">
                    <br />
                    <label><b>Votre photo principale:</b></label>
                    <input type="file" accept="image/*" onchange="loadFile(event)" name="image" id="image" required="" style="margin-bottom: 1cm" required="">
                    <br />
                    <img id="output" style="max-width: 180px; margin-bottom: 1cm; margin-left: 5cm;" alt="" src="aaa"> 
                    <br />
                    <script>var loadFile = function(event) {
                        var reader = new FileReader();
                        reader.onload = function()
                        {
                            var output = document.getElementById('output');
                            output.src = reader.result;
                        };
                        reader.readAsDataURL(event.target.files[0]);
                            };
                     </script>
                    <label><b>Vos 3 photos supplémentaires:</b></label>
                    <br />
                    <br />
                    <input type="file" accept="image/*" onchange="loadFile(event)" name="image1" id="image1" required="" style="margin-bottom: 1cm">
                    <br />
                    <img id="output1" style="max-width: 180px; margin-bottom: 1cm; margin-left: 5cm;" alt="" src="bbb"> 
                    <br />
                    <script>var loadFile = function(event) {
                        var reader = new FileReader();
                        reader.onload = function()
                        {
                            var output = document.getElementById('output');
                            output.src = reader.result;
                        };
                        reader.readAsDataURL(event.target.files[0]);
                            };
                     </script>
                     <input type="file" accept="image/*" onchange="loadFile(event)" name="image2" id="image2" required="" style="margin-bottom: 1cm">
                    <br />
                    <img id="output2" style="max-width: 180px; margin-bottom: 1cm; margin-left: 5cm;" alt="" src="ccc"> 
                    <br />
                    <script>var loadFile = function(event) {
                        var reader = new FileReader();
                        reader.onload = function()
                        {
                            var output = document.getElementById('output');
                            output.src = reader.result;
                        };
                        reader.readAsDataURL(event.target.files[0]);
                            };
                     </script>
                     <input type="file" accept="image/*" onchange="loadFile(event)" name="image3" id="image3" required="" style="margin-bottom: 1cm">
                    <br />
                    <img id="output3" style="max-width: 180px; margin-bottom: 1cm; margin-left: 5cm;" alt="" src="ddd"> 
                    <br />
                    <script>var loadFile = function(event) {
                        var reader = new FileReader();
                        reader.onload = function()
                        {
                            var output = document.getElementById('output');
                            output.src = reader.result;
                        };
                        reader.readAsDataURL(event.target.files[0]);
                            };
                     </script>
                     <br />
                     <label style="margin-left: 300px;">Veuillez saisir une description complémentaire :</label>
                    <br />
                     <textarea name="commentaryArea" id="commentaryArea" rows="5" cols="80" style="font-size: 20px; padding: 8px; font-family:'times new roman', times, sans-serif; margin-left: 8%; margin-top: 30px"></textarea>
                    <br />
                    <input type="submit" name="enLigne2" value="Mettre en Ligne le covoiturage" style="margin-left: 40%; margin-top: 2cm">
                </form>
            </div>
        </div>
    </div>
</body>
</html>