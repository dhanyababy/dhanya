<?php require('../database.php'); ?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
            <p>Select patient from the dropdown to see activity info</p>
            <form method="post" action="patient_activity.php" target="iframe" enctype="multipart/form-data">
                <div class="col-md-8">
                    <select class="form-control" name="file" id="file">
                        <option value="" selected> - Choose data file name-
                    <?php
                    if(!empty($patient_activities)){
                        foreach($patient_activities as $key=>$value){
                    ?>
                    <option value="<?= $value['DataURL']?>"><?= $value['DataURL']?></option>
                            
                    <?php
                            }
                        }
                    ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <input class="btn btn-success" type="submit" name="submit" value="View"></input>
                </div>
                <div class="clearfix"></div>
                <div class="graph">
                    <iframe name="iframe" frameborder="0" width="320" height="220" allowfullscreen>
                    <img src="patient_activity.php"/>
                    </iframe>
                </div>
            </form>
            <br>
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
