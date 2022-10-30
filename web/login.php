<?php
if(!empty($_SESSION)){
    session_destroy();
}
// session_start();
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
// error_reporting(E_ALL);
// error_reporting(E_ALL ^ E_DEPRECATED);
  include('gconfig.php');
  require_once "FacebookLogin/config.php";
  if(!isset($_SESSION['google_access_token'])) {
   $google_login_btn = '<a href="'.$google_client->createAuthUrl().'"><img width="20px" style="margin-bottom:3px; 
   margin-right:5px" alt="Google sign-in" 
   src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" />
   Patient Login</a>';
  } 
  else {
    header("Location: patient.php");
  }

    $redirectURL = "http://localhost/dhanya/web/FacebookLogin/fb-callback.php";
    $permissions = ['email'];
    $loginURL = $helper->getLoginUrl($redirectURL, $permissions);
?>
<html>
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PHP Login With Google</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        .ptb10{
            padding-top: 10px !important;
            padding-bottom:10px !important;
        }
    </style>
</head>
 <body>
  <div class="container">
   <br />
   <h2 align="center">PD HEALTH TRACKER</h2>
   <br />
   <div class="row">
       <div class="col-md-4"></div>
       <div class="col-md-4">
       <div class="panel panel-default ptb10">
        <?php
            echo '<div align="center">'.$google_login_btn . '</div>';
        ?>
        </div>
        <div class="panel panel-default ptb10">
            <div align="center">

            <img width="20px" style="margin-bottom:3px; 
   margin-right:5px" alt="Google sign-in" 
   src="https://th.bing.com/th/id/R.cf9eb713a0b91600409f1e26a1315e4a?rik=2mNNfS%2bJRJV7%2bQ&pid=ImgRaw&r=0" /><a href="github/index.php">Physician login</a>
            </div>
        </div>
        <div class="panel panel-default ptb10">
            <div align="center">
                
            <img width="20px" style="margin-bottom:3px; 
   margin-right:5px" alt="Google sign-in" 
   src="https://th.bing.com/th/id/R.9d13eaaf6566b8bdf715bd38c110aec0?rik=rY2INEiHKMVz2w&riu=http%3a%2f%2f3.bp.blogspot.com%2f-KNqO9JuXUN8%2fTi2b1LHRquI%2fAAAAAAAAAIU%2fL6k8Wlzxj9k%2fs1600%2flogo_facebook.png&ehk=ziMr2C3oUEw31MWuloKmoKqzMBzkqgUnFMR%2bsHqWeHM%3d&risl=&pid=ImgRaw&r=0" /><a style="pointer:cursor" onclick="window.location = '<?php echo $loginURL ?>';"">Researcher Login</a>
            </div>
        </div>
       </div>
       <div class="col-md-4"></div>
   </div>
  </div>
 </body>
</html>