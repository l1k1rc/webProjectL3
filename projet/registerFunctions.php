<?php 
	require ('displayFunctions.php');
	function sayWarning($deleted=''){
        echo '<body onLoad="alert( '.$deleted.')">';
        echo '<meta http-equiv="refresh" content="0;URL=register.php">';
    }


	if(isset($_POST['validRegister']) ){
		// ici on se connecte à la db de guillaume donc modifier la dbname le user et la password pour vous co chez vous
		$dbconn = connectionDB();
	    $path = 'pictures/photo_profil/'.basename($_FILES['photo']['name']);
		$name = $_POST['name'];
		$surname = $_POST['surname'];
		$age = $_POST['age'];
		$email = $_POST['mail'];
		$sexe = $_POST['sexe'];
		$phone = $_POST['phone'];
		$password = $_POST['password'];
		$password_hash = crypt($password, 'rl');

		$date = date("Y-m-d");

		$query = 'SELECT emailU FROM users';
		$result = pg_query($query) or die('Échec de la requête : ' . pg_last_error());
		$tab = array();
		$i=0;
		$j=0;
		$k=0;
		while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
    		foreach ($line as $col_value) {
    			$tab[$i]=$col_value;
    			$i++;
    		}
 
		}
		
		while(($k==0) && ($j<$i)){
			if (strcmp($email, $tab[$j])==0) {
				$k=2;
				echo '<body onLoad="alert(\'Cet email est déjà utilisée\')">';
	    		echo '<meta http-equiv="refresh" content="0;URL=register.php">';

			}
			else {
				$j++;
			}
		}


		if ($k!=2) {
			if ($_FILES['photo']['size']<=5000000) {
				$infosfichier = pathinfo($_FILES['photo']['name']);
				$extensionsupload = $infosfichier['extension'];
				$extension_allowed = array('jpg','jpeg','png');
				if (in_array($extensionsupload, $extension_allowed)) {
					move_uploaded_file($_FILES['photo']['tmp_name'], $path);

					$requete1 = "INSERT INTO users VALUES('$email', '$name', '$surname', '$age', '$sexe', '$phone', '$password_hash', '$path')";
					$resultat = pg_query($requete1) or die('ERREUR SQL : '. $requete1 . 	pg_last_error());
					$requete2 = "INSERT INTO warehouse (balanceWh, date_exchangeWh, emailU) VALUES ('20', '$date', '$email')";
					$resultat2 = pg_query($requete2) or die('ERREUR SQL : '. $requete2 .    pg_last_error());
					echo '<body onLoad="alert(\'Enregistrement de votre compte effectué\')">';
			    	echo '<meta http-equiv="refresh" content="0;URL=profil.php">';
				}
				else{
					echo '<body onLoad="alert(\'Mauvaise extension de photo\')">';
			    	echo '<meta http-equiv="refresh" content="0;URL=register.php">';
				}
			}
			else{
				echo '<body onLoad="alert(\'Taille de la photo trop volumineuse\')">';
			    echo '<meta http-equiv="refresh" content="0;URL=register.php">';
			}
			

		}


	}

	if (isset($_POST['enLigne'])){
		$dbconn = connectionDB();
		$type = $_POST['type'];
		$couleur = $_POST['couleur'];
		$marque = $_POST['marque'];
		$modele = $_POST['modele'];
		$kilometer = $_POST['kilometer'];
		$title = $_POST['titleloc'];
		$seat = $_POST['places'];
		$door = $_POST['portes'];
		$horseP = $_POST['puissance'];
		$gearbox = $_POST['boite'];
		$fuel = $_POST['carburant'];
		$emailloc = $_POST['email'];
		$duree = $_POST['duree']." semaines";
		$price = $_POST['prix'];
		$commentary = $_POST['commentaryArea'];
		$path = 'pictures/photo_location/'.basename($_FILES['image']['name']);
		$path1 = 'pictures/photo_location/'.basename($_FILES['image1']['name']);
		$path2 = 'pictures/photo_location/'.basename($_FILES['image2']['name']);
		$path3 = 'pictures/photo_location/'.basename($_FILES['image3']['name']);
		$date = date("Y-m-d");


		$requet = "SELECT emailU FROM rent WHERE typeRent='$type' AND brandRent='$marque' AND kilometerRent='$kilometer' AND nameRent='$title' AND serieRent='$modele'";
		$resultat = pg_query($requet) or die('ERREUR SQL : '. $requet . 	pg_last_error());
		$emailuti='';
		while ($l = pg_fetch_array($resultat,null,PGSQL_ASSOC)) {
			foreach ($l as $val) {
				$emailuti=$val;
			}
		}
		$val1 = (string) $emailloc;
		$val2 = (string) $emailuti;

		if ($val1 === $val2) {
			echo '<body onLoad="alert(\'Vous avez déjà postez une annonce du même type !\')">';
		    echo '<meta http-equiv="refresh" content="0;URL=location.php">';
		}

		else{
			
			if (($_FILES['image']['size']<=5000000) && ($_FILES['image1']['size']<=5000000) && ($_FILES['image2']['size']<=5000000) && ($_FILES['image3']['size']<=5000000)) {
				$infofichier = pathinfo($_FILES['image']['name']);
				$infofichier1 = pathinfo($_FILES['image1']['name']);
				$infofichier2 = pathinfo($_FILES['image2']['name']);
				$infofichier3 = pathinfo($_FILES['image3']['name']);
				$extensionsupload = $infofichier['extension'];
				$extensionsupload1 = $infofichier1['extension'];
				$extensionsupload2 = $infofichier2['extension'];
				$extensionsupload3 = $infofichier3['extension'];
				$extension_allowed = array('jpg','jpeg','png');
				if (in_array($extensionsupload, $extension_allowed)) {
					if (in_array($extensionsupload1, $extension_allowed)) {
						if (in_array($extensionsupload2, $extension_allowed)) {
							if (in_array($extensionsupload3, $extension_allowed)) {
								move_uploaded_file($_FILES['image']['tmp_name'], $path);
								move_uploaded_file($_FILES['image1']['tmp_name'], $path1);
								move_uploaded_file($_FILES['image2']['tmp_name'], $path2);
								move_uploaded_file($_FILES['image3']['tmp_name'], $path3);
								$requete3 = "INSERT INTO rent(typeRent, kilometerRent, conditionRent, nameRent, serieRent, brandRent, availabilityRent, priceRent, horsePowerRent, gearboxRent, nbr_seatRent,fuel_typeRent, nbr_doorRent, descriptionRent, emailU) VALUES ('$type','$kilometer','$couleur','$title','$modele','$marque','$duree','$price','$horseP','$gearbox','$seat','$fuel','$door','$commentary','$emailloc')";
								$result = pg_query($requete3) or die('ERREUR SQL : '. $requete3 . 	pg_last_error());
								$requete4 = "SELECT idRent FROM rent WHERE typeRent='$type' AND brandRent='$marque' AND kilometerRent='$kilometer' AND nameRent='$title' AND serieRent='$modele'";
								$result1 = pg_query($requete4) or die('ERREUR SQL : '. $requete4 . 	pg_last_error());
								$idrent=0;
								while ($l = pg_fetch_array($result1,null,PGSQL_ASSOC)) {
									foreach ($l as $val) {
										$idrent=$val;
									}
								}  
								$requete5 = "INSERT INTO files(path_photofiles, date_createfiles, idRent) VALUES ('$path','$date','$idrent')";
								$result2 = pg_query($requete5) or die('ERREUR SQL : '. $requete5 . 	pg_last_error());

								$requete6 = "INSERT INTO file2(path2photofiles, idRent) VALUES ('$path1','$idrent')";
								$result3 = pg_query($requete6) or die('ERREUR SQL : '. $requete6 . 	pg_last_error());
								$requete7 = "INSERT INTO file2(path2photofiles, idRent) VALUES ('$path2','$idrent')";
								$result4 = pg_query($requete7) or die('ERREUR SQL : '. $requete7 . 	pg_last_error());
								$requete8 = "INSERT INTO file2(path2photofiles, idRent) VALUES ('$path3','$idrent')";
								$result5 = pg_query($requete8) or die('ERREUR SQL : '. $requete8 . 	pg_last_error());
		    					echo '<body onLoad="alert(\'Enregistrement de la location effectuée\')">';
		    					echo '<meta http-equiv="refresh" content="0;URL=rentalResult.php">';
							}
							else {
								echo '<body onLoad="alert(\'Erreur extension image 3\')">';
		    					echo '<meta http-equiv="refresh" content="0;URL=location.php">';
							}
						}
						else {
							echo '<body onLoad="alert(\'Erreur extension image 2\')">';
			    			echo '<meta http-equiv="refresh" content="0;URL=location.php">';
						}
					}
					else {
						echo '<body onLoad="alert(\'Erreur extension image 1\')">';
			    		echo '<meta http-equiv="refresh" content="0;URL=location.php">';
					}			
				}
				else {
					echo '<body onLoad="alert(\'Erreur extension image principale\')">';
			    	echo '<meta http-equiv="refresh" content="0;URL=location.php">';
				}
			}
			else {
				echo '<body onLoad="alert(\'Erreur images trop volumineuses\')">';
			    echo '<meta http-equiv="refresh" content="0;URL=location.php">';
			}
		}
		

	}
/*********************************************************************************************/
	if (isset($_POST['enLigne2'])){
		$dbconn = connectionDB();

		$type = $_POST['type'];
		$title = $_POST['titleCarPool'];
		$seat = $_POST['places'];
		$destination = $_POST['destination'];
		$departure = $_POST['departure'];
		$email = $_POST['email'];
		$price = $_POST['price'];
		$commentary = $_POST['commentaryArea'];

		$path = 'pictures/photo_location/'.basename($_FILES['image']['name']);
		$path1 = 'pictures/photo_location/'.basename($_FILES['image1']['name']);
		$path2 = 'pictures/photo_location/'.basename($_FILES['image2']['name']);
		$path3 = 'pictures/photo_location/'.basename($_FILES['image3']['name']);

		$requet = "SELECT emailu FROM carshare WHERE typecs='$type' AND destination='$destination' AND departure='$departure' AND title='$title' AND nbr_seatcs='$seat'";
		$resultat = pg_query($requet) or die('ERREUR SQL : '. $requet . 	pg_last_error());
		$emailuti='';
		while ($l = pg_fetch_array($resultat,null,PGSQL_ASSOC)) {
			foreach ($l as $val) {
				$emailuti=$val;
			}
		}
		$val1 = (string) $email;
		$val2 = (string) $emailuti;

		if ($val1 === $val2) {
			echo '<body onLoad="alert(\'Vous avez déjà postez une annonce du même type !\')">';
		    echo '<meta http-equiv="refresh" content="0;URL=location.php">';
		}

		else{
			
			if (($_FILES['image']['size']<=5000000) && ($_FILES['image1']['size']<=5000000) && ($_FILES['image2']['size']<=5000000) && ($_FILES['image3']['size']<=5000000)) {
				$infofichier = pathinfo($_FILES['image']['name']);
				$infofichier1 = pathinfo($_FILES['image1']['name']);
				$infofichier2 = pathinfo($_FILES['image2']['name']);
				$infofichier3 = pathinfo($_FILES['image3']['name']);
				$extensionsupload = $infofichier['extension'];
				$extensionsupload1 = $infofichier1['extension'];
				$extensionsupload2 = $infofichier2['extension'];
				$extensionsupload3 = $infofichier3['extension'];
				$extension_allowed = array('jpg','jpeg','png');
				if (in_array($extensionsupload, $extension_allowed)) {
					if (in_array($extensionsupload1, $extension_allowed)) {
						if (in_array($extensionsupload2, $extension_allowed)) {
							if (in_array($extensionsupload3, $extension_allowed)) {
								move_uploaded_file($_FILES['image']['tmp_name'], $path);
								move_uploaded_file($_FILES['image1']['tmp_name'], $path1);
								move_uploaded_file($_FILES['image2']['tmp_name'], $path2);
								move_uploaded_file($_FILES['image3']['tmp_name'], $path3);
								$requete3 = "INSERT INTO carshare(title, destination, departure, typecs, nbr_seatcs, pricecs, descriptioncs, emailu) VALUES ('$title','$destination','$departure','$type','$seat','$price','$commentary','$email')";
								$result = pg_query($requete3) or die('ERREUR SQL : '. $requete3 . 	pg_last_error());
								$requete4 = "SELECT idcarshare FROM carshare WHERE typecs='$type' AND destination='$destination' AND departure='$departure' AND title='$title' AND nbr_seatcs='$seat'";
								$result1 = pg_query($requete4) or die('ERREUR SQL : '. $requete4 . 	pg_last_error());
								$idcs=0;
								while ($l = pg_fetch_array($result1,null,PGSQL_ASSOC)) {
									foreach ($l as $val) {
										$idcs=$val;
									}
								}
								$requete5 = "INSERT INTO filecs(path_photofiles, idcarshare) VALUES ('$path','$idcs')";
								$result2 = pg_query($requete5) or die('ERREUR SQL : '. $requete5 . 	pg_last_error());

								$requete6 = "INSERT INTO filecs2(path2photofiles, idcarshare) VALUES ('$path1','$idcs')";
								$result3 = pg_query($requete6) or die('ERREUR SQL : '. $requete6 . 	pg_last_error());
								$requete7 = "INSERT INTO filecs2(path2photofiles, idcarshare) VALUES ('$path2','$idcs')";
								$result4 = pg_query($requete7) or die('ERREUR SQL : '. $requete7 . 	pg_last_error());
								$requete8 = "INSERT INTO filecs2(path2photofiles, idcarshare) VALUES ('$path3','$idcs')";
								$result5 = pg_query($requete8) or die('ERREUR SQL : '. $requete8 . 	pg_last_error());
		    					echo '<body onLoad="alert(\'Enregistrement du covoiturage effectué\')">';
		    					echo '<meta http-equiv="refresh" content="0;URL=carpoolResult.php">';
							}
							else {
								echo '<body onLoad="alert(\'Erreur extension image 3\')">';
		    					echo '<meta http-equiv="refresh" content="0;URL=location.php">';
							}
						}
						else {
							echo '<body onLoad="alert(\'Erreur extension image 2\')">';
			    			echo '<meta http-equiv="refresh" content="0;URL=location.php">';
						}
					}
					else {
						echo '<body onLoad="alert(\'Erreur extension image 1\')">';
			    		echo '<meta http-equiv="refresh" content="0;URL=location.php">';
					}			
				}
				else {
					echo '<body onLoad="alert(\'Erreur extension image principale\')">';
			    	echo '<meta http-equiv="refresh" content="0;URL=location.php">';
				}
			}
			else {
				echo '<body onLoad="alert(\'Erreur images trop volumineuses\')">';
			    echo '<meta http-equiv="refresh" content="0;URL=location.php">';
			}
		}
		

	}

?>
