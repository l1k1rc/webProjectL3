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


/*<label for="brand">Marque :</label><br />
                       <select name="brand" id="brand">
                           <option value="1frr">Ferrari</option>
                           <option value="2kng">Koenigsegg</option>
                           <option value="3msr">Maserati</option>
                           <option value="4bmw">BMW</option>
                           <option value="5vlk">Volkswaggen</option>
                           <option value="6adi">Audi</option>
                           <option value="7pgt">Peugeot</option>
                      </select>*/



/********************************************************************************************************/

	function displayForTheSecondChoice(){
		echo '    <div class="content" style="">
                <div id="serieOption1">
                    <form action="carpoolResult.php" method="post" enctype="multipart/form-data">
                      <br />
                      <label for="type">Type de voiture recherché :</label><br />
                        <select name="type" id="type">
                           <option value="citadine">Citadine</option>
                           <option value="hypercar">Hypercar</option>
                           <option value="sportive">Sportive</option>
                           <option value="SUV">SUV</option>
                           <option value="berline">Berline</option>
                           <option value="cabriolet">Cabriolet</option>
                        </select>
                      <br />
                      <label for="station">Station de départ :</label>
                      <input type=text" id="station" name="station"/>
                      <br />
                       <label for="price">Prix du voyage :</label>
                       <input type="range" id="price" name="price" min="10" max="1000"/>
                </div>
                <div id="serieOption2">
                       <label for="places">Nombre de personne</label>
                       <input type="number" id="places" name="places" min="1" max="7" />
                       <br />
                       <label for="dst">Destination :</label><br />
                       <input type="text" name="dst" id="dst" required="required">
                      <br />
                </div>
                       <input type="submit" id="validcs" name="validcs"/>
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
                <a href="index.php" class="active"><img src="pictures/home.png" alt="">&nbsp;&nbsp;&nbsp;Home</a>
                <a href="register.php"><img src="pictures/inscrip.png" alt="">&nbsp;&nbsp;&nbsp;S\'inscrire</a>
                <a href="connection.php"><img src="pictures/connect.png" alt="">&nbsp;&nbsp;&nbsp;Se connecter</a>
              </div>';
      }
    }
    function displayConnectedMenu(){
    	echo '<div class="menu">
              <a href="index.php" class="active"><img src="pictures/home.png" alt="">&nbsp;&nbsp;&nbsp;Home</a>
              <a href="profil.php"><img src="pictures/connect.png" alt="">&nbsp;&nbsp;&nbsp;Profil</a>
              <a href="#"><img src="pictures/historical.png" alt="">&nbsp;&nbsp;&nbsp;Historique</a>
              <a href="logout.php"><img src="pictures/logout.png" alt="">&nbsp;&nbsp;&nbsp;Logout</a>
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


    /*********Affichage des messages de la base de données correspondant à l'utilisateur connecté*******/
    function displayMessages(){
      $db=connectionDB();

      //recherche des messages destinés à l'utilisateur connecté sur le site web
      $msg="SELECT messagewhisp FROM whisper WHERE dstwhisp='".$_SESSION['login']."'";

      $req1=pg_query($msg) or die('Échec de la requête : ' . pg_last_error());

      //pour tout les messages sélectionnés dans la base de données...
       while ($message = pg_fetch_array($req1,null,PGSQL_ASSOC)) {
        foreach ($message as $val1) {

          //...déterminer le destinataire du/des message(s)
          $src="SELECT srcwhisp FROM whisper WHERE messagewhisp='".$val1."'";
          $req2=pg_query($src) or die('Échec de la requête : ' . pg_last_error());         

          //pour chaque destinataire en adéquation avec le message selectionné
          while ($dest = pg_fetch_array($req2,null,PGSQL_ASSOC)) {
            foreach ($dest as $val2) {

              //...déterminer la date d'envoie du message
              $dateReq="SELECT datewhisp FROM whisper WHERE messagewhisp='".$val1."'";
              $req3=pg_query($dateReq) or die('Échec de la requête : ' . pg_last_error());

              //on remplace tout les ' par une balise [\quote] pour éviter les erreurs
              $val1=str_replace("[\quote]","'",$val1);

              while ($date=pg_fetch_array($req3,null,PGSQL_ASSOC)) {
                foreach ($date as $valDate) {
                }
              }

              //afficher le message avec le destinataire en italique
              echo "<p><b>".$val2."</b> <em>( Envoyé le: ".$valDate." )</em>: ".$val1."</p><br />";

            }
          }
        }
      }
      closeDB($db);
    }

    /*********Envoi d'un message*********/
    function sendMessage(){

      //si il y a bien eu un message et un destinataire entré dans le champs de texte et si l'utilisateur est bien connecté
      if(isset($_POST['messageArea']) && isset($_POST['dest']) && isset($_SESSION['login'])){

        $db=connectionDB();

        //recherche si destinataire est bien enregistré dans la base de donnée (présent dans la table users)
       $req1=pg_query("SELECT dstwhisp FROM whisper INNER JOIN users ON users.emailu='".$_POST['dest']."'") or die('Échec de la requête : ' . pg_last_error());

        while ($l1 = pg_fetch_array($req1,null,PGSQL_ASSOC)) {
            foreach ($l1 as $val1) {
              //si le destinataire dans la bd est bien celui envoyé par l'utilisateur
              if($val1==$_POST['dest']){
                $result=$val1;
              }
            }
        }

        //si il existe bien un destinataire existant
        if(isset($val1)){

          //recherche des id des messages
          $req=pg_query("SELECT idwhisper FROM whisper") or die('Échec de la requête : ' . pg_last_error());

          $k=0;

          //on parcourt tout les id jusqu'à avoir le dernier
          while ($l = pg_fetch_array($req,null,PGSQL_ASSOC)) {
            foreach ($l as $val) {
            }
          }

          //si il existe bien un id on incrémente l'id pour ce message sinon ce message est le premier à etre enregistré dans la bd donc il prend la valeur 1
          if(isset($val)){
            $val=$val+1;
          }
          else{
            $val=1;
          }

          //on remplace tout les ' par une balise [\quote] pour éviter les bugs
          $msg=str_replace("'","[\quote]",$_POST['messageArea']);

          //insertion du message dans la base de donnée
          $req1=pg_query($db,"INSERT INTO whisper (idwhisper,messagewhisp,datewhisp,srcwhisp,dstwhisp,emailu,ida) VALUES ('".$val."','".$msg."','".dateHeure()."','".$_SESSION['login']."','".$_POST['dest']."','".$_SESSION['login']."','1');");

          closeDB($db);

          //le message a bien été enregistré
          return 1;
        }
        else{
          //erreur le message n'a pas été enregistré
          return 2;
        }
      }
    }

    /**fonction qui supprime les messages qui sont destinés à l'utiilisateur connecté au compte courant**/
    function removeMessages(){

      //si l'utilisateur a bien cliqué sur "supprimer les messages"
      if(isset($_POST['delete'])){

        $db=connectionDB();

        //on supprime les messages qui sont destinés à l'utiilisateur connecté au compte courant
        $tmp="DELETE FROM whisper WHERE srcwhisp='".$_SESSION['login']."';";
        $req=pg_query($tmp) or die('Échec de la requête : ' . pg_last_error());

        closeDB($db);

        //le(s) message(s) ont bien été supprimé
        return 1;
      }
    }
 ?>