<?php
include('db_files/database.php');
$newdb = new dbclass();
echo "<link rel='stylesheet' type='text/stylesheet' href='css_files/home.css'>";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Arogya Hospital Medicare Center</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="./css_files/home.css">
<!------------------------Including database files to index file--------------------------->
<style>
body{
    background-image: linear-gradient(rgba(0,0,0,0.7),rgba(0,0,0,0.7)),url("https://thumbs.dreamstime.com/b/hospital-building-modern-parking-lot-59693686.jpg");
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
.btn-container{
    width:20%;
    margin-left: auto;
    margin-right:auto ;
    margin-top: 40px;
}
</style>
</head>
<body>
    <div class="container">
        <div class="row">
            <h1 class="maintitle">Arogya Hospital</h1>
            <h3 class="subtitle">We are the leading hospital in the world</h3>
            <div class="btn-container">
            <a href="signup.php" class="ban-btn">Join with us</a>
            <a href="login.php" class="ban-btn">Login</a>
            </div>
        </div>
    </div>
</body>
</html>