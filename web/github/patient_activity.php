<?php require('../database.php'); ?>
<?php
    $file_name = '';
    $activity_data = [];
    $result = [];
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
        $result['status']    = true;
        $result['chart_data'] = $chart_array;
    }
    else{
        $result['status']    = false;
        $result['chart_data'] = [];
    }
    echo json_encode($result);
?>