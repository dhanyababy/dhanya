<?php require('../database.php'); ?>
<?php
    $file_name = '';
    $activity_data = [];
    if(!empty($_GET['file'])){
        $file_name = "../".$_GET['file'].".csv";

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
        <div class="panel panel-default plr10 ptb10">
            <h4><?=ucfirst($_GET['file'])?> for <?= ucfirst($_GET['name']) ?></h4>
            <?= $table_rows ?>
        </div>       
    </div>
</div>
<?php require_once('footer.php'); ?>