<?php
    $code = '';
    if(isset($_GET['code']) && !empty($_GET['code'])){
        $code = $_GET['code'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parkinsons</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<script>
    $(document).ready(function(){
        let code = '<?php echo $code;?>';
        var form = $('<form action="home.php" method="post">' +
        '<input type="hidden" name="code" value="'+code+'" />' +
        '</form>');
        $('body').append(form);
        form.submit();
    })
</script>
</body>
</html>