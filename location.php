<?php 
    require('registerFunctions.php');
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
                <p style="font-family: MANIFESTO, sans-serif; font-size: 40px; text-align: center; color: tomato; margin-bottom: 50px;">- Proposer une location -</p>
                <form enctype="multipart/form-data" action="registerFunctions.php" method="POST">
                    <label for="type">Veuillez choisir la catégorie de votre voiture :</label>
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
                    <label for="couleur">Veuillez saisir la couleur de votre voiture :</label>
                    <input type="color" name="couleur" style="width: 300px; margin-left: 100px; height: 50px">
                    <br />
                    <label for="marque">Veuillez saisir la marque de votre voiture :</label>
                    <input type="text" name="marque" style="width: 300px; margin-left: 100px">
                    <br />
                    <label for="kilometer">Veuillez saisir le kilométrage de votre voiture :</label>
                    <input type="text" name="kilometer" style="width: 300px; margin-left: 100px">
                    <br />
                    <label for="modele">Veuillez saisir le modèle de votre voiture :</label>
                    <input type="text" name="modele" style="width: 300px; margin-left: 100px">
                    <br />
                    <label for="titleloc">Veuillez saisir le titre de votre location :</label>
                    <input type="text" name="titleloc" style="width: 300px; margin-left: 100px">
                    <br />
                    <label for="places">Veuillez saisir le nombre de places :</label>
                    <input type="number" name="places" min="1" max="7" style="width: 300px; margin-left: 140px; height: 50px; margin-bottom: 0.2cm">
                    <br />
                    <label for="portes">Veuillez saisir le nombre de portes :</label>
                    <input type="number" name="portes" min="1" max="5" style="width: 300px; margin-left: 140px; height: 50px">
                    <br />
                    <label for="puissance">Veuillez saisir la puissance de la voiture :</label>
                    <input type="text" name="puissance" style="width: 300px; margin-left: 105px">
                    <br />
                    <label for="boite">Veuillez saisir le type de la boite de vitesse :</label>
                    <select name="boite" style="width: 150px; margin-left: 100px">
                        <option value="auto">Automatique</option>
                        <option value="manuelle">Manuelle</option>
                        <option value="semiauto">Semi-automatique</option>
                    </select>
                    <br />
                    <label for="carburant">Veuillez choisir le type de carburant de la voiture :</label>
                    <select name="carburant" style="width: 150px; margin-left: 48px">
                        <option value="essence">Essence</option>
                        <option value="diesel">Diesel</option>
                        <option value="electrique">Electrique</option>
                        <option value="hybride">Hybride</option>
                    </select>
                    <br />
                    <label for="email">Veuillez saisir l'E-Mail où vous contacter :</label>
                    <input type="text" name="email" style="width: 300px; margin-left: 98px">
                    <br />
                    <label for="duree">Veuillez saisir la durée de location :</label>
                    <input type="number" name="duree" min="1" max="12" style="width: 300px; margin-left: 142px; height: 60px">
                    <label>semaines</label>
                    <br />
                    <label for="prix">Veuillez saisir le prix de la location :</label>
                    <input type="text" name="prix" style="margin-bottom: 100px; width: 100px; margin-left: 137px">
                    <label>/jour</label>
                    <br />
                    <label><b>Votre photo principale:</b></label>
                    <input type="file" accept="image/*" onchange="loadFile(event)" name="image" id="image" required="" style="margin-bottom: 1cm">
                    <br />
                    <img id="output" style="max-width: 180px; margin-bottom: 1cm; margin-left: 5cm;" alt=""> 
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
                    <img id="output" style="max-width: 180px; margin-bottom: 1cm; margin-left: 5cm;" alt=""> 
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
                    <img id="output" style="max-width: 180px; margin-bottom: 1cm; margin-left: 5cm;" alt=""> 
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
                    <img id="output" style="max-width: 180px; margin-bottom: 1cm; margin-left: 5cm;" alt=""> 
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
                     <label for="titleloc" style="margin-left: 300px;">Veuillez saisir une description complémentaire :</label>
                    <br />
                     <textarea name="commentaryArea" id="commentaryArea" rows="5" cols="80" style="font-size: 20px; padding: 8px; font-family:'times new roman', times, sans-serif; margin-left: 8%; margin-top: 30px"></textarea>
                    <br />
                    <input type="submit" name="enLigne" value="Mettre en Ligne la location" style="margin-left: 40%; margin-top: 2cm">
                </form>
            </div>
        </div>
    </div>
</body>
</html>