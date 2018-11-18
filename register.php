<?php require('displayFunctions.php'); 
ini_set("display_errors",0);error_reporting(0);?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>S'enregistrer</title>
    <link rel="stylesheet" type="text/css" href="withTest.css" media="screen">
    <style>
        input[type=text], input[type=password], input[type=tel], input[type=email], input[type=number], select{
            width: 70%;
            padding :12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-left: 15%;
        }
        input[type=submit]{
			  background-color: tomato;
			  color: white;
			  padding: 7px 21px;
			  border: 1px solid tomato;
			  border-radius:4px;
			  cursor: pointer;
			  box-shadow: 0 0 20px 0 rgba(0,0,0,0.2), 0 5px 5px rgba(0,0,0,0.24);
			  transition: 1s;
			  margin-left:40%;
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
            <div id="registerPage">
            	<form enctype="multipart/form-data" method="post" action="registerFunctions.php"> 
            		<br /><label for="name">Votre nom :</label><br />
            		<input type="text" name="name">
            		<br /><label for="surname">Votre prénom :</label><br />
            		<input type="text" name="surname">
            		<br /><label for="age">Votre âge :</label><br />
            		<input type="number" name="age">
            		<br /><label for="mail">Votre email :</label><br />
            		<input type="email" name="mail">
            		<br /><label for="sexe">Votre sexe :</label><br />
            		<select name="sexe" id="sexe">
                           <option value="FALSE">Femme</option>
                           <option value="TRUE">Homme</option>
                           <option value="autre">Hélicoptère de combat équipé de missile anti-aérien et d'hélices bilatérales</option>
                    </select>
                    <br /><label for="phone">Votre n°- de téléphone :</label><br />
                    <input type="tel" name="phone">
                    <br /><label for="password">Votre mot de passe :</label><br />
                    <input type="password" name="password"><br />
                    <br />
                    <label>Votre photo de profil:</label>
                    <input type="file" accept="image/*" onchange="loadFile(event)" name="photo" id="photo" required="" style="margin-bottom: 1cm">
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
                    <input type="submit" name="validRegister" value="Valider l'inscription">
            	</form>
            </div>
    </div>
</div>
</body>
</html>