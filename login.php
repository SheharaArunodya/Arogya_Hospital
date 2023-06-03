<?php
include('db_files/database.php');
$newdb = new dbclass();
echo "<link rel='stylesheet' type='text/stylesheet' href='css_files/home.css'>";
$conn = $newdb->create_con();
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Here</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins,display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("https://thumbs.dreamstime.com/b/hospital-building-modern-parking-lot-59693686.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            height: fit-content;
            overflow-y: hidden;
        }

        .login-section {
            height: 600px;
            width: 400px;
            background-color: rgb(255, 255, 255);
            padding: 20px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 100px;
            margin-bottom: 100px;
            box-shadow: 0 10px 16px 0 rgba(10, 10, 10, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .form-topic {
            text-align: center;
            font-weight: 700;
            margin-top: 30px;
            letter-spacing: 5px;
        }

        .login-img {
            height: 200px;
            width: 200px;
            border-radius: 50%;
            margin-left: 75px;
        }

        input {
            height: 30px;
            width: 80%;
            padding: 2px 5px;
            border: none;
            border-bottom: 2px solid gray;
            margin-left: 31px;
            margin-bottom: 15px;
            color: black;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }

        .login-btn {
            background-color: #0039e6;
            height: 40px;
            width: 80%;
            margin-left: 31px;
            border: none;
            margin-top: 10px;
            cursor: pointer;
            color: white;
            border-radius: 30px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 20px;
        }

        h4 a {
            text-decoration: none;
            letter-spacing: 5px;
            color: #0039e6;
        }

        h4 {
            margin-left: 6px;
            margin-top: 50px;
        }

        p {
            text-align: center;
            padding: 8px;
            font-size: 12px;
            font-family: 'Poppins', sans-serif;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container login-section">
        <h1 class="form-topic">Login Here</h1>
        <img src="images/loginicon.png" alt="" class="login-img">

        <form action="" method="post" onsubmit="check()">
            <input type="text" name="email" id="" placeholder="Enter your Email"> <br></br>
            <input type="password" name="pw" id="" placeholder="Enter your Password">
            <button type="submit" class="login-btn" name="loginbtn">Login</button>
        </form>

        <h4>Are you a new member ? <a href="signup.php">Signup Here</a></h4>
    </div>

    <?php
    if (isset($_POST['loginbtn'])) {
        $email = $_POST['email'];
        $pw = $_POST['pw'];

        $sql = "SELECT p_id,p_email,p_pw FROM patient WHERE p_email = '" . $email . "'";
        $sqladmin = "SELECT s_id,s_email,s_pw,s_role FROM staff WHERE s_email = '" . $email . "'";
        $result = $conn->query($sql);
        $result2 = $conn->query($sqladmin);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $dbemail = $row['p_email'];
                $dbpw = $row['p_pw'];
                $id = $row['p_id'];

                unset($_POST['email']);
                unset($_POST['pw']);
                if ($dbpw == $pw) {
                    echo "<script>
                    window.alert('Login Successfull. Welcome to the Dashboard ');
                    location.replace('patient_dash.php?id=" . $id . "');
                    </script>";
                } else {
                    echo "<script>
                    window.alert('Login Failed. Please Check your credentials ');
                    location.replace('login.php');
                    </script>";
                }
            }
        } else if ($result2->num_rows > 0) {
            while ($row2 = $result2->fetch_assoc()) {
                $dbemail = $row2['s_email'];
                $dbpw = $row2['s_pw'];
                $id = $row2['s_id'];
                $role = $row2['s_role'];

                if ($dbpw == $pw) {
                    if ($role == "Admin") {
                        $_SESSION['a_id'] = $id;
                        $_SESSION['role'] = $role;
                        echo "<script>
                            window.alert('Login Successfull. Welcome to the Dashboard ');
                            location.replace('admin_dash.php');
                            </script>";

                        unset($_POST['email']);
                        unset($_POST['pw']);
                    } else {
                        echo "<script>
                            window.alert('Login Successfull. Welcome to the Dashboard ');
                            location.replace('staff_dash.php?id=" . $id . "');
                            </script>";

                        unset($_POST['email']);
                        unset($_POST['pw']);
                    }
                } else {
                    echo "<script>
                        window.alert('Login Failed. Please Check your credentials....!');
                        location.replace('login.php');
                        </script>";

                    unset($_POST['email']);
                    unset($_POST['pw']);
                }
            }
        } else {
            echo "<script>
                    window.alert('Login Failed. No user found....!!!');
                    location.replace('login.php');
                    </script>";
        }
    }
    ?>
</body>

</html>