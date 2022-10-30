<?php
$testName=$_POST['datagraph'];
$testNamePath ="data/" .$testName. ".csv";
require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/jpgraph_scatter.php');
$f = fopen($testNamePath,"r");
while(($line = fgetcsv($f)) !== FALSE)
{
list($datax[],$datay[],$datatime[])=$line;
}
fclose($f);
$graph = new Graph(300,200);
$graph->SetScale("linlin");
 
$graph->img->SetMargin(50,50,50,50);        
$graph->SetShadow();
 
$graph->title->Set(" scatter plot of patients");
$graph->title->SetFont(FF_FONT1,FS_BOLD);
 
$sp1 = new Scatterplot($datay,$datax);
 
$graph->Add($sp1);
$graph->Stroke();
?>