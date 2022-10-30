<?php require('../database.php'); ?>
<?php
    $file_name = '';
    $activity_data = [];
    if(!empty($_POST['file'])){
        $file_name = "../".$_POST['file'].".csv";

        $file = fopen($file_name, "r");
        $table_rows = "<table border='1px' cellpadding='6' cellspacing='50'>";
        while (! feof($file)) {
            $row = fgetcsv($file);
            $table_rows.= "<tr>";
            foreach ($row as $cell) {
                $table_rows.= "<td>" . htmlspecialchars($cell) . "</td>";
            }
            $table_rows.= "</tr>";
        }
        $table_rows .= "</table>";
        fclose($file);

        $chart_array = [];
        $first_row = 1;
        $file = fopen($file_name, "r");
        while (! feof($file)) {
            $row = fgetcsv($file);
            if($first_row != 1){
                $array = [
                    (int)$row[0],(int)$row[1]
                ];
                $chart_array[] = $array;
            }
            else{
                $array = [
                    $row[0],$row[1]
                ];
                $chart_array[] = $array;
            }       
            $first_row = 0;
        }
    }
?>

<?php
session_start();
 require_once('header.php'); 
?>
<style>
    th, td {
        padding: 15px;
    }
</style>
<div class="col-md-9 main_div">
    <div class="sub_div">
        <?php 
            if(!empty($_POST['file'])){
        ?>
        <div class="panel panel-default plr10 ptb10">
            <div id="myChart" style="width:100%; max-width:600px; height:500px;"></div>
            <!-- <h4><?=ucfirst($_POST['file'])?> for <?= ucfirst($_POST['name']) ?></h4>
            <?= $table_rows ?> -->
        </div>
        <?php
            }
            else{
        ?>
        <div class="panel panel-default plr10 ptb10">
                <p>Failed to get patient activity data</p>
        </div>
        <?php
            }
        ?>
    </div>
</div>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
google.charts.load('current',{packages:['corechart']});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
// Set Data
var chart_data = <?php echo json_encode($chart_array) ?>;
var data = google.visualization.arrayToDataTable(chart_data);
var options = {
  title: 'Patient Data',
//   hAxis: {title: 'Square Meters'},
//   vAxis: {title: 'Price in Millions'},
//   legend: 'none'
};
var chart = new google.visualization.LineChart(document.getElementById('myChart'));
chart.draw(data, options);
}
</script>

<?php require_once('footer.php'); ?>