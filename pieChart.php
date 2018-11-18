<?php // content="text/plain; charset=utf-8"
require_once ('./src/jpgraph.php');
require_once ('./src/jpgraph_pie.php');
require_once ('./src/jpgraph_pie3d.php');

	function connectionDB(){
		$dbconn = pg_connect("dbname=dbl1k1 host=localhost user=l1k1 password=starbringen")
	    or die('Connexion impossible : ' . pg_last_error());

	    return $dbconn;
	}
	function closeDB($db){
		pg_close($db);
	}

//$dbcon=connectionDB()
// Access to the data
//$req1=pg_query("SELECT COUNT(idrent) FROM rent WHERE brandrent='".$val."';");

//Initiate data
$data = array(40,60,21,33);

// Create the Pie Graph. 
$graph = new PieGraph(400,350);

$theme_class= new VividTheme;
$graph->SetTheme($theme_class);

// Set A title for the plot
$graph->title->Set("A Simple 3D Pie Plot");

// Create
$p1 = new PiePlot3D($data);
$graph->Add($p1);

$p1->ShowBorder();
$p1->SetColor('black');
$p1->ExplodeSlice(1);
$graph->Stroke();

?>