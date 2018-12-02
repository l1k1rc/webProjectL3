<?php 
	session_start();

	require('connectDatabase.php');
	/*Allows  to display each division with their compartments after the filter in he home page */
	function searchByFilter(){
		$tab='';
		$pseudo=array(); // va prendre les images associées, les pseudos, et idrent (=psd)
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
			/* INDICE $I dans la boucle  :::::  0 = path, 1 = idrent, 2 = namerent, 3 = brandrent, 4 = gearboxrent, 5 = typerent, 6 = nbr_seatrent, 7 = pricerent, 8 = emailu  */																					
			/*********************************************************************************************************/
			$tabName=array('','','','Marque : ', 'Transmission : ', 'Catégorie : ', 'Nombre de sièges : ',' ' );
			$result=pg_query("SELECT path_photofiles,rent.idrent,namerent,brandrent,gearboxrent,typerent,nbr_seatrent,pricerent,emailu FROM rent INNER JOIN files ON rent.idrent=files.idrent WHERE brandRent='".$_POST['brand']."' AND gearboxRent='".$_POST['gearbox']."' AND typeRent='".$_POST['category']."' AND nbr_seatRent='".$_POST['nbrPlace']."' ;") or die('Aucun résultat.');
			while ($line = pg_fetch_array($result,null,PGSQL_ASSOC)) {
					$i=0; // Changer la partie IMAGE via la table 
					$tab.="\t<div class='compartments'>";
					      //  <img src='".$picturesRent[1]."' style='box-shadow: 0 0 20px 0 rgba(0,0,0,0.5), 0 5px 5px rgba(0,0,0,0.5); border: black groove 4px; width: 230px; height: 150px;'>";
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
				if($i<12){ // le 12ème est le chemin path image
					$tab.="$nameCol[$i] $val <br />";
				}
				$i++;
			}
			$tab.="</p>";
		}

		return $tab;
	}


	function displayDetailedPartCS($idcarshare){

		$dbconn=connectionDB();
		$nameCol=array('Type : ', 'Nom : ', 'Point de départ : ', 'Destination : ', 'Nombre de places : ', 'Description : ', 'Prix : ', 'Contact : ');
		$tab=''; 
		$container=array();
		$result=pg_query("SELECT typecs,title,departure,destination,nbr_seatcs,descriptioncs,emailu,path_photofiles FROM carshare INNER JOIN filecs ON carshare.idcarshare=filecs.idcarshare WHERE carshare.idcarshare='".$idcarshare."';") or die(pg_last_error());
		while($l = pg_fetch_array($result,null,PGSQL_ASSOC)){
			$i=0;
			foreach ($l as $val) {  // on fait ce premier forEach pour stocker les valeurs de la ligne dans un tableau container pour pouvoir l'utiliser sur le début de la description HTML
				$container[$i]=$val;
				$i++;
			}
			$i=0;
			$tab.="<h2>".$container[1]."</h2>";
			$tab.="<img src='".$container[7]."' style='box-shadow: 0 0 20px 0 rgba(0,0,0,0.5), 0 5px 5px rgba(0,0,0,0.5); border: black groove 4px; width: 75%; height: 400px; margin-left: 10%;'><hr />";
			$tab.="<div class='details'>";
			$tab.="<h3>Description</h3>";
			$tab.="<p class='paraphUser'>";
			foreach ($l as $val) { // enfin, cette 2ème boucle pour l'intérieur de la description HTML
				if($i<8){ // le 12ème est le chemin path image
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
	/***********************************************************************************************/
	function getPicturesForCarpool(){
		$dbconn=connectionDB();
		$req=pg_query("SELECT path2photofiles FROM filecs2 WHERE idcarshare='".$_GET['psd']."' ;");
		$slider='';
        while ($l = pg_fetch_array($req,null,PGSQL_ASSOC)) {
			foreach ($l as $val) {
				$slider.='<img class="mySlides" src="'.$val.'" >';
			}
		}  
		return $slider;
	}

	function displayCommentInDetailedPart(){
		$comment='';
		$dbconn=connectionDB();
		// 1:notation | 2:titre | 3:date | 4:commentaire | 5:email
		$req=pg_query("SELECT notationest,dateest,commentest,emailu FROM estimate WHERE id_commentest='".$_GET['psd']."' ;");
		while ($l = pg_fetch_array($req,null,PGSQL_ASSOC)) {
			$i=1;
			echo '<div class="compartments">';

			foreach ($l as $val) {
				if($i==1)
					echo '<p class="notation">'.notation($val).'</p>';
				else if($i==2)
					echo '<h4>'.$val.'</h4>';
				else if($i==3)
					echo '<p class="date">'.$val.'</p>';
				else if($i==4)
					echo '<p class="comment"><br />'.$val.'</p>';

				$i++;
			}
			echo '</div>';
		}
	}
/**********************************************************************************************************/
	function displayCommentInDetailedPartForCarpool(){
		$comment='';
		$dbconn=connectionDB();
		// 1:notation | 2:titre | 3:date | 4:commentaire | 5:email
		$req=pg_query("SELECT notationest,dateest,commentest,emailu FROM estimateCs WHERE id_commentest='".$_GET['psd']."' ;");
		while ($l = pg_fetch_array($req,null,PGSQL_ASSOC)) {
			$i=1;
			echo '<div class="compartments">';

			foreach ($l as $val) {
				if($i==1)
					echo '<p class="notation">'.notation($val).'</p>';
				else if($i==2)
					echo '<h4>'.$val.'</h4>';
				else if($i==3)
					echo '<p class="date">'.$val.'</p>';
				else if($i==4)
					echo '<p class="comment"><br />'.$val.'</p>';

				$i++;
			}
			echo '</div>';
		}
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
/**********************************************************************************************/
	function accessCommentCs(){
		if(empty($_SESSION['login']))
			echo '<p>Veuillez vous <a href="connection.php">connecter</a>.</p>';
		else{ // !!!!!! attention quand le site sera en ligne, $_SERVER['PHP_SELF'] retourne seulement le nom du fichier php sans ses attributs ni nom de domaine etc!!
			echo '<form method="post" action="'.$_SERVER['PHP_SELF'].'?psd='.$_GET['psd'].'" style="text-align: center;">  
                     <label for="title">Veuillez saisir le titre de votre sujet :</label>
                     <br />
                     <input type="text" name="title" required="required">
                     <br />
                     <label for="commentaryArea">
                     Laissez une appréciation pour ce covoiturage :</label>
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
	function deleteARent($val){
		$dbconn=connectionDB();
		$req1=pg_query("DELETE FROM files WHERE idrent='".$val."';");
		$req2=pg_query("DELETE FROM file2 WHERE idrent='".$val."';");
		$req3=pg_query("DELETE FROM estimate WHERE idrent='".$val."';");
		$req4=pg_query("DELETE FROM historical WHERE idrent='".$val."';");

		$req=pg_query("DELETE FROM rent WHERE idrent='".$val."';");
	}
	if(isset($_POST['sendComment'])){
		insertComment();
	}
	if(isset($_POST['deleteRent'])){
		deleteARent($_POST['idRent']);
	}


	/************************************************************************************************/

function searchByFilterCarpool(){
		$tab='';
		$pseudo=array(); // va prendre les images associées, les pseudos, et idrent (=psd)
		if(isset($_POST['validcs'])){
			$dbconn=connectionDB();
			$picturesCarpool=array(); 
			$k=0;
			$searchPhoto=pg_query("SELECT path2photofiles FROM filecs2 INNER JOIN carshare ON carshare.idcarshare=filecs2.idcarshare") or die('Erreur dans la table File');
			while ($l = pg_fetch_array($searchPhoto,null,PGSQL_ASSOC)) {
				foreach ($l as $val) {
					$picturesCarpool[$k]=$val;
					$k++;
				}
			}

			/* INDICE $I dans la boucle  :::::  0 = path, 1 = idrent, 2 = namerent, *3 = brandrent, *4 = gearboxrent, *5 = typerent, *6 = nbr_seatrent, 7 = pricerent, 8 = emailu  */

			/* INDICE $I dans la boucle  :::::  0 = path, 1 = idcarshare, 2 = title, 3=destination, 4=departure, 5 = typecs, 6 = nbr_seatcs, 7 = pricecs, 8 = emailu  */																					
			/*********************************************************************************************************/
			/*$result=pg_query("SELECT path_photofiles,rent.idrent,namerent,brandrent,gearboxrent,typerent,nbr_seatrent,pricerent,emailu FROM rent INNER JOIN files ON rent.idrent=files.idrent WHERE brandRent='".$_POST['brand']."' AND gearboxRent='".$_POST['gearbox']."' AND typeRent='".$_POST['category']."' AND nbr_seatRent='".$_POST['nbrPlace']."' ;") or die('Aucun résultat.');
			carshare.idcarchare = filecs.idcarshare

			*/


			$tabName=array('','','','Type : ', 'Nombre de place : ','Point de départ :','Destination : ' );
			$result=pg_query("SELECT path_photofiles,carshare.idcarshare,title,typecs,nbr_seatcs,departure,destination,pricecs,emailu FROM carshare INNER JOIN filecs ON carshare.idcarshare=filecs.idcarshare WHERE nbr_seatcs>='".$_POST['places']."' AND destination='".$_POST['dst']."' AND departure='".$_POST['station']."' ;") or die('Aucun résultat.');
			while ($line = pg_fetch_array($result,null,PGSQL_ASSOC)) {
					$i=0; // Changer la partie IMAGE via la table 
					$tab.="\t<div class='compartments'>";
					$tab.="<p class='descriptionAnnounce'> ";
					foreach ($line as $col_value) {
						$pseudo[$i]=$col_value; // on récupère une case précise par itération, celle contenant le pseudo/nom de l'user
						if($i>1){
							if($i==8) // on arrête la boucle à 8 pour éviter un débordement
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
				$tab.= "<a href='detailedAnnounceCS.php?psd=".$pseudo[1]."' class='getProfil'>Voir annonce</a>";
				if($_SESSION['login']=='admin'){
					$tab.="<form action='carpoolResult.php' method='post'><input name='idcarshare' type='hidden' value='".$pseudo[1]."'><input type='submit' name='deleteCarpool' value='DELETE' class='deleter'></form>";
				}
				$tab.="\t</div>\n";
			}
			pg_free_result($result);
			pg_close($dbconn);

			return $tab;
	 	}
	}
	
	
?>
