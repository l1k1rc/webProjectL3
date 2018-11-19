<?php
function connectionDB(){
		$dbconn = pg_connect("dbname=dbraphael host=localhost user=raphael password=raphaoul13")
	    or die('Connexion impossible : ' . pg_last_error());

	    return $dbconn;
	}
function closeDB($db){
		pg_close($db);
	}
?>