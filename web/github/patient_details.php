<?php require('../database.php'); ?>
<?php
    $user_id = '';
    $patient_details = [];
    $patient_activities = [];
    if(!empty($_POST['id'])){
        $user_id = $_POST['id'];
        $sql = "SELECT * FROM user left join organization on Organization=organizationID where userID = ".$user_id." limit 1";
        // print_r($sql);die;
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $patient_details = $result->fetch_assoc();
        }
        // $conn->close();

        $sql1 = "SELECT * FROM test_session left join test on Test_IDtest=testID left join therapy on Therapy_IDtherapy=therapyID left join user on User_IDpatient=userID where userID = ".$user_id;
        // print_r($sql1);die;
        $result1 = $conn->query($sql1);

        if ($result1->num_rows > 0) {
            while($row1 = $result1->fetch_assoc()) {
                $patient_activities[] = $row1;
            }
            // $patient_activities = $result1->fetch_assoc();
        }
        $conn->close();
    }
?>
<?php
session_start();
 require_once('header.php'); 
?>
<div class="col-md-9 main_div">
    <div class="sub_div">
        <?php 
            if(!empty($patient_details)){
        ?>
        <div class="panel panel-default plr10 ptb10">
            <h4>Patient Info:</h4>
            <p>User ID: <?= $patient_details['userID'] ?></p>
            <p>Organization: <?= $patient_details['name'] ?></p>
            <p>Username: <?= $patient_details['username'] ?></p>
            <p>Email: <?= $patient_details['email'] ?></p>
            <br>
            <h4>Patient Activity Info:</h4>
            <p>Select patient from the dropdown button to see activity info</p>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">select data
                <span class="caret"></span></button>
                <ul class="dropdown-menu">
                <?php
                        
                if(!empty($patient_activities)){
                    foreach($patient_activities as $key=>$value){
                ?>
                <li><a class="view_activity" data-file="<?= $value['DataURL']?>" data-name="<?= $patient_details['username'] ?>" href="#"><?=$value['DataURL']?></a></li>
                        
                <?php
                        }
                    }
                ?>
                

                </ul>
            </div>
            <br>
            <div id="chart_div" class="panel panel-default plr10 ptb10" style="display:none">
                <div id="myChart" style="width:100%; max-width:600px; height:500px;"></div>
            </div>
        </div>
        <?php
            }
            else{
        ?>
        <div class="panel panel-default plr10 ptb10">
            <p>Patient details not found!..</p>
        </div>
        <?php
            }
        ?>
    </div>
</div>
<?php require_once('footer.php'); ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    $(document).on('click','.view_activity',function(e){
        e.preventDefault();
        var form_data = {
            'file'     : $(this).attr('data-file'),
            'name'     : $(this).attr('data-name')
        };
        $.ajax({
            url: "patient_activity.php",
            type: "post",
            data: form_data ,
            success: function (response) {
                let response_obj = jQuery.parseJSON(response);
                if(response_obj.status){
                    $('#chart_div').css({display:'block'})
                    google.charts.load('current',{packages:['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
                    function drawChart() {
                        // Set Data
                        var chart_data = response_obj.chart_data;
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
                }
                else{
                    $('#chart_div').css({display:'none'})
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
            }
        });
    })
</script>