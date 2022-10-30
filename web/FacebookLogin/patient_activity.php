<?php 
$file = $_POST['file'];
$file_name = "../".$_POST['file'].".csv";

require_once ('../jp/src/jpgraph.php');
require_once ('../jp/src/jpgraph_scatter.php');

$f = fopen($file_name, "r");
$count = 0;
while (($line = fgetcsv($f)) !== false) {
       if($count > 0){
        list($datax[], $datay[], $datatime[]) = $line;
       }
       $count++;     
}
fclose($f);

$graph = new Graph(300,200);
$graph->SetScale("linlin");
 
$graph->img->SetMargin(50,50,50,50);        
$graph->SetShadow();
 
$graph->title->Set("Scatter plot of patient's data:");
$graph->title->SetFont(FF_FONT1,FS_BOLD);
 
$sp1 = new ScatterPlot($datay,$datax);
 
$graph->Add($sp1);
$graph->Stroke();