<?php 
	session_start();

	require('connectDatabase.php');
	/*Allows  to display each division with their compartments after the filter in he home page */
	function searchByFilter(){
		$tab='';
		$pseudo=array(); // for the data obtained by the SQL request
		if(isset($_POST['valid'])){
			$dbconn=connectionDB();
			$picturesRent=array(); 
			$k=0;
			$searchPhoto=pg_query("SELECT path2photofiles FROM file2 INNER JOIN rent ON rent.idrent=file2.idrent") or die('Erreur dans la table File');
			while ($l = pg_fetch_array($searchPhoto,null,PGSQL_ASSOC)) {
				foreach ($l as $val) {
					$picturesRent[$k]=$val;
					$k++;
				}
			}
			/* INDICE $I in the loop  :::::  0 = path, 1 = idrent, 2 = namerent, 3 = brandrent, 4 = gearboxrent, 5 = typerent, 6 = nbr_seatrent, 7 = pricerent, 8 = emailu  */																					
			/*********************************************************************************************************/
			$tabName=array('','','','Marque : ', 'Transmission : ', 'Catégorie : ', 'Nombre de sièges : ',' ' );
			$result=pg_query("SELECT path_photofiles,rent.idrent,namerent,brandrent,gearboxrent,typerent,nbr_seatrent,pricerent,emailu FROM rent INNER JOIN files ON rent.idrent=files.idrent WHERE brandRent='".$_POST['brand']."' AND gearboxRent='".$_POST['gearbox']."' AND typeRent='".$_POST['category']."' AND nbr_seatRent='".$_POST['nbrPlace']."' AND pricerent<='".$_POST['priceInput']."' ;") or die('Aucun résultat.');
			while ($line = pg_fetch_array($result,null,PGSQL_ASSOC)) {
					$i=0; 
					$tab.="\t<div class='compartments'>";
					$tab.="<p class='descriptionAnnounce'> ";
					foreach ($line as $col_value) {
						$pseudo[$i]=$col_value; // on récupère une case précise par itération, celle contenant le pseudo/nom de l'user
						if($i>1){
							if($i==8) // on arrête la boucle à 8 pour éviter l'affichage du pseudo dans la description mais on empêche pas l'itération précédente
								break;
							else if($i==2)
								$tab.="\t\t<b>$tabName[$i] $col_value</b><br /> <br />\n";
							else if($i==7)
								$tab.="\t\t<b style='color:tomato; font-size:25px;'>$tabName[$i] $col_value $</b> <br />\n";
							else
								$tab.="\t\t$tabName[$i] $col_value <br />\n";
						}
						$i++;
				}
				$tab.="</p>"; // se référer au commentaire en haut pour les indices
				$tab.="<img src='".$pseudo[0]."' style='box-shadow: 0 0 20px 0 rgba(0,0,0,0.5), 0 5px 5px rgba(0,0,0,0.5); border: black groove 4px; width: 230px; height: 150px;'>";
				$tab.="<p class='userProfilAccess'>Utilisateur : <a href='profil.php?ident=".$pseudo[8]."'>".$pseudo[8]."</a></p>";
				$tab.= "<a href='detailedAnnounce.php?psd=".$pseudo[1]."' class='getProfil'>Voir annonce</a>";
				if($_SESSION['login']=='admin'){
					$tab.="<form action='rentalResult.php' method='post'><input name='idRent' type='hidden' value='".$pseudo[1]."'><input type='submit' name='deleteRent' value='DELETE' class='deleter'></form>";
				}
				$tab.="\t</div>\n";
			}
			pg_free_result($result);
			pg_close($dbconn);

			return $tab;
	 	}
	}
	/* Allow to display the detailed part having clicked on the button beside an announce, this part display the entire description of the selected rent*/
	function displayDetailedPart($idRent){

		$dbconn=connectionDB();
		$nameCol=array('Type : ', 'nom : ', 'série : ', 'marque : ', 'Nombre de siège : ', 'Prix : ', 'Transmission : ', 'Puissance moteur : ', 'Type carburant : ', 'Nombre de portes : ', 'Description : ', 'Contact : ');
		$tab=''; 
		$container=array();
		$result=pg_query("SELECT typerent,namerent,serierent,brandrent,nbr_seatrent,pricerent,gearboxrent,horsepowerrent,fuel_typerent,nbr_doorrent,descriptionrent,emailu,path_photofiles FROM rent INNER JOIN files ON rent.idrent=files.idrent WHERE rent.idrent='".$idRent."';") or die("Erreur dans la base de donnée");
		while($l = pg_fetch_array($result,null,PGSQL_ASSOC)){
			$i=0;
			foreach ($l as $val) {  // on fait ce premier forEach pour stocker les valeurs de la ligne dans un tableau container pour pouvoir l'utiliser sur le début de la description HTML
				$container[$i]=$val;
				$i++;
			}
			$i=0;
			$tab.="<h2>".$container[1]."</h2>";
			$tab.="<img src='".$container[12]."' style='box-shadow: 0 0 20px 0 rgba(0,0,0,0.5), 0 5px 5px rgba(0,0,0,0.5); border: black groove 4px; width: 75%; height: 400px; margin-left: 10%;'><hr />";
			$tab.="<div class='details'>";
			$tab.="<h3>Description</h3>";
			$tab.="<p class='paraphUser'>";
			foreach ($l as $val) { // enfin, cette 2ème boucle pour l'intérieur de la description HTML
				if($i<12 && $i!=10 && $i!=1){ // le 12ème est le chemin path image
					$tab.="$nameCol[$i] $val <br />";
				}
				if($i==10){
					$val = str_replace("[\quote]","'",$val);
					$tab.="$nameCol[$i] $val <br />";
				}
				if($i==1) {
					$val = str_replace("[\quote]","'",$val);
					$tab.="$nameCol[$i] $val <br />";
				}
				$i++;
			}
			$tab.="</p>";
		}

		return $tab;
	}
	/* Count the number of picture for the part slide of the detailedPart */
	function numberOfPictureForThisRent(){
		$dbconn=connectionDB();
		$valSend='';
		$req=pg_query("SELECT COUNT(idrent) FROM file2 WHERE idrent='".$_GET['psd']."';") or die("Echec de la requête");
	    while ($l = pg_fetch_array($req,null,PGSQL_ASSOC)) {
			foreach ($l as $val) {
				$valSend=$val;
			}
		}
	    return $valSend; // retourne le nombre de photo pour la location de la page affichée via le $_GET
	}
	/* Allow to get all pictures in relation with the selected rent to display them in a slider */
	function getPicturesForRent(){
		$dbconn=connectionDB();
		$req=pg_query("SELECT path2photofiles FROM file2 WHERE idrent='".$_GET['psd']."' ;");
		$slider='';
        while ($l = pg_fetch_array($req,null,PGSQL_ASSOC)) {
			foreach ($l as $val) {
				$slider.='<img class="mySlides" src="'.$val.'" >';
			}
		}  
		return $slider;
	}
	/* Allow to display the comment part from the estimate table DB */
	function displayCommentInDetailedPart(){
		$comment='';
		$dbconn=connectionDB();
		// 1:notation | 2:titre | 3:date | 4:commentaire | 5:email
		$req=pg_query("SELECT profilimgu,surnameu,notationest,titleest,dateest,commentest FROM estimate INNER JOIN users ON estimate.emailu=users.emailu WHERE idrent='".$_GET['psd']."' ;");
		while ($l = pg_fetch_array($req,null,PGSQL_ASSOC)) {
			$i=1;
			echo '<div class="compartments">';

			foreach ($l as $val) {
				if($i==1)
					echo '<div class="profSide"><img src='.$val.' style="width:70px; height:70px;">';
				else if($i==2)
					echo '<p>'.$val.'</p></div>';
				else if($i==3)
					echo '<div class="comSide"> <p class="notation">'.notation($val).'</p>';
				else if($i==4)
					echo '<h4>'.$val.'</h4>';
				else if($i==5)
					echo '<p class="date">'.$val.'</p>';
				else if($i==6)
					echo '<p class="comment"><br />'.$val.'</p></div>';

				$i++;
			}
			echo '</div>';
		}
	}

	//Regex of autorized characters
	function autorizedChar($strchain, $index){
		//name/surname
		if($index==0)	return preg_match('/^[a-zA-Z-ëéèàù]{1,}$/', $strchain);
		//Phone number/age
		elseif ($index==1)	return preg_match('/^[0-9]{1,}$/', $strchain);
	}

	//Bunch of sql requests to update profil user (with restrictions)
	function profilEdition($id){
		//Mistakes shown to user in order to adapt requests
		$sizeError="";
		//Post transmission
		if(isset($_POST['editvalid'])){
			$dbconn=connectionDB();
			//Name update
			if ($_POST['newname'] != ""){
				//Size check
				if (strlen($_POST['newname']) > 30){
					$sizeError.="<p style='text-align: center; font-weight: bold; color: red;'>Erreur: La taille du nom est limitée à 30 caractères</p>";
				}else{
					//Insure typing is accepted
					if (autorizedChar($_POST['newname'], 0) == 1){
						//Format text
						$_POST['newname'] = ucfirst(strtolower($_POST['newname']));
						pg_query("UPDATE users SET nameu='".$_POST['newname']."' WHERE emailu='".$id."' ") or die('Erreur dans la table users');
					}else{
						$sizeError.="<p style='text-align: center; font-weight: bold; color: red;'>Erreur : Format nom incorrect | a-z àéèù- acceptés</p>";
					}
				}
			}
			//Surname update
			if ($_POST['newsurname'] != ""){
				//Size check
				if (strlen($_POST['newsurname']) > 30){
					$sizeError.="<p style='text-align: center; font-weight: bold; color: red;'>Erreur: La taille du prénom est limitée à 30 caractères</p>";
				}else{
					//Insure typing is accepted
					if (autorizedChar($_POST['newsurname'], 0) == 1){
						//Format text
						$_POST['newsurname'] = ucfirst(strtolower($_POST['newsurname']));
						pg_query("UPDATE users SET surnameu='".$_POST['newsurname']."' WHERE emailu='".$id."' ") or die('Erreur dans la table users');
					}else{
						$sizeError.="<p style='text-align: center; font-weight: bold; color: red;'>Erreur : Format prénom incorrect | a-z àéèù- acceptés</p>";
					}
				}
			}
			//Age update
			if ($_POST['newage'] != ""){
				//Limit check
				if (($_POST['newage'] > 100) || ($_POST['newage'] < 18)){
					$sizeError.="<p style='text-align: center; font-weight: bold; color: red;'>Erreur: Age incorrect</p>";
				}else{
					//Insure typing is accepted
					if (autorizedChar($_POST['newage'], 1) == 1){
						pg_query("UPDATE users SET ageu='".$_POST['newage']."' WHERE emailu='".$id."' ") or die('Erreur dans la table users');
					}else{
						$sizeError.="<p style='text-align: center; font-weight: bold; color: red;'>Erreur : Format age incorrect | [0-9] acceptés</p>";
					}
				}
			}
			//Gender update
			if ($_POST['newgender'] != "nothing"){
				pg_query("UPDATE users SET gender='".$_POST['newgender']."' WHERE emailu='".$id."' ") or die('Erreur dans la table users');
			}
			//Mobile update
			if ($_POST['newtel'] != ""){
				//Size check
				if (strlen($_POST['newtel']) > 20){
					$sizeError.="<p style='text-align: center; font-weight: bold; color: red;'>Erreur: Numéro de télephone incorrect</p>";
				}else{
					//Insure typing id accepted
					if (autorizedChar($_POST['newtel'], 1) == 1){
						pg_query("UPDATE users SET phoneu='".$_POST['newtel']."' WHERE emailu='".$id."' ") or die('Erreur dans la table users');
					}else{
						$sizeError.="<p style='text-align: center; font-weight: bold; color: red;'>Erreur : Format téléphone incorrect | [0-9] acceptés</p>";
					}
				}
			}
			//Password update
			if ($_POST['newpwd'] != ""){
				//Size check
				if (strlen($_POST['newpwd']) > 50){
					$sizeError.="<p style='text-align: center; font-weight: bold; color: red;'>Erreur: Mot de passe trop long, 50 caractères max</p>";
				}elseif (strlen($_POST['newpwd']) < 8){
					$sizeError.="<p style='text-align: center; font-weight: bold; color: red;'>Erreur: Mot de passe trop court, 8 caractères min</p>";
				}else{
					//Check if two fields matches
					if ($_POST['newpwd1'] == $_POST['newpwd']){
						//Crypting password
						$password_hash = crypt($_POST['newpwd'], 'rl');
						pg_query("UPDATE users SET passwordu='".$password_hash."' WHERE emailu='".$id."' ") or die('Erreur dans la table users');
					}else{
						$sizeError.="<p style='text-align: center; font-weight: bold; color: red;'>Erreur: Le deux champs mot de passe doivent correspondre</p>";
					}
				}
			}
			/*Email update
				if ($_POST['newemail'] != ""){
				pg_query("UPDATE users SET emailu='".$_POST['newemail']."' WHERE phoneu='".$_POST['newtel']."' ") or die('Erreur dans la table users');
			}*/

			pg_close($dbconn);
			//No error then redirect
			if ($sizeError == "") $sizeError = 'null';
		}
		return $sizeError;
	}

	//Upload in fils and db à new profil picture for profil user
	function profilImgUpload($id) {
		//Mistakes shown to user in order to adapt requests
		$containError = "";
		//Post transmission
		if(isset($_POST['uploadRequired'])){
			//Check if file selected by user
			if(!empty($_FILES['img']['name'])) {
				//Extension accepted
				$tab = array('jpg', 'png', 'jpeg');
				$infosfile = pathinfo($_FILES['img']['name']);
				$ext = $infosfile['extension'];
				//Check extension accepted
				if(in_array($ext,$tab)) {
					//Upload path
					$path = "./pictures/photo_profil/";
					$nameImage = $id.'.'.$ext;
					$finalPath = $path.$nameImage;
					//Upload in server files
					if(move_uploaded_file($_FILES['img']['tmp_name'], $finalPath)) {
						$dbconn =connectionDB();
						//Update user table
						pg_query("UPDATE users SET profilimgu='".$finalPath."' WHERE emailu='".$id."' ") or die('Erreur dans la table users');
						pg_close($dbconn);
					}else{
						$containError.= "<p style='text-align: center; font-weight: bold; color: red;'>Erreur : Echec de l'upload</p>";
					}
				}else{
					$containError.= "<p style='text-align: center; font-weight: bold; color: red;'>Erreur : Format du fichier non accepté</p>";
				}
			}else {
				$containError.= "<p style='text-align: center; font-weight: bold; color: red;'>Erreur : Veuillez sélectionner une image</p>";
			}
			if ($containError == "") $containError = 'null';
		}
		return $containError;
	}

	//Display active rent on user page
	function profilUserRentDisplay($id){
		$tab='';
		$pseudo=array(); // va prendre les images associées, les pseudos, et idrent (=psd)
		
			$dbconn=connectionDB();
			$picturesRent=array(); 
			$k=0;
			$searchPhoto=pg_query("SELECT path2photofiles FROM file2 INNER JOIN rent ON rent.idrent=file2.idrent") or die('Erreur dans la table File');
			while ($l = pg_fetch_array($searchPhoto,null,PGSQL_ASSOC)) {
				foreach ($l as $val) {
					$picturesRent[$k]=$val;
					$k++;
				}
		}

		/* INDICE $I in the loop  :::::  0 = path, 1 = idrent, 2 = namerent, 3 = brandrent, 4 = gearboxrent, 5 = typerent, 6 = nbr_seatrent, 7 = pricerent, 8 = emailu  */

		$tabName=array('','','','Marque : ', 'Transmission : ', 'Catégorie : ', 'Nombre de sièges : ',' ' );
		$result=pg_query("SELECT path_photofiles,rent.idrent,namerent,brandrent,gearboxrent,typerent,nbr_seatrent,pricerent FROM rent INNER JOIN files ON rent.idrent=files.idrent WHERE emailu='".$id."'") or die('Aucun résultat.');
		while ($line = pg_fetch_array($result,null,PGSQL_ASSOC)) {
			$i=0; // Changer la partie IMAGE via la table 
			$tab.="\t<div class='compartments'>";
			//  <img src='".$picturesRent[1]."' style='box-shadow: 0 0 20px 0 rgba(0,0,0,0.5), 0 5px 5px rgba(0,0,0,0.5); border: black groove 4px; width: 230px; height: 150px;'>";
			$tab.="<p class='descriptionAnnounce'> ";
			foreach ($line as $col_value) {
				$pseudo[$i]=$col_value; // on récupère une case précise par itération, celle contenant le pseudo/nom de l'user
				if($i>1){//////////////////////////// J'AI MIS A 1
					if($i==8) // on arrête la boucle à 8 pour éviter l'affichage du pseudo dans la description mais on empêche pas l'itération précédente
						break;
					else if($i==2)
						$tab.="\t\t<b>$tabName[$i] $col_value</b><br /> <br />\n";
					else if($i==7)
						$tab.="\t\t<b style='color:tomato; font-size:25px;'>$tabName[$i] $col_value $</b> <br />\n";
					else
						$tab.="\t\t$tabName[$i] $col_value <br />\n";
				}
				$i++;
			}
			$tab.="</p>"; // se référer au commentaire en haut pour les indices
			$tab.="<img src='".$pseudo[0]."' style='margin-right : 1%; box-shadow: 0 0 20px 0 rgba(0,0,0,0.5), 0 5px 5px rgba(0,0,0,0.5); border: black groove 4px; width: 230px; height: 150px;'>"; //".$pseudo[0]." enlevé de src
			
			$tab.="<form action='profil.php' method='POST'><input type='hidden' name='rent' value='".$pseudo[2]."' ><input type='submit' name='deleteR' value='Supprimer annonce' class='getProfil' style='margin-bottom : 5%;'></form>";
			deleteThisRent();
			$tab.="<a class='getProfil' href='detailedAnnounce.php?psd=".$pseudo[1]."'>Consulter annonce</a>"; 
			$tab.="\t</div>\n";
		}
		pg_free_result($result);
		pg_close($dbconn);

		return $tab;
	}

	//Delete a rent on profil page
	function deleteThisRent(){
		if(isset($_POST['deleteR'])){
			$dbconn = connectionDB();
			$req=pg_query("SELECT idrent FROM rent WHERE emailu='".$_SESSION['login']."' AND namerent='".$_POST['rent']."'") or die('Échec de la requête : ' . pg_last_error());
			$id = pg_fetch_array($req, null, PGSQL_ASSOC);
			pg_close($dbconn);
			deleteARent($id['idrent']);
			header("Refresh:0; url=profil.php");						
		}
	}

	//Display of own profil user page (from rentalResult.php)
	function profilVisitDisplay($emailvisit){
      $dbconn =connectionDB();
      //Simple collect of user infos
      $req = pg_query("SELECT emailu FROM users WHERE emailu='".$emailvisit."'") or die('Échec de la requête : ' . pg_last_error());
      $array[0] = pg_fetch_array($req, null, PGSQL_ASSOC);

      $req = pg_query("SELECT nameu FROM users WHERE emailu='".$emailvisit."'") or die('Échec de la requête : ' . pg_last_error());
      $array[1] = pg_fetch_array($req, null, PGSQL_ASSOC);

      $req = pg_query("SELECT surnameu FROM users WHERE emailu='".$emailvisit."'") or die('Échec de la requête : ' . pg_last_error());
      $array[2] = pg_fetch_array($req, null, PGSQL_ASSOC);

      $req = pg_query("SELECT ageu FROM users WHERE emailu='".$emailvisit."'") or die('Échec de la requête : ' . pg_last_error());
      $array[3] = pg_fetch_array($req, null, PGSQL_ASSOC);

      $req = pg_query("SELECT gender FROM users WHERE emailu='".$emailvisit."'") or die('Échec de la requête : ' . pg_last_error());
      $array[4] = pg_fetch_array($req, null, PGSQL_ASSOC);

      $req = pg_query("SELECT phoneu FROM users WHERE emailu='".$emailvisit."'") or die('Échec de la requête : ' . pg_last_error());
      $array[5] = pg_fetch_array($req, null, PGSQL_ASSOC);

      $req = pg_query("SELECT profilimgu FROM users WHERE emailu='".$emailvisit."'") or die('Échec de la requête : ' . pg_last_error());
      $array[6] = pg_fetch_array($req, null, PGSQL_ASSOC);
      if ($array[6]['profilimgu'] == "") $array[6]['profilimgu'] = "./pictures/photo_profil/default.png";
      
      pg_close($dbconn);
      return $array;
    }
	
	/*Allow to display an estimate of the rental with stars and the values put in the database */
	function notation($markValue){
		$text='';
		switch ($markValue) {
			case 0:
				$text='';
				break;
			case 1:
				$text='★';
				break;
			case 2:
				$text='★★';
				break;
			case 3:
				$text='★★★';
				break;
			case 4:
				$text='★★★★';
				break;
			case 5:
				$text='★★★★★';
				break;
			default:
				$text='';
				break;
		}
		return $text;
	}
	/* Get the date of the server for the comment part */
	function dateHeure(){
		date_default_timezone_set('UTC');
		$date=date("Y-m-d");                     // 2001-03-10 17:16:18 (le format DATETIME de MySQL)
		return $date;
	}
	/* Allow to display the comment part if an user is connected or not */
	function accessComment(){
		if(empty($_SESSION['login']))
			echo '<p>Veuillez vous <a href="connection.php">connecter</a>.</p>';
		else{ // !!!!!! attention quand le site sera en ligne, $_SERVER['PHP_SELF'] retourne seulement le nom du fichier php sans ses attributs ni nom de domaine etc!!
			echo '<form method="post" action="'.$_SERVER['PHP_SELF'].'?psd='.$_GET['psd'].'" style="text-align: center;">  
                     <label for="title">Veuillez saisir le titre de votre sujet :</label>
                     <br />
                     <input type="text" name="title" required="required">
                     <br />
                     <label for="commentaryArea">
                     Laissez une appréciation pour cette location :</label>
                     <br />
                     <textarea name="commentaryArea" id="commentaryArea" rows="5" cols="80" style="font-size: 20px; padding: 8px; font-family:"times new roman", times, sans-serif;" required="required"></textarea>
                     <br /> 
                       	<input type="radio" name="estimate" value="1" required="required"> 1
 						<input type="radio" name="estimate" value="2"> 2
  						<input type="radio" name="estimate" value="3"> 3
  						<input type="radio" name="estimate" value="4"> 4
  						<input type="radio" name="estimate" value="5"> 5 <br />
                     <input type="submit" name="sendComment" value="Poster votre commentaire">
              </form>';
		}
	}
	/* Allow to send a comment to the server then the database from the client-side */
	function insertComment(){
		$dbconn=connectionDB();
		$req=pg_query("INSERT INTO estimate (dateest,notationest,commentest,emailu,idrent,titleest) VALUES ('".dateHeure()."','".$_POST['estimate']."','".$_POST['commentaryArea']."','".$_SESSION['login']."','".$_GET['psd']."','".$_POST['title']."');");

	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//														       Warehouse managment																		//
	//																																						//
	//					Reste à :		1)Modif css 	2)Gérer date+code cb  		3)Intéragir avec l'historique											//
	//																																						//

	//Get all bank info for warehouse page management useing
	function getBankingInformations($id){
   		$dbconn =connectionDB();
    	//Simple collect of user infos
      	$req = pg_query("SELECT balancewh FROM warehouse WHERE emailu='".$id."'") or die('Échec de la requête : ' . pg_last_error());
      	$array[0] = pg_fetch_array($req, null, PGSQL_ASSOC);

      	$req = pg_query("SELECT credit_cardbi FROM bankinginformations WHERE emailu='".$id."'") or die('Échec de la requête : ' . pg_last_error());
      	$array[1] = pg_fetch_array($req, null, PGSQL_ASSOC);

      	$req = pg_query("SELECT ribbi FROM bankinginformations WHERE emailu='".$id."'") or die('Échec de la requête : ' . pg_last_error());
      	$array[2] = pg_fetch_array($req, null, PGSQL_ASSOC);

      	$req = pg_query("SELECT emailu FROM bankinginformations WHERE emailu='".$id."'") or die('Échec de la requête : ' . pg_last_error());
      	$array[3] = pg_fetch_array($req, null, PGSQL_ASSOC);

      	$req = pg_query("SELECT credit_card_expbi FROM bankinginformations WHERE emailu='".$id."'") or die('Échec de la requête : ' . pg_last_error());
      	$array[4] = pg_fetch_array($req, null, PGSQL_ASSOC);

      	$req = pg_query("SELECT credit_card_codebi FROM bankinginformations WHERE emailu='".$id."'") or die('Échec de la requête : ' . pg_last_error());
      	$array[5] = pg_fetch_array($req, null, PGSQL_ASSOC);

      	pg_close($dbconn);
      	return $array;

    }
	
	//Buy credit with credit card
	function buyMoney($id){
		//Init error var showed to user
		$sizeError = '';
		//If form submit is required
		if(isset($_POST['reqbuymoney'])){
			//Get credit card informations
			$dbconn =connectionDB();
			$req = pg_query("SELECT credit_cardbi FROM bankinginformations WHERE emailu='".$id."'") or die('Échec de la requête : ' . pg_last_error());
			$ccexist = pg_fetch_array($req,null,PGSQL_ASSOC);
			pg_close($dbconn);
			//Check if credit card informations are not empty
			if($ccexist['credit_cardbi'] != ''){
				//Check if user selected a number > 0
				if (autorizedChar($_POST['buynbr'], 1) == 0){
					$sizeError.="<p style='text-align: center; font-weight: bold; color: red;'>Erreur: Veuillez saisir un montant ([0-9] acceptés)</p>";
				//Check if user selected a number < 1000
				}elseif($_POST['buynbr'] > 1000){
					$sizeError.="<p style='text-align: center; font-weight: bold; color: red;'>Erreur: Achat limité à 1000€</p>";
				}else{
					//Update warehouse balance
					$dbconn =connectionDB();
					$req = pg_query("SELECT balancewh FROM warehouse WHERE emailu='".$id."'") or die('Échec de la requête : ' . pg_last_error());
					$currentCredit = pg_fetch_array($req, null, PGSQL_ASSOC);
					$newCredit = ($currentCredit['balancewh']+$_POST['buynbr']);
					pg_query("UPDATE warehouse SET balancewh='".$newCredit."' WHERE emailu='".$id."' ") or die('Erreur dans la table warehouse : ' .pg_last_error());

					//Update historical table
					$date = date("d-m-Y");
					pg_query("INSERT INTO historical(dateh,typeh,emailu,nbr_creditsh) VALUES ('".$date."','buyCredit','".$id."','".$_POST['buynbr']."')") or die('Erreur dans la table historical : ' .pg_last_error());
					pg_close($dbconn);
				}
			}else{
				//Error showed
				$sizeError.="<p style='text-align: center; font-weight: bold; color: red;'>Erreur: Aucune carte bancaire n'est renseignée</p>";
			}
			//Check if error reported
			if ($sizeError == "") $sizeError = 'null';
			else $sizeError.= "<br />";
		}
		return $sizeError;
	}

	//Update credit card informations 
	function changeCreditCard($array_bi){
		//Create a save var of the update display to use it later
		$updateText = "<p style='text-align : center; margin-top: 1%;'><b class='motImportant' style='text-align : center ;' >Carte bancaire : </b>";
		$updateText.= $array_bi[1]['credit_cardbi'];
		/*$updateText.= "<p style='text-align : center;'><b class='motImportant' style='text-align : center ;' >Date expiration : </b>";
		$updateText.= $array_bi[4]['credit_card_expbi'];
		$updateText.= "<p style='text-align : center;'><b class='motImportant' style='text-align : center ;' >Cryptogramme visuel : </b>";
		$updateText.= $array_bi[5]['credit_card_codebi'];*/
		$updateText.= "</p><form action='manageWarehouse.php' method='POST' style='text-align : center ; margin-top : 1%;'><input type='submit' name='editcc' value='Modifier' class='getProfil2'/></form>";

		//Create a save var of the buy credit display to use it later
		$buyCreditText = "<form action='manageWarehouse.php' method='POST' style='text-align : center; margin-top : 1%;'>";
		$buyCreditText.= "<input type='text' name='buynbr' style='width: 11%; height: 10px; margin-left: 26px; margin-right: 2px;'>€";
		$buyCreditText.= "<input type='submit' name='reqbuymoney' value='Acheter du crédit' class='getProfil2' style='margin-left : 2%;' /></form>";

		//Using update display saved
		$result = $updateText; 

		//If edit button is press, ubdate display
		if(isset($_POST['editcc'])){
			//Show the actual credit card informations
			$result = "<p style='text-align : center; margin-top: 1%;'><b class='motImportant' style='text-align : center ;' >Carte bancaire : </b>";
			$result.= $array_bi[1]['credit_cardbi'];
			//Form for new banc informations
			$result.= "</p><form action='manageWarehouse.php' method='POST' style='text-align : center ; margin-top : 1%;'><input type='text' name='newcc' style='width: 17%; height: 10px;'>";
			$result.= "<p><input type='submit' name='reqcc' value='Modifier la carte bancaire' class='getProfil2'/></p></form>";

		//If validate update button is press -> don't show buying money form
		}elseif(isset($_POST['reqcc'])) {
			//Check if format isn't ok
			if((strlen($_POST['newcc']) != 16) || (autorizedChar($_POST['newcc'], 1) == 0)){
				//Show error to the user
				$result = "<p style='text-align: center; font-weight: bold; color: red; margin-bottom : 1%;'>Erreur: Numéro de carte incorrect</p>";
				//Using saved init text
				$result.= $updateText;

				//Using saved var of buying display form
				$result.= $buyCreditText;
			}else{
				//Update bank informations
				$dbconn =connectionDB();
	      		pg_query("UPDATE bankinginformations SET credit_cardbi='".$_POST['newcc']."' WHERE emailu='".$array_bi[3]['emailu']."' ") or die('Erreur dans la table users');
				$req = pg_query("SELECT credit_cardbi FROM bankinginformations WHERE emailu='".$array_bi[3]['emailu']."'") or die('Échec de la requête : ' . pg_last_error());
				$newcc = pg_fetch_array($req, null, PGSQL_ASSOC);
				pg_close($dbconn);

				//Show new bank infos
				$result = "<p style='text-align : center;'><b class='motImportant' style='text-align : center ;' >Carte bancaire : </b>";
				$result.= $newcc['credit_cardbi'];
				$result.= "<form action='manageWarehouse.php' method='POST' style='text-align : center; margin-top : 1%;'><input type='submit' name='editcc' style='background:url(/font/editbutton.png) no-repeat;' /></form></p>";

				//Using saved var of buying display form
				$result.= $buyCreditText;
			} 
		}else{
			//Using saved var of buying display form
			$result.= $buyCreditText;
		}

		return $result;
	}

	//Recover credits on own bank account
	function getMoneyBack($id){
		$result = '';
		//If recover is required
		if(isset($_POST['moneyback'])){
			$dbconn =connectionDB();
			$req = pg_query("SELECT ribbi FROM bankinginformations WHERE emailu='".$id."'") or die('Échec de la requête : ' . pg_last_error());
			$ribexist = pg_fetch_array($req,null,PGSQL_ASSOC);
			pg_close($dbconn);
			//Check if rib informations are not empty
			if($ribexist['ribbi'] != ''){
				//So update warehouse to 0
				$dbconn =connectionDB();
				$req = pg_query("SELECT balancewh FROM warehouse WHERE emailu='".$id."'") or die('Échec de la requête : ' . pg_last_error());
				$currentCredit = pg_fetch_array($req, null, PGSQL_ASSOC);

				pg_query("UPDATE warehouse SET balancewh=0 WHERE emailu='".$id."' ") or die('Erreur dans la table warehouse');	

				//Update historical value
				$date = date("d-m-Y");
				pg_query("INSERT INTO historical(dateh,typeh,emailu,nbr_creditsh) VALUES ('".$date."','recoverCredit','".$id."','".$currentCredit['balancewh']."')") or die('Erreur dans la table historical : ' .pg_last_error());
				pg_close($dbconn);

				//Show precess worked to user
				$result = "<p style='text-align: center; font-weight: bold; color: red; margin-bottom : 1%;'>Votre crédit a bien été transféré sur votre compte bancaire</p>";
			}else{
				//Error showed
				$result.="<p style='text-align: center; font-weight: bold; color: red;'>Erreur: Aucun RIB n'est renseignée</p>";
			}
		}
		return $result;
	}

	//Update rib informations 
	function changeRib($array_bi){
		//Create a save var of the update display to use it later
		$updateText = "<p style='text-align : center; margin-top: 1%;'><b class='motImportant' style='text-align : center ;' >RIB : </b>";
		$updateText.= $array_bi[2]['ribbi'];
		$updateText.= "</p><form action='manageWarehouse.php' method='POST' style='text-align : center ; margin-top : 1%;'><input type='submit' name='editRib' class='getProfil2' value='Modifier' /></form>";

		//Create a save var of the recover display to use it later
		$recoverCreditText =  "<form action='manageWarehouse.php' method='POST' style='text-align : center; margin-top : 1%;'><input type='submit' name='moneyback' value='Retirer son crédit' class='getProfil2'/></form>";

		//Using update display saved
		$result = $updateText;

		//If edit button is press, ubdate display
		if(isset($_POST['editRib'])){
			//Display rib update showed
			$result = "<p style='text-align : center; margin-top: 1%;'><b class='motImportant' style='text-align : center ;' >RIB : </b>";
			$result.= $array_bi[2]['ribbi'];
			$result.= "</p><form action='manageWarehouse.php' method='POST' style='text-align : center ; margin-top : 1%;'><input type='text' name='newrib' style='width: 21%; height: 10px;'>";
			$result.= "<p><input type='submit' name='reqRib' value='Modifier le RIB' class='getProfil2'/></p></form>";
		
		//If validate update button is press -> don't show recover money form
		}elseif(isset($_POST['reqRib'])) {
			//Check if format rib is ok
			if((strlen($_POST['newrib']) != 23) || (autorizedChar($_POST['newrib'], 1) == 0)){
				//Show error to user
				$result = "<p style='text-align: center; font-weight: bold; color: red; margin-bottom : 1%;'>Erreur: Format du RIB incorrect</p>";

				//Using saved init text
				$result.= $updateText;

				//Using saved var of recover display form
				$result.= $recoverCreditText;
			}else{
				//Updating rib informations
				$dbconn = connectionDB();
	      		pg_query("UPDATE bankinginformations SET ribbi='".$_POST['newrib']."' WHERE emailu='".$array_bi[3]['emailu']."' ") or die('Erreur dans la table users');
				$req = pg_query("SELECT ribbi FROM bankinginformations WHERE emailu='".$array_bi[3]['emailu']."'") or die('Échec de la requête : ' . pg_last_error());
	      		$newrib = pg_fetch_array($req, null, PGSQL_ASSOC);
				pg_close($dbconn);

				//Display new rib
				$result = "<p style='text-align : center;'><b class='motImportant' style='text-align : center ;' >RIB : </b>";
				$result.= $newrib['ribbi'];
				$result.= "<form action='manageWarehouse.php' method='POST' style='text-align : center; margin-top : 1%;'><input type='submit' name='editRib' style='background:url(/font/editbutton.png) no-repeat;' /></form></p>";

				//Using saved var of recover display form
				$result.= $recoverCreditText;
			}
		}else{
			//Using saved var of recover display form
			$result.= $recoverCreditText;
		}
		return $result;
	}
	//																																								//
	//															warehouse managment end																				//
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//Get last transacitons in warehouse
	function getHistoricalWarehouse($id){
		$dbconn = connectionDB();
		$i=0;
		$j=0;
		$result = pg_query("SELECT dateh,nbr_creditsh FROM historical WHERE emailu='".$id."' AND typeh='buyCredit';") or die("Erreur dans la base de donnée historical : " . pg_last_error());
		while($l = pg_fetch_array($result,null,PGSQL_ASSOC)){		
			$containerBuy[$i] = $l; 
			$i++;		
		}
		$result = pg_query("SELECT dateh,nbr_creditsh FROM historical WHERE emailu='".$id."' AND typeh='recoverCredit';") or die("Erreur dans la base de donnée historical : " . pg_last_error());
		while($l = pg_fetch_array($result,null,PGSQL_ASSOC)){		
			$containerRec[$j] = $l; 
			$j++;		
		}
		echo '<h4 class="spaceHBuy">Derniers achats</h4>';
		echo '<h4 class="spaceHRec">Derniers transferts</h4>';

		$lim = $i-5;
		if ($i >= $j) {
			$max = $i;
		}else{
			$max = $j;
		}

		while(($max > $lim) && ($max > 0) ){
			$max--;
			$i--;
			$j--;
			echo "<br />";	
			if ($i<0){
				$buy = '<br /><p class="spaceBuy" ></p>';
				$rec = '<p class="spaceRec">Dépot de '.$containerRec[$j]['nbr_creditsh'].' crédits le '.$containerRec[$j]['dateh'].'</p>';

			}elseif ($j<0) {
				$buy = '<br /><p class="spaceBuy" >Achat de '.$containerBuy[$i]['nbr_creditsh'].' crédits le '.$containerBuy[$i]['dateh'].'</p>';
				$rec = '<p class="spaceRec" ></p>';
			}else{
				$buy = '<br /><p class="spaceBuy" >Achat de '.$containerBuy[$i]['nbr_creditsh'].' crédits le '.$containerBuy[$i]['dateh'].'</p>';
				$rec = '<p class="spaceRec">Dépot de '.$containerRec[$j]['nbr_creditsh'].' crédits le '.$containerRec[$j]['dateh'].'</p>';
			}

			echo $buy;
			echo $rec;		
		}
		pg_close($dbconn);
	}

	/* Allow to the admin to delete a rent if this one doesn't respect the site rules */
	function deleteARent($val){
		$dbconn=connectionDB();
		$req1=pg_query("DELETE FROM files WHERE idrent='".$val."';");
		$req2=pg_query("DELETE FROM file2 WHERE idrent='".$val."';");
		$req3=pg_query("DELETE FROM estimate WHERE idrent='".$val."';");
		$req4=pg_query("DELETE FROM historical WHERE idrent='".$val."';");

		$req=pg_query("DELETE FROM rent WHERE idrent='".$val."';");
	}
	/* In the select form in the index page, this function parse the database to take the brand inserted by the users */
	function displayBrandForSelectOption(){
		$dbconn=connectionDB();
		$req=pg_query("SELECT brandrent FROM rent;");
		$brand=array();
		$i=0;
		while ($l = pg_fetch_array($req,null,PGSQL_ASSOC)) {
			foreach ($l as $val) {
				$brand[$i]=$val;
			}
			$i++;
		}
		$brandSort=array_unique($brand);
		$text='';
		foreach ($brandSort as $val) {
			$text.='<option value="'.$val.'">'.$val.'</option>';
		}
		return $text;
	}
	/*When an estimate is done */
	if(isset($_POST['sendComment'])){
		insertComment();
	}
	/* When the admin wants to delete a rent */
	if(isset($_POST['deleteRent'])){
		deleteARent($_POST['idRent']);
	}
	
	
?>
