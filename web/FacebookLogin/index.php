<?php
	session_start();

	if (!isset($_SESSION['access_token'])) {
		header('Location: login.php');
		exit();
	}
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
?>
<?php require_once('header.php'); ?>
<div class="col-md-9 main_div">
    <div class="sub_div">
		<div class="panel panel-default plr10 ptb10">
            <h5 class="card-title">Welcome Researcher <?php echo ucfirst($_SESSION['user_name']);?></h5>
            <p class="card-text">Your email is <?php echo $_SESSION['user_email']; ?> </p>
            <p>Click on your patient(s) name below to view their files and  activity information:</p>
            <?php
                if(!empty($patients)){
                    $count = 1;
                    foreach($patients as $key=>$value){
            ?>
                        Patient <?=$count?> : <a class="view_patient" data-id="<?= $value['userID']?>" href="#"><?=$value['username']?></a>
                        <br>
            <?php
                    $count++;
                    }
                }
            ?>
			<br>
			<a href="news.php">Latest news about parkinsons disease</a>
        </div>
    </div>
</div>
<?php require_once('footer.php'); ?>
<script>
    $(document).on('click','.view_patient',function(e){
        e.preventDefault();
        var form = $('<form action="patient_details.php" method="post">' +
        '<input type="hidden" name="id" value="'+$(this).attr('data-id')+'" />' +
        '</form>');
        $('body').append(form);
        form.submit();
    })
</script>