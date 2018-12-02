<?php
function connectionDB(){
		$dbconn = pg_connect("dbname=dbprojet host=localhost user=julien password=abc")
	    or die('Connexion impossible : ' . pg_last_error());

	    return $dbconn;
	}
function closeDB($db){
		pg_close($db);
	}
?>