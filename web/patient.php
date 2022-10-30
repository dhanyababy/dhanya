<?php include('gconfig.php'); ?>
<?php require_once('header.php'); ?>
<?php require('database.php'); ?>
<?php
    if($_SESSION['google_access_token'] == '') {
        header("Location: login.php");
    }
    if(isset($_GET["code"])){
        $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
    
    if(!isset($token['error'])){
    //Set the access token used for requests
    $google_client->setAccessToken($token['access_token']);
    //Store "access_token" value in $_SESSION variable for future use.
    $_SESSION['token'] = $token;
    $_SESSION['google_access_token'] = $token['access_token'];
    //Create Object of Google Service OAuth 2 class
    $google_service = new Google_Service_Oauth2($google_client);
    //Get user profile data from google
    $data = $google_service->userinfo->get();
    //Below you can find Get profile data and store into $_SESSION variable
    if(!empty($data['given_name']))
    {
    $_SESSION['user_login_type'] = 'google';
    $_SESSION['user_name'] = $data['given_name'];
    }
    // if(!empty($data['family_name']))
    // {
    // $_SESSION['user_last_name'] = $data['family_name'];
    // }
    if(!empty($data['email']))
    {
    $_SESSION['user_email'] = $data['email'];
    }
    // if(!empty($data['gender']))
    // {
    // $_SESSION['user_gender'] = $data['gender'];
    // }
    if(!empty($data['picture']))
    {
    $_SESSION['user_image'] = $data['picture'];
    }
    }
    }
?>
<div class="col-md-9 main_div">
    <div class="sub_div">
        <div class="panel panel-default plr10 ptb10">
            <img class="user-image" src="<?php echo $_SESSION["user_image"]; ?>" alt="Card image cap">
            <br><br>
            <p>Welcome user <?php echo ucfirst($_SESSION['user_name']);?></p>
            <!-- <h5 class="card-title"><?php echo $_SESSION['user_name'];?></h5> -->
            <p class="card-text">Your Email is <?php echo $_SESSION['user_email']; ?> </p>
        </div>
        <?php
        
            


            // $sql = "SELECT * FROM User";
            // $result = $conn->query($sql);
            
            // if ($result->num_rows > 0) {
            //   // output data of each row
            //   while($row = $result->fetch_assoc()) {
            //     echo "id: " . $row["userID"]. " - Name: " . $row["username"]. " " . $row["email"]. "<br>";
            //   }
            // } else {
            //   echo "0 results";
            // }
            // $conn->close();
        ?>
    </div>
</div>
<?php require_once('footer.php'); ?>