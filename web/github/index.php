<?php

//to be created
// require "init.php";

if (isset($_SESSION['user'])) {
    header("location: login.php");
}
else{
    header("location: authenticate.php");
}

?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign in with GitHub</title>
</head>
<body style="margin-top: 200px; text-align: center; font-size: 30px;">
    <a href="authenticate.php">Sign in with GitHub</a>    
</body>
</html> -->