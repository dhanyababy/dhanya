<?php require_once('header.php') ?>
<?php require('database.php'); ?>
<?php
    session_start();
    $videos = [];
    $sql = "SELECT * FROM videos";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $videos[] = $row;
      }
    }
    
    $graph_data = [];
    $patient_details = [];
    $user_email = $_SESSION['user_email'];
    $user_id = '';
    if(!empty($user_email)){
        $sql1= "SELECT * FROM user where email='" .$user_email. "'";
        // print_r($sql1);die;
        $result1 = $conn->query($sql1);
        if ($result1->num_rows > 0) {
            $patient_details = $result1->fetch_assoc();
            $user_id = $patient_details['userID'];
        } 
    }
    if(!empty($user_id)){
        $sql2 = "SELECT * FROM test_session left join test on Test_IDtest=testID left join therapy on Therapy_IDtherapy=therapyID left join user on User_IDpatient=userID where userID = ".$user_id;
        $result2 = $conn->query($sql2);
        
        if ($result2->num_rows > 0) {
        // output data of each row
        $array = ['Date','Value'];
        $graph_data[] = $array;
        while($row = $result2->fetch_assoc()) {
            $date = $row['datetime'];
            $array = [
                $date,1
            ];
            $graph_data[] = $array;
        }
        }
        // echo "<pre>";
        // print_r($graph_data);die;
    }
    $conn->close();
    

?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<div class="col-md-9 main_div">
    <div class="sub_div">
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <?php
                    foreach($videos as $video){
                    ?>
                    <h2><?=$video['title']?></h2>
                    <iframe width="100%" height="420" src="<?= $video['video_url']?>" title="<?= $video['title'] ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <?php
                    }
                    ?>
                    <h3>Your Date Time Exercise</h3>
                    <div id="myChart" style="width:100%; max-width:600px; height:500px;"></div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </div>
</div>
<script>
google.charts.load('current',{packages:['corechart']});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
// Set Data
var chart_data = <?php echo json_encode($graph_data) ?>;
var data = google.visualization.arrayToDataTable(chart_data);
var options = {
  title: 'Patient Data',
  hAxis: {title: 'Date and Time'},
  vAxis: {
        viewWindowMode:'explicit',
        viewWindow: {
            max:1,
            min:0
        }
    }
//   legend: 'none'
};
var chart = new google.visualization.ColumnChart(document.getElementById('myChart'));
chart.draw(data, options);
}
</script>
<?php require_once('footer.php'); ?>