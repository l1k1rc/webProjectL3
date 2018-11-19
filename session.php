<?php /* ALL of this file has been created for the connection part */
	/*Allows to set the "remember me" with cookie*/
	require ('connectDatabase.php');
	if(isset($_POST['remember'])){
		setcookie('log[login]',$_POST['login']);
		setcookie('log[psw]',$_POST['pass']);
	}else{
		setcookie('log[login]', NULL, -1);//delete the cookie
		setcookie('log[psw]', NULL, -1);//delete the seccond cookie
	}
	/*Allows to open a new session and direct the user to another page*/
	if (isset($_POST['login']) && isset($_POST['pass'])) {
			
			$dbconn = connectionDB();
	  		$req=pg_query("SELECT passwordu FROM users WHERE emailu='".$_POST['login']."';") or die('Erreur de connection.');
	  		$crypPass=crypt($_POST['pass'], 'rl');
	  		$arr=array();
	  		while ($l = pg_fetch_array($req,null,PGSQL_ASSOC)) {
				foreach ($l as $val) {
					$arr[0]=$val;
				}
			}
	  	if($arr[0]==$crypPass){
	   		session_start();
	    		
		   	$_SESSION['login'] = $_POST['login']; // SESSION est une SUPERGLOBAL
		   	$_SESSION['pass'] = $_POST['pass'];
		    		
		     header ('location: profil.php');
	     	} 
	    else {
	    	if($_POST['login']=="admin" && $_POST['pass']=="admin"){
	    			session_start();

					$_SESSION['login'] = $_POST['login'];
					$_SESSION['pass']=$_POST['pass'];
					header('location: admin.php');
	    		}
	    	else{
			    	header('location: connection.php');
	    		}
	    	}
	    }
    else {
    	echo 'Les variables du formulaire ne sont pas déclarées.';
	}

?>
