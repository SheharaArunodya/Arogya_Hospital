<?php
include('db_files/database.php');
$newdb = new dbclass();
$conn = $newdb->create_con();
session_start();

$adminId = $_SESSION['a_id'];

$sql = "SELECT s_name,s_role FROM staff WHERE s_id = {$adminId};";
$name_result = mysqli_query($conn, $sql);
if ($name_result->num_rows > 0) {
    while ($row = $name_result->fetch_assoc()) {
        $_SESSION['adminname'] = $row['s_name'];
        $_SESSION['adminrole'] = $row['s_role'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/6eb5927010.js" crossorigin="anonymous"></script>
    <script src="./js_files/admin-option.js"></script>
    <link rel="stylesheet" href="./css_files/sidebar.css">
    <link rel="stylesheet" href="./css_files/card-rows.css">
    <link rel="stylesheet" href="./css_files/admin-option.css">
    <title>Staff Area</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins,display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        .row {
            display: flex;
        }

        .sidebar {
            flex-basis: 16%;
            width: 300px;
            height: 100vh;
            background-color: #5c5cd6;
        }

        .loader {
            flex-basis: 84%;
        }

        .naming {
            display: block;
            padding: 10px 15px;
            cursor: pointer;
        }

        .naming-row {
            display: block;
            text-align: right !important;
        }

        .naming-row h4 {
            color: black;
        }

        
        .add-row {
            margin: 0px auto;
        }

        .deletebtn {
            color: red;
        }

        .showbtn {
            color: blue;
        }

        .reg-section {
            height: 600px;
            width: 400px;
            background-color: rgb(255, 255, 255);
            padding: 20px;
            margin-left: 20px;
            box-shadow: 0 10px 16px 0 rgba(10, 10, 10, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .sec-role,
        input {
            height: 30px;
            width: 80%;
            padding: 2px 5px;
            border: none;
            border-bottom: 2px solid gray;
            margin-left: 31px;
            color: black;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }

        .create-btn {
            background-color: #5c5cd6;
            height: 30px;
            width: 41%;
            margin-left: 15px;
            border: none;
            margin-top: 10px;
            cursor: pointer;
            color: white;
            border-radius: 30px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 17px;
            transition: 0.2s ease;
        }

        .update {
            margin-left: 20px;
        }

        .create-btn:hover {
            background-color: white;
            color: #5c5cd6;
            border: 2px solid #5c5cd6;
        }

        .form-topic {
            text-align: center;
            font-weight: 700;
            margin-top: 30px;
            letter-spacing: 5px;
            margin-bottom: 50px;
        }

        .staff-section {
            height: 600px;
            width: 830px;
            background-color: rgb(255, 255, 255);
            padding: 20px;
            margin-left: 20px;
            box-shadow: 0 10px 16px 0 rgba(10, 10, 10, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            overflow-y: auto;
        }

        .staff {
            display: flex;
        }

        .staff-table {
            width: 100%;
        }

        td i {
            font-size: 13px;
        }

        thead {
            color: #5c5cd6;
            font-weight: 600;
            margin-bottom: 20px;
        }

        tbody {
            text-align: center;
            padding-top: 20px;
        }

        td {
            padding: 10px;
        }
    </style>

    <script>
        function confirmation() {
            var result = confirm("Are you sure want to logout? ");
            return result;
        }

        function delconfirmation() {
            var result = confirm("Are you sure want to delete? ");
            return result;
        }
    </script>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="container sidebar">
                <h1 class="sidebar-topic">Arogya Hospital</h1>

                <ul class="side-links" type="none">
                    <li>
                        <a href="admin_dash.php">Dashboard</a>
                    </li>
                    <li class="active">
                        <a href="staff.php">Staff</a>
                    </li>
                    <li>
                        <a href="patients.php">Patients</a>
                    </li>
                    <li>
                        <a href="inquiry.php">Inquiries</a>
                    </li>
                    <li>
                        <a href="room.php">Rooms</a>
                    </li>
                    <li>
                        <a href="ward.php">Wards</a>
                    </li>
                    <li>
                        <a href="theater.php">Theaters</a>
                    </li>
                </ul>
            </div>
            <div class="container loader">
                <div class="row  naming-row">
                    <div class="naming" onclick="adminOption()">
                        <h3>
                            <?php echo $_SESSION['adminname']; ?>
                        </h3>
                        <h4>
                            <?php echo $_SESSION['adminrole']; ?> &#9660;
                        </h4>

                        <div class="admin-options">
                            <form action="" method="post">
                                <ul type="none">
                                    <li><button name="logoutbtn" type="submit">Logout</button></li>
                                    <li><button name="profilebtn" type="submit">Profile</button></li>
                                </ul>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="contianer staff">
                        <div class="row add-row">

                            <form action="" method="post" onsubmit="check()" class="reg-section" name="addform">
                                <h1 class="form-topic">Add New Staff Member</h1>
                                <input type="text" name="id" id="" value="<?php if (isset($_SESSION['id'])) {
                                    echo $_SESSION['id'];
                                    unset($_SESSION['id']);
                                } else {
                                    $_SESSION['id'] = '';
                                    echo $_SESSION['id'];
                                }
                                unset($_SESSION['id']);
                                ?>"
                                    placeholder="Member ID. Don't fill when add new member"> <br></br>

                                <input type="text" name="fullname" id="" value="<?php if (isset($_SESSION['name'])) {
                                    echo $_SESSION['name'];
                                    unset($_SESSION['name']);
                                } else {
                                    $_SESSION['name'] = '';
                                    echo $_SESSION['name'];
                                }
                                ?>" placeholder="Member Name">
                                <br></br>

                                <input type="text" name="age" id="" value="<?php if (isset($_SESSION['age'])) {
                                    echo $_SESSION['age'];
                                    unset($_SESSION['age']);
                                } else {
                                    $_SESSION['age'] = '';
                                    echo $_SESSION['age'];
                                }
                                ?>" placeholder="Member Age"> <br></br>

                                <select name="role" class="sec-role" placeholder="Select Member Role" value="">
                                    <option value="">
                                        <?php if (isset($_SESSION['srole'])) {
                                            echo $_SESSION['srole'];
                                            unset($_SESSION['srole']);
                                        } else {
                                            $_SESSION['srole'] = 'Select member Role';
                                            echo $_SESSION['srole'];
                                            unset($_SESSION['srole']);
                                        } ?>
                                    </option>
                                    <option value="Admin">Admin</option>
                                    <option value="Doctor">Doctor</option>
                                    <option value="Nurse">Nurse</option>
                                    <option value="Nurse Helper">Nurse Helper</option>
                                    <option value="Receptionist">Receptionist</option>
                                </select> <br></br>
                                <input type="text" name="tpno" value="<?php if (isset($_SESSION['tpno'])) {
                                    echo $_SESSION['tpno'];
                                    unset($_SESSION['tpno']);
                                } else {
                                    $_SESSION['tpno'] = '';
                                    echo $_SESSION['tpno'];
                                }
                                ?>" id="" placeholder="Member Contact No">
                                <br></br>
                                <input type="email" name="email" id="" value="<?php if (isset($_SESSION['email'])) {
                                    echo $_SESSION['email'];
                                    unset($_SESSION['email']);
                                } else {
                                    $_SESSION['email'] = '';
                                    echo $_SESSION['email'];
                                }
                                ?>" placeholder="Member Email">
                                <br></br>
                                <input type="password" name="pw" id="" value="<?php if (isset($_SESSION['pw'])) {
                                    echo $_SESSION['pw'];
                                    unset($_SESSION['pw']);
                                } else {
                                    $_SESSION['pw'] = '';
                                    echo $_SESSION['pw'];
                                }
                                ?>" placeholder="Member Password">
                                <button type="submit" class="create-btn" name="addmember">Add Account</button>
                                <button type="submit" class="create-btn update" name="updatemember">Update</button>
                            </form>
                        </div>
                        <?php
                        if (isset($_POST['addmember'])) {
                            $name = $_POST['fullname'];
                            $age = $_POST['age'];
                            $role = $_POST['role'];
                            $tpno = $_POST['tpno'];
                            $email = $_POST['email'];
                            $pw = $_POST['pw'];

                            $sql = "INSERT INTO staff(s_name,s_age,s_tpno,s_email,s_pw,s_role) VALUES('{$name}',{$age},'{$tpno}','{$email}','{$pw}','{$role}');";

                            if ($conn->query($sql) === true) {
                                unset($name);
                                unset($age);
                                unset($role);
                                unset($tpno);
                                unset($email);
                                unset($pw);
                                unset($_POST['addmember']);
                                echo "<script>
                                alert('Staff Member Registered.');
                                location.replace('staff.php');
                            </script>";
                            } else {
                                unset($name);
                                unset($age);
                                unset($role);
                                unset($tpno);
                                unset($email);
                                unset($pw);
                                unset($_POST['addmember']);

                                echo "<script>
                                alert('Staff Member Cannot Register.');
                                location.replace('staff.php');
                            </script>";
                            }
                        }

                        if (isset($_POST['updatemember'])) {
                            $sid = $_POST['id'];
                            $name = $_POST['fullname'];
                            $age = $_POST['age'];
                            $role = $_POST['role'];
                            $tpno = $_POST['tpno'];
                            $email = $_POST['email'];
                            $pw = $_POST['pw'];

                            if (strlen($pw) > 0) {
                                $sql = "UPDATE staff SET s_name = '{$name}', s_age ={$age} ,s_role = '{$role}',s_tpno = '{$tpno}', s_email = '{$email}', s_pw = '{$pw}' WHERE s_id = {$sid};";
                            } else {
                                $sql = "UPDATE staff SET s_name = '{$name}', s_age ={$age} ,s_role = '{$role}',s_tpno = '{$tpno}', s_email = '{$email}' WHERE s_id = {$sid};";
                            }
                            if ($conn->query($sql) === true) {
                                unset($name);
                                unset($age);
                                unset($role);
                                unset($tpno);
                                unset($email);
                                unset($pw);
                                unset($_POST['addmember']);
                                echo "<script>
                                alert('Changes are Saved.');
                                location.replace('staff.php');
                            </script>";
                            } else {
                                unset($name);
                                unset($age);
                                unset($role);
                                unset($tpno);
                                unset($email);
                                unset($pw);
                                unset($_POST['addmember']);

                                echo "<script>
                                alert('Cannot update member');
                                location.replace('staff.php');
                            </script>";
                            }
                        }
                        ?>
                        <div class="show-row">
                            <div class="container staff-section">
                                <h1 class="form-topic">All Staff Members</h1>
                                <table class="staff-table">
                                    <thead>
                                        <tr scope="row">
                                            <th scope="col">Staff Id</th>
                                            <th scope="col">Staff Name</th>
                                            <th scope="col">Staff Age</th>
                                            <th scope="col">Staff Role</th>
                                            <th scope="col">Staff Contact</th>
                                            <th scope="col">Staff Email</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        function filltable($conn)
                                        {
                                            $sql = "SELECT * FROM staff";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>
                                            <td>$row[s_id]</td>
                                            <td>$row[s_name]</td>
                                            <td> $row[s_age]</td>
                                            <td> $row[s_role]</td>
                                            <td>$row[s_tpno]</td>
                                            <td>$row[s_email]</td>
                                            <td><a class='showbtn' href='helper.php?showid={$row['s_id']}' ><i class='fa-regular fa-eye'></i></a>
                                            <a class='deletebtn' href='helper.php?delid={$row['s_id']}' onclick='delconfirmation()'><i class='fa-solid fa-trash'></i></a>
                                            </td>
                                            </tr>";
                                                }
                                            } else {
                                                echo "<tr colspan = 7>
                                            No Rows in Database
                                        </tr>
                                        ";
                                            }
                                        }
                                        filltable($conn);
                                        ?>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <?php
            if (isset($_POST['logoutbtn'])) {
                session_destroy();
                session_cache_expire(0);
                unset($_SESSION['a_id']);
                unset($_SESSION['role']);

                echo "<script>
                    var result = confirmation();
                    if(result == true){
                        alert('Successfully Log out.');
                        location.replace('login.php');
                    }else{
                        alert('Cannot logout. Please wait');
                    }
                </script>";
                unset($_POST['logoutbtn']);
            }
            ?>
        </div>
    </div>

</body>

</html>