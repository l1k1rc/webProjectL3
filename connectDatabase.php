<?php
function connectionDB(){
		$dbconn = pg_connect("dbname=dbl1k1 host=localhost user=l1k1 password=starbringen")
	    or die('Connexion impossible : ' . pg_last_error());

	    return $dbconn;
	}
function closeDB($db){
		pg_close($db);
	}
?>
