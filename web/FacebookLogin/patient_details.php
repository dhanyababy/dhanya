<?php require('../database.php'); ?>
<?php
    $user_id = '';
    $patient_details = [];
    $patient_activities = [];
    if(!empty($_GET['id'])){
        $user_id = $_GET['id'];
        $sql = "SELECT * FROM User left join organization on Organization=organizationID where userID = ".$user_id." limit 1";
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
        <div class="panel panel-default plr10 ptb10">
            <h4>Patient Info:</h4>
            <p>User ID: <?= $patient_details['userID'] ?></p>
            <p>Organization: <?= $patient_details['name'] ?></p>
            <p>Username: <?= $patient_details['username'] ?></p>
            <p>Email: <?= $patient_details['email'] ?></p>
            <br>
            <h4>Patient Activity Info:</h4>
            <?php
            if(!empty($patient_activities)){
                foreach($patient_activities as $key=>$value){
            ?>
                        <a href="patient_activity_data.php?file=<?= $value['DataURL']?>&name=<?= $patient_details['username'] ?>"><?=$value['DataURL']?></a>
                        <br>
            <?php
                    }
                }
            ?>
            <h4>Patient Location:</h4>
            <iframe 
            width="100%" 
            height="170" 
            frameborder="0" 
            scrolling="no" 
            marginheight="0" 
            marginwidth="0" 
            src="https://maps.google.com/maps?q=<?= $patient_details['Lat'] ?>,<?= $patient_details['Long'] ?>&hl=es&z=14&amp;output=embed"
            >
            </iframe>
            </small>
        </div>       
    </div>
</div>
<?php require_once('footer.php'); ?>