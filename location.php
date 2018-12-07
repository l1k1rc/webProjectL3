<?php 
    require('registerFunctions.php');
    function loclogin(){
        if(!empty($_SESSION['login'])){
           return '<input type="text" id="email" name="email" required="" value="'.$_SESSION['login'].'">';
        }
    }
   
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Wanna Drive</title>
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
              <h1>Wanna Drive</h1>
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
                        <select name="type" id="type">
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
                        <input type="color" name="couleur" id="couleur">
                        <br />
                        <label for="marque">Veuillez saisir la marque de votre voiture :</label><br />
                        <input type="text" name="marque" required="" id="marque">
                        <br />
                        <label for="kilometer">Veuillez saisir le kilométrage de votre voiture :</label><br />
                        <input type="text" name="kilometer" required="" id="kilometer">
                        <br />
                        <label for="modele">Veuillez saisir le modèle de votre voiture :</label><br />
                        <input type="text" name="modele" required="" id="modele">
                        <br />
                        <label for="titleloc">Veuillez saisir le titre de votre location :</label><br />
                        <input type="text" name="titleloc" required="" id="titleloc">
                        <br />
                        <label for="places">Veuillez saisir le nombre de places :</label><br />
                        <input type="number" name="places" min="1" max="7" required="" id="places">
                        <br />
                    </div>
                    <div id="rightSide">
                        <label for="portes">Veuillez saisir le nombre de portes :</label><br />
                        <input type="number" name="portes" min="1" max="5" required="" id="portes">
                        <br />
                        <label for="puissance">Veuillez saisir la puissance de la voiture :</label><br />
                        <input type="text" name="puissance" required="" id="puissance">
                        <br />
                        <label for="boite">Veuillez saisir le type de la boite de vitesse :</label><br />
                        <select name="boite" id="boite">
                            <option value="auto">Automatique</option>
                            <option value="manuelle">Manuelle</option>
                            <option value="semiauto">Semi-automatique</option>
                        </select>
                        <br />
                        <label for="carburant">Veuillez choisir le type de carburant de la voiture :</label><br />
                        <select name="carburant" id="carburant">
                            <option value="essence">Essence</option>
                            <option value="diesel">Diesel</option>
                            <option value="electrique">Electrique</option>
                            <option value="hybride">Hybride</option>
                        </select>
                        <br />
                        <label for="email">Veuillez saisir l'E-Mail où vous contacter :</label><br />
                        <?php echo loclogin(); ?>
                        <br />
                        <label for="duree">Veuillez saisir la durée de location :</label><br />
                        <input type="number" name="duree" min="1" max="12" required="" id="duree">
                        <label>semaines</label><br />
                        <br />
                        <label for="prix">Veuillez saisir le prix de la location :</label><br />
                        <input type="text" name="prix" required="" id="prix">
                        <label>/jour</label><br />
                        <br />
                    </div><br />
                    <div id="filePart">
                        <label for="image"><b>Proposer une photo illustrant votre location :</b></label><br /><br />
                        <input type="file" accept="image/*" onchange="loadFile(event)" name="image" id="image" required="" style="margin-bottom: 1cm" >
                        <br />
                        <img id="output1" style="max-width: 250px; margin-bottom: 1cm; margin-left: 10cm;" alt="" src="#"> 
                        <br />
                        <script>var loadFile = function(event) {
                            var reader = new FileReader();
                            reader.onload = function()
                            {
                                var output = document.getElementById('output1');
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
                        <img id="output2" style="max-width: 250px; margin-bottom: 1cm; margin-left: 10cm;" alt="" src="#"> 
                        <br />
                        <script>var loadFile = function(event) {
                            var reader = new FileReader();
                            reader.onload = function()
                            {
                                var output = document.getElementById('output2');
                                output.src = reader.result;
                            };
                            reader.readAsDataURL(event.target.files[0]);
                                };
                         </script>
                         <input type="file" accept="image/*" onchange="loadFile(event)" name="image2" id="image2" required="" style="margin-bottom: 1cm">
                        <br />
                        <img id="output3" style="max-width: 250px; margin-bottom: 1cm; margin-left: 10cm;" alt="" src="#"> 
                        <br />
                        <script>var loadFile = function(event) {
                            var reader = new FileReader();
                            reader.onload = function()
                            {
                                var output = document.getElementById('output3');
                                output.src = reader.result;
                            };
                            reader.readAsDataURL(event.target.files[0]);
                                };
                         </script>
                         <input type="file" accept="image/*" onchange="loadFile(event)" name="image3" id="image3" required="" style="margin-bottom: 1cm">
                        <br />
                        <img id="output4" style="max-width: 250px; margin-bottom: 1cm; margin-left: 10cm;" alt="" src="#"> 
                        <br />
                        <script>var loadFile = function(event) {
                            var reader = new FileReader();
                            reader.onload = function()
                            {
                                var output = document.getElementById('output4');
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
