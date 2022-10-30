<?php require('../database.php'); ?>
<?php
    $user_id = '';
    $patient_details = [];
    $patient_activities = [];
    if(!empty($_POST['id'])){
        $user_id = $_POST['id'];
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
<script>
    $(document).on('click','.view_activity',function(e){
        e.preventDefault();
        var form = $('<form action="patient_activity_data.php" method="post">' +
        '<input type="hidden" name="file" value="'+$(this).attr('data-file')+'" />' +
        '<input type="hidden" name="name" value="'+$(this).attr('data-name')+'" />' +
        '</form>');
        $('body').append(form);
        form.submit();
    })
</script>