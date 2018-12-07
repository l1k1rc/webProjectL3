<?php // content="text/plain; charset=utf-8"
require_once ('./src/jpgraph.php');
require_once ('./src/jpgraph_pie.php');
require_once ('./src/jpgraph_pie3d.php');
require('connectDatabase.php');

  $dbconn=connectionDB();
  $req=pg_query("SELECT notationest FROM estimate WHERE idrent IN ( SELECT idrent FROM rent WHERE typerent = 'citadine');");
  $i=0;
  $moy1=0;$moy2=0;$moy3=0;
  while ($l = pg_fetch_array($req,null,PGSQL_ASSOC)){
        foreach ($l as $val) {
          $moy1+=$val;
          $i++;
        }
  }
  if($i==0){
    $moy1=0;
  }else{
    $moy1=$moy1/$i;
  }  
  $i=0;
  $req=pg_query("SELECT notationest FROM estimate WHERE idrent IN ( SELECT idrent FROM rent WHERE typerent = 'SUV');");
  while ($l = pg_fetch_array($req,null,PGSQL_ASSOC)){
        foreach ($l as $val) {
          $moy2+=$val;
          $i++;
        }
  }
  if($i==0){
    $moy2=0;
  }else{
    $moy2=$moy2/$i;
  }
  $i=0;
  $req=pg_query("SELECT notationest FROM estimate WHERE idrent IN ( SELECT idrent FROM rent WHERE typerent = 'sportive');");
  while ($l = pg_fetch_array($req,null,PGSQL_ASSOC)){
        foreach ($l as $val) {
          $moy3+=$val;
          $i++;
        }
  }
  if($i==0){
    $moy3=0;
  }else{
    $moy3=$moy3/$i;
  }
  $moyForType=array($moy1,$moy2,$moy3);
  $type=array('Citadine', 'SUV', 'Sportive');
// Create the Pie Graph. 
$graph = new PieGraph(500,450);

$theme_class= new VividTheme;
$graph->SetTheme($theme_class);

// Set A title for the plot
$graph->title->Set("Moyenne par type de location.");

// Create
$p1 = new PiePlot3D($moyForType);
$graph->Add($p1);

$p1->ShowBorder();
$p1->SetColor('black');
$p1->ExplodeSlice(1);
$p1->SetLegends($type);// display brand
$graph->Stroke();

?>