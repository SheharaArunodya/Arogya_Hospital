<?php
include('db_files/database.php');
$newdb = new dbclass();
$conn = $newdb->create_con();
session_start();

$adminId = $_SESSION['a_id'];
$role = $_SESSION['role'];

$sql = "SELECT s_name,s_role FROM staff WHERE s_id = {$adminId} AND s_role = '{$role}';";
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
    <script src="./js_files/admin-option.js"></script>
    <link rel="stylesheet" href="./css_files/sidebar.css">
    <link rel="stylesheet" href="./css_files/card-rows.css">
    <link rel="stylesheet" href="./css_files/admin-option.css">
    <title>Admin Dashboard</title>

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

        

        
        
    </style>

    <script>
        

        function confirmation() {
            var result = confirm("Are you sure want to logout? ");
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
                    <li class="active">
                        <a href="admin_dash.php">Dashboard</a>
                    </li>
                    <li>
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

                <?php
                    if(isset($_POST['profilebtn'])){
                        echo "<script>location.replace('profile.php?id={$adminId}');</script>";
                    }
                ?>

                <div class="row">
                    <div class="contianer dashboard">
                        <div class="first-card-row">
                            <div class="card-firstrow">
                                <h4>Admin Count</h4>
                                <h2>
                                    <?php
                                    $sql = "SELECT COUNT(s_id) as admincount FROM staff WHERE s_role = 'Admin'; ";
                                    $qresult = $conn->query($sql);
                                    while ($row = $qresult->fetch_assoc()) {
                                        echo $row['admincount'];
                                    }
                                    ?>
                                </h2>
                            </div>
                            <div class="card-firstrow">
                                <h4>Patient Count</h4>
                                <h2>
                                    <?php
                                    $sql = "SELECT COUNT(p_id) as patientcount FROM patient; ";
                                    $qresult = $conn->query($sql);
                                    while ($row = $qresult->fetch_assoc()) {
                                        echo $row['patientcount'];
                                    }
                                    ?>
                                </h2>
                            </div>
                            <div class="card-firstrow">
                                <h4>Staff Member Count</h4>
                                <h2>
                                    <?php
                                    $sql = "SELECT COUNT(s_id) as staffcount FROM staff WHERE NOT(s_role = 'Admin'); ";
                                    $qresult = $conn->query($sql);
                                    while ($row = $qresult->fetch_assoc()) {
                                        echo $row['staffcount'];
                                    }
                                    ?>
                                </h2>
                            </div>
                        </div>

                        <div class="first-card-row second-row">
                            <div class="card-firstrow">
                                <h4>Assigned Inquiries</h4>
                                <h2>
                                    <?php
                                    $sql = "SELECT COUNT(i_id) as inquirycount FROM inquiry WHERE status = 'Assigned'; ";
                                    $qresult = $conn->query($sql);
                                    while ($row = $qresult->fetch_assoc()) {
                                        echo $row['inquirycount'];
                                    }
                                    ?>
                                </h2>
                            </div>
                            <div class="card-firstrow">
                                <h4>Pending Inquiries</h4>
                                <h2>
                                    <?php
                                    $sql = "SELECT COUNT(i_id) as inquirycount FROM inquiry WHERE status = 'Pending'; ";
                                    $qresult = $conn->query($sql);
                                    while ($row = $qresult->fetch_assoc()) {
                                        echo $row['inquirycount'];
                                    }
                                    ?>
                                </h2>
                            </div>
                            <div class="card-firstrow">
                                <h4>Completed Inquiries</h4>
                                <h2>
                                    <?php
                                    $sql = "SELECT COUNT(i_id) as inquirycount FROM inquiry WHERE status = 'Completed'; ";
                                    $qresult = $conn->query($sql);
                                    while ($row = $qresult->fetch_assoc()) {
                                        echo $row['inquirycount'];
                                    }
                                    ?>
                                </h2>
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