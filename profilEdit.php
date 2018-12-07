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
            <div id="resultContainer">
                <?php
                    $containError = profilImgUpload($_SESSION['login']); 
                    // Redirect to profil.php page if no error detected, else show it
                    if ($containError == "null") {
                        header("Refresh:0; url=profil.php");
                    }else{
                        echo "$containError";
                    }
                //Profil infos collect
                $array_profil = profilDisplay($_SESSION['login']);
               
                //Image form & profil informations 
                echo "<h2 class='marge' >- Profil -</h2>

                <form enctype='multipart/form-data' action='profilEdit.php' method='POST' style='text-align: center;'>
                    <input type='file' accept='image/*' onchange='loadFile(event)' name='img' class='getProfil2' style='margin-bottom : 10px;' /><br />
                    <img src=".$array_profil[6]['profilimgu']."  alt='' id='output' style='  box-shadow: 0 0 20px 0 rgba(0,0,0,0.5), 0 5px 5px rgba(0,0,0,0.5); border: black groove 4px; width: 150px; height: 150px; margin-left:auto; margin-right:auto;'>
                    <script>
                        var loadFile = function(event) {
                            var reader = new FileReader();
                            reader.onload = function(){
                                var output = document.getElementById('output');
                                output.src = reader.result;
                            };
                            reader.readAsDataURL(event.target.files[0]);
                        };
                    </script><br />
                    <input type='submit' name='uploadRequired' class='getProfil2' value='Mettre à jour' />
                </form>

                <div class='compartments'>
                      <h3 class='marge'>Details du profil</h3>
                    <p class='descriptionAnnounceBis' style='top: 30%; '><b class='motImportant' >Email :</b> ".$array_profil[0]['emailu']."<br /><b class='motImportant' >Nom :</b> ".$array_profil[1]['nameu']." <br /><b class='motImportant' >Prenom :</b> ".$array_profil[2]['surnameu']." <br /> <b class='motImportant' >Age :</b> ".$array_profil[3]['ageu']." <br /><b class='motImportant' >Genre :</b> ".$array_profil[4]['gender']." <br /><b class='motImportant' >Mobile :</b> ".$array_profil[5]['phoneu']."</p>
                </div>"
                ?>
                <div class="compartments">
                    <h3 class="marge" >Modifier le profil</h3>
                    <?php
                        $sizeError = profilEdition($_SESSION['login']); 
                        // Redirect to profil.php page if no error detected, else show it
                        if ($sizeError == "null") {
                            header("Refresh:0; url=profil.php");
                        }else{
                            echo "$sizeError";
                        }
                    ?>
                    <form action="profilEdit.php" method="POST">
                        <label id="newname" class='motImportant'>Changer nom :</label>
                        <input type="text" name="newname" style="width: 200px; height: 10px; margin-left: 33px;">
                        <br />
                        <label id="newsurname" class='motImportant'>Changer prénom :</label>
                        <input type="text" name="newsurname" style="width: 200px; height: 10px; margin-left: 10px;">
                        <br />
                        <label id="newage" class='motImportant'>Changer âge :</label>
                        <input type="text" name="newage" style="width: 200px; height: 10px; margin-left: 40px;">
                        <br />
                        <label id="newgender" class='motImportant'>Changer genre :</label>
                            <select name="newgender" style="width: 200px; height: 39px; margin-left: 25px;">
                              <option value="nothing">Choisir</option>
                              <option value="Homme">Homme</option>
                              <option value="Femme">Femme</option>
                            </select> 
                        <br />
                        <label id="newtel" class='motImportant'>Changer mobile :</label>
                        <input type="text" name="newtel" style="width: 200px; height: 10px; margin-left: 17px;">
                        <br />
                        <label id="newpwd" class='motImportant'>Nouveau MDP :</label>
                        <input type="text" name="newpwd" style="width: 200px; height: 10px; margin-left: 26px; margin-right: 10px;">
                        <label id="newpwd1" class='motImportant'>Confirmer MDP :</label>
                        <input type="text" name="newpwd1" style="width: 200px; height: 10px; margin-left: 10px;">
                        <br />
                        <p style="text-align: center;"><input type="submit" name="editvalid" value="Mettre à jour" class="getProfil2"/></p>
                    </form>
                </div>
            </div>
    </div>
</div>
</body>
</html>