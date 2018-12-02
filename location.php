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
        input{
            width: 100%;
            padding :12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type=color]{
            padding: 1px;
            height: 50px;
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
            margin-left: 30%;
            margin-top: 20px;
        }
        input[type=submit]:hover{
            background-color: white;
            color: tomato;
            border: 1px solid tomato;
            border-radius:4px;
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
                    <div id="leftSide">
                        <label for="type">Veuillez choisir la catégorie de votre voiture :</label><br />
                        <select name="type">
                            <option value="citadine">Citadine</option>
                            <option value="suv">SUV</option>
                            <option value="4x4">4x4</option>
                            <option value="monospace">Monospace</option>
                            <option value="cabriolet">Cabriolet</option>
                            <option value="sportive">Sportive</option>
                            <option value="utilitaire">Utilitaire</option>
                        </select>
                        <br />
                        <label for="couleur">Veuillez saisir la couleur de votre voiture :</label><br />
                        <input type="color" name="couleur">
                        <br />
                        <label for="marque">Veuillez saisir la marque de votre voiture :</label><br />
                        <input type="text" name="marque">
                        <br />
                        <label for="kilometer">Veuillez saisir le kilométrage de votre voiture :</label><br />
                        <input type="text" name="kilometer">
                        <br />
                        <label for="modele">Veuillez saisir le modèle de votre voiture :</label><br />
                        <input type="text" name="modele">
                        <br />
                        <label for="titleloc">Veuillez saisir le titre de votre location :</label><br />
                        <input type="text" name="titleloc">
                        <br />
                        <label for="places">Veuillez saisir le nombre de places :</label><br />
                        <input type="number" name="places" min="1" max="7">
                        <br />
                    </div>
                    <div id="rightSide">
                        <label for="portes">Veuillez saisir le nombre de portes :</label><br />
                        <input type="number" name="portes" min="1" max="5">
                        <br />
                        <label for="puissance">Veuillez saisir la puissance de la voiture :</label><br />
                        <input type="text" name="puissance">
                        <br />
                        <label for="boite">Veuillez saisir le type de la boite de vitesse :</label><br />
                        <select name="boite">
                            <option value="auto">Automatique</option>
                            <option value="manuelle">Manuelle</option>
                            <option value="semiauto">Semi-automatique</option>
                        </select>
                        <br />
                        <label for="carburant">Veuillez choisir le type de carburant de la voiture :</label><br />
                        <select name="carburant">
                            <option value="essence">Essence</option>
                            <option value="diesel">Diesel</option>
                            <option value="electrique">Electrique</option>
                            <option value="hybride">Hybride</option>
                        </select>
                        <br />
                        <label for="email">Veuillez saisir l'E-Mail où vous contacter :</label><br />
                        <input type="text" name="email">
                        <br />
                        <label for="duree">Veuillez saisir la durée de location :</label><br />
                        <input type="number" name="duree" min="1" max="12">
                        <label>semaines</label><br />
                        <br />
                        <label for="prix">Veuillez saisir le prix de la location :</label><br />
                        <input type="text" name="prix">
                        <label>/jour</label><br />
                        <br />
                    </div><br />
                    <div id="filePart">
                        <label for="image"><b>Proposer une photo illustrant votre location :</b></label><br /><br />
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
                        <label><b>Vos 3 photos supplémentaires:</b></label><br />
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
                         <label for="commentaryArea" style="text-align: center;">Veuillez saisir une description complémentaire :</label>
                         <textarea name="commentaryArea" id="commentaryArea" rows="5" cols="80" style="font-size: 20px; padding: 8px; font-family:'times new roman', times, sans-serif; margin-left: 8%; margin-top: 30px"></textarea>
                        <br />
                        <input type="submit" name="enLigne" value="Mettre en Ligne la location">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<!-- nav>li.item$*5  -->

<!-- (form>input[type=text].item$*4+input[type=submit]#valid) -->

<!-- !>form#formulaire>input[type=text].item$*4+input[type=submit]#valid -->

<!-- !>h1{Mon blog}+(p.item$>img)*2>form>(input[type=text]*3)+input[type=submit]#valid -->



