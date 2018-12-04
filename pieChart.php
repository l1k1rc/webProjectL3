<?php // content="text/plain; charset=utf-8"
require_once ('./src/jpgraph.php');
require_once ('./src/jpgraph_pie.php');
require_once ('./src/jpgraph_pie3d.php');
require('connectDatabase.php');

  $dbconn=connectionDB();
  $brand=array();
  $nbrOnSite=array();
  $req=pg_query("SELECT brandrent, COUNT(*) FROM rent GROUP BY brandrent;");
  $countB=0;
  $countN=0;
  while ($l = pg_fetch_array($req,null,PGSQL_ASSOC)){
      $i=0;
        foreach ($l as $val) {
          if($i==0){
            $brand[$countB]=$val;
            $countB++;
          }
          else{
            $nbrOnSite[$countN]=$val;
            $countN++;
          }
          $i++;
        }
  }

// Create the Pie Graph. 
$graph = new PieGraph(500,450);

$theme_class= new VividTheme;
$graph->SetTheme($theme_class);

// Set A title for the plot
$graph->title->Set("Location par marque.");

// Create
$p1 = new PiePlot3D($nbrOnSite);
$graph->Add($p1);

$p1->ShowBorder();
$p1->SetColor('black');
$p1->ExplodeSlice(1);
$p1->SetLegends($brand);// display brand
$graph->Stroke();

?>