<?php
session_start();
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
// error_reporting(E_ALL);

require_once "init.php";
require('../database.php');

$patients = [];
$sql = "SELECT * FROM User where Role_IDrole = '1'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $patients[] = $row;
    }
}
$conn->close();
if (!isset($_SESSION['user']) && isset($_GET['code'])) {
    $data = fetchData();
}


// if (!isset($_SESSION['user'])) {
//     header("location: logout.php");
// }

?>
<?php
 require_once('header.php'); 
?>
<div class="col-md-9 main_div">
    <div class="sub_div">
        <div class="panel panel-default plr10 ptb10">
            <h5 class="card-title">Welcome physician <?php echo ucfirst($_SESSION['user_name']);?></h5>
            <p class="card-text">Your email is <?php echo $_SESSION['user_email']; ?> </p>
            <p>Click on your patient(s) name below to view their files and  activity information:</p>
            
            
            
            <?php
                if(!empty($patients)){
                    $count = 1;
                    foreach($patients as $key=>$value){
            ?>
                        Patient <?=$count?> : <a href="patient_details.php?id=<?= $value['userID']?>"><?=$value['username']?></a>
                        <br>
            <?php
                    $count++;
                    }
                }
            ?>
        </div>
    <div class="panel panel-default plr10 ptb10">
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select Patient
            <span class="caret"></span></button>
            <ul class="dropdown-menu">
            <?php
                if(!empty($patients)){
                            $count = 1;
                    foreach($patients as $key=>$value){
                    ?>
                        <li><a href="patient_details.php?id=<?= $value['userID']?>"><?=$value['username']?></a></li>
                    <?php
                    }
                }
            ?>
            

            </ul>
        </div>
    </div>
        
       
    </div>
</div>

<?php require_once('footer.php'); ?>
