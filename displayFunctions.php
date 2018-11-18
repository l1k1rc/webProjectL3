<?php 
  require('postgres.func.php'); 

/**** Display the rental's choice in HTML ****/
	function displayForTheFirstChoice(){
		echo '            <div class="content" style="">
               <form method="post" action="rentalResult.php">                       <!-- -->
                <div id="serieOption1">
                      <label for="brand">Marque :</label><br />
                       <select name="brand" id="brand">
                           <option value="Renault">Renault</option>
                           <option value="Koenigsegg">Koenigsegg</option>
                           <option value="Ford">Ford</option>
                           <option value="BMW">BMW</option>
                           <option value="Volkswaggen">Volkswaggen</option>
                           <option value="Fiat">Fiat</option>
                           <option value="Peugeot">Peugeot</option>
                      </select> 
                      <br />
                      <label for="category">Catégorie</label>
                       <select name="category" id="category">
                           <option value="citadine">Citadine</option>
                           <option value="hypercar">Hypercar</option>
                           <option value="sportive">Sportive</option>
                           <option value="SUV">SUV</option>
                           <option value="berline">Berline</option>
                           <option value="cabriolet">Cabriolet</option>
                      </select> 
                      <br />
                      <label for="nbrPlace">Nombre de place</label>
                      <input type="number" name="nbrPlace" min="1" max="7" id="nbrPlace">
                      <br />
                      <label for="disponibility">Date de retrait :</label>
                      <input type="date" name="disponibility" id="disponibility">
                      <br />
                </div>
                <div id="serieOption2">
                       <label for="pricePerDay">Prix en euro par jour :</label>
                       <input type="range" id="pricePerDay" name="pricePerDay" min="10" max="100" id="pricePerDay" />
                       <br />
                       <label for="gearbox">Transmission:</label><br />
                       <select name="gearbox" id="gearbox">
                           <option value="auto">Automatique</option>
                           <option value="manuelle">Manuelle</option>
                           <option value="semiauto">Semi-automatique</option>
                      </select> 
                      <br />
                      <label for="age">Âge du conducteur :</label>
                      <input type="text" name="age" required="required" id="age">
                      <br />
                      <label for="endC">Date de retour :</label>
                      <input type="date" name="endC" id="endC">
                </div>
              <input type="submit" id="valid" name="valid"/>
            	</form>                                                                <!-- -->
            </div>';
	}
/**** Display the carshare' choice in HTML ****/
	function displayForTheSecondChoice(){
		echo '              <div class="content" style="">
                <div id="serieOption1">
                    <form action="" method="post" enctype="multipart/form-data">
                      <label for="brand">Marque :</label><br />
                       <select name="brand" id="brand">
                           <option value="1frr">Ferrari</option>
                           <option value="2kng">Koenigsegg</option>
                           <option value="3msr">Maserati</option>
                           <option value="4bmw">BMW</option>
                           <option value="5vlk">Volkswaggen</option>
                           <option value="6adi">Audi</option>
                           <option value="7pgt">Peugeot</option>
                      </select> 
                      <br />
                      <label for="station">Station de départ :</label>
                      <select name="station" id="station">
                           <option value="Lle">Lille</option>
                           <option value="Pa">Paris</option>
                           <option value="Br">Brest</option>
                      </select> 
                      <br />
                       <label for="pricePerDay">Prix en euro par jour :</label>
                       <input type="range" id="pricePerDay" name="pricePerDay" min="10" max="100" id="pricePerDay"/>
                      <br />
                    </form>
                </div>
                <div id="serieOption2">
                    <form method="post" action="traitement.php">
                       <label for="nbrPerson">Nombre de personne</label>
                       <input type="number" id="nbrPerson" name="nbrPerson" min="1" max="5" />
                       <br />
                       <label for="dst">Destination :</label><br />
                       <input type="text" name="dst" id="dst" required="required">
                      <br />
                    </form>
                </div>
                <form method="post" action="rentalResult.php">
                       <input type="submit" id="valid" name="valid"/>
                </form>
            </div>';
	}
	/*Allows to read a csv file and get each value*/
    function readCSVFile(){
        $line=1;
        $file=fopen("file.csv", "a+");
        $values=array();
        while($tab=fgetcsv($file,1024,';')){
            $field=count($tab);
            $line++;

            for($i=0;$i<$field;$i++){
                $values[]=$tab[$i];
            }
        }
        return $values;
    }
    function displayMenu(){
      if(empty($_SESSION['login'])){
      	echo '<div class="menu">
                <a href="index.php" class="active"><img src="pictures/home.png">&nbsp;&nbsp;&nbsp;Home</a>
                <a href="register.php"><img src="pictures/inscrip.png">&nbsp;&nbsp;&nbsp;S\'inscrire</a>
                <a href="connection.php"><img src="pictures/connect.png">&nbsp;&nbsp;&nbsp;Se connecter</a>
              </div>';
      }
    }
    function displayConnectedMenu(){
    	echo '<div class="menu">
              <a href="index.php" class="active"><img src="pictures/home.png">&nbsp;&nbsp;&nbsp;Home</a>
              <a href="profil.php"><img src="pictures/connect.png">&nbsp;&nbsp;&nbsp;Profil</a>
              <a href="#"><img src="pictures/historical.png">&nbsp;&nbsp;&nbsp;Historique</a>
              <a href="logout.php"><img src="pictures/logout.png">&nbsp;&nbsp;&nbsp;Logout</a>
            </div>';
    }
    /* A finir avec la BDD stockage, envoie, stockage long-terme ... */
    function commentTakeAndDisplay(){
    	if(isset($_POST['sendComment'])){
    		$sTitle=$_POST['title'];
    		$sComment=$_POST['commentaryArea'];

    	}
    }
        function profilDisplay($email){
      $dbconn =connectionDB();

      $req = pg_query("SELECT emailu FROM users WHERE emailu='".$email."'") or die('Échec de la requête : ' . pg_last_error());
      $array[0] = pg_fetch_array($req, null, PGSQL_ASSOC);

      $req = pg_query("SELECT nameu FROM users WHERE emailu='".$email."'") or die('Échec de la requête : ' . pg_last_error());
      $array[1] = pg_fetch_array($req, null, PGSQL_ASSOC);

      $req = pg_query("SELECT surnameu FROM users WHERE emailu='".$email."'") or die('Échec de la requête : ' . pg_last_error());
      $array[2] = pg_fetch_array($req, null, PGSQL_ASSOC);

      $req = pg_query("SELECT ageu FROM users WHERE emailu='".$email."'") or die('Échec de la requête : ' . pg_last_error());
      $array[3] = pg_fetch_array($req, null, PGSQL_ASSOC);

      $req = pg_query("SELECT gender FROM users WHERE emailu='".$email."'") or die('Échec de la requête : ' . pg_last_error());
      $gender = pg_fetch_array($req, null, PGSQL_ASSOC);
      if ($gender['gender'] == "t"){
        $array[4] = "Homme";
      }else{
        $array[4] = "Femme";
      }

      $req = pg_query("SELECT phoneu FROM users WHERE emailu='".$email."'") or die('Échec de la requête : ' . pg_last_error());
      $array[5] = pg_fetch_array($req, null, PGSQL_ASSOC);
      
      pg_close($dbconn);
      return $array;
    }
 ?>