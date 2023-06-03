<?php
include('db_files/database.php');
$newdb = new dbclass();
echo "<link rel='stylesheet' type='text/stylesheet' href='css_files/home.css'>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Here</title>
    <style>
         @import url('https://fonts.googleapis.com/css2?family=Poppins,display=swap');
        *{
        margin:0;
        padding:0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
        }
        body{
            background-image: linear-gradient(rgba(0,0,0,0.7),rgba(0,0,0,0.7)),url("https://thumbs.dreamstime.com/b/hospital-building-modern-parking-lot-59693686.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            height:fit-content;
            overflow-y: hidden;
        }
    .reg-section{
        height:600px;
        width:400px;
        background-color: rgb(255,255,255);
        padding:20px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 100px;
        margin-bottom: 100px;
        box-shadow: 0 10px 16px 0 rgba(10, 10, 10, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }
    .form-topic{
        text-align: center;
        font-weight: 700;
        margin-top:30px;
        letter-spacing: 5px;
        margin-bottom: 50px;
    }
    .login-img{
        height:200px;
        width:200px;
        border-radius: 50%;
        margin-left:75px;
    }
    input{
        height:30px;
        width:80%;
        padding:2px 5px;
        border:none;
        border-bottom: 2px solid gray;
        margin-left: 31px;
        color:black;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
    }
    .create-btn{
        background-color:#0039e6;
        height:40px;
        width:80%;
        margin-left: 31px;
        border:none;
        margin-top:10px;
        cursor:pointer;
        color:white;
        border-radius: 30px;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 20px;
    }

    h4 a{
        text-decoration: none;
        letter-spacing: 5px;
        color:#0039e6;
    }
    h4{
        margin-left:30px;
        margin-top:20px;
    }
    p{
        text-align: center;
        padding:8px;
        font-size: 12px;
        font-family: 'Poppins', sans-serif;
        margin-top:10px;
    }
    </style>
</head>
<body>
<div class="container reg-section">
    <h1 class="form-topic">Join with Us</h1>

    <form action="" method="post" onsubmit="check()">
        <input type="text" name="fullname" id="" placeholder="Enter your Name"> <br></br>
        <input type="text" name="age" id="" placeholder="Enter your Age"> <br></br>
        <input type="text" name="address" id="" placeholder="Enter your address"> <br></br>
        <input type="text" name="tpno" id="" placeholder="Enter your Contact No"> <br></br>
        <input type="email" name="email" id="" placeholder="Enter your Email"> <br></br>
        <input type="password" name="pw" id="" placeholder="Enter your Password">
        <button type="submit" class="create-btn" name="signupbtn">Create Account</button>
    </form>
    <h4>Are you Registered ? <a href="login.php">Login Here</a></h4>
    <p>If you are a new staff member, you can't create your account here. Please contact administrator for more details</p>

    <?php
        if(isset($_POST['signupbtn'])){
            $name = $_POST['fullname'];
            $age = $_POST['age'];
            $address = $_POST['address'];
            $tpno = $_POST['tpno'];
            $email = $_POST['email'];
            $pw = $_POST['pw'];

            $sql = "INSERT INTO patient(p_name,p_age,p_add,p_tpno,p_email,p_pw) VALUES('".$name."',".$age.",'".$address."','".$tpno."','".$email."','".$pw."');";
            $conn = $newdb->create_con();
            if($conn->query($sql)===true){
                $id = $conn->insert_id;
                echo "<script>
                window.alert('Patient Added succesfuly Patient ID is ".$id."');
                location.replace('login.php?id=".$id."');
                </script>";
                
            }else{
                echo "<script>
                window.alert('cannot create the account Error ".$conn->error."');
                location.replace('signup.php');
                </script>";
            }   
            unset($name);
            unset($age);
            unset($address);
            unset($tpno);
            unset($email);
            unset($pw);
            unset($_POST['signupbtn']);
        }
    ?>
</div>
</body>
</html>