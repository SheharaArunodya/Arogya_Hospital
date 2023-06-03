<?php
    include('db_files/database.php');
    $newdb = new dbclass();
    $conn = $newdb->create_con();
    session_start();

    $adminId = $_SESSION['a_id'];

    $sql = "SELECT s_name,s_role FROM staff WHERE s_id = {$adminId};";
    $name_result = mysqli_query($conn,$sql);
    if($name_result->num_rows>0){
        while($row= $name_result->fetch_assoc()){
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
    <title>Inquiry Management Area</title>
    <style>
                 @import url('https://fonts.googleapis.com/css2?family=Poppins,display=swap');
        *{
            margin:0;
            padding:0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        .row{
            display:flex;
        }
        .sidebar{
            flex-basis: 16%;
            width:300px;
            height:100vh;
            background-color: #5c5cd6;
        }
        .loader{
            flex-basis:84%;
        }
        .naming{
            display:block;
            padding: 10px 15px;
            cursor: pointer;
        }
        .naming-row{
            display: block;
            text-align: right !important;
        }
        .naming-row h4{
            color:black;
        }
        
        
        .add-row{
            margin: 0px auto;
        }
        .deletebtn{
            color:red;
        }
        .showbtn{
            color:blue;
        }
        .reg-section{
        height:600px;
        width:400px;
        background-color: rgb(255,255,255);
        padding:20px;
        margin-left: 20px;
        box-shadow: 0 10px 16px 0 rgba(10, 10, 10, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }
    .sec-role,input{
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
        background-color:#5c5cd6;
        height:30px;
        width:41%;
        margin-left: 15px;
        border:none;
        margin-top:10px;
        cursor:pointer;
        color:white;
        border-radius: 30px;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 17px;
        transition:0.2s ease;
    }
    .update{
        margin-left: 20px;
    }
    .create-btn:hover{
        background-color: white;
        color:#5c5cd6;
        border:2px solid #5c5cd6;
    }
    .form-topic{
        text-align: center;
        font-weight: 700;
        margin-top:30px;
        letter-spacing: 5px;
        margin-bottom: 50px;
    }
    .staff-section{
        height:600px;
        width:830px;
        background-color: rgb(255,255,255);
        padding:20px;
        margin-left: 20px;
        box-shadow: 0 10px 16px 0 rgba(10, 10, 10, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        overflow-y:auto;
    }
    .staff{
        display:flex;
    }
    .staff-table{
        width:100%;
    }
    td i{
        font-size: 13px;
    }
    thead{
        color:#5c5cd6;
        font-weight: 600;
        margin-bottom: 20px;
    }
    tbody{
        text-align: center;
        padding-top: 20px;
    }
    td{
        padding:10px;
    }
    </style>

    <script>
        state = true;
        function adminOption(){
            if(state == true){
                document.querySelector('.admin-options').style.opacity = "1";
                state = false;
            }
            else{
                document.querySelector('.admin-options').style.opacity = "0";
                state = true;
            }
        }    

        function confirmation(){
            var result = confirm("Are you sure want to logout? ");
            return result;
        }
        function delconfirmation(){
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
                <li>
                    <a href="staff.php">Staff</a>
                </li>
                <li>
                    <a href="patients.php">Patients</a>
                </li>
                <li  class="active">
                    <a href="inquiry.php" class="active" >Inquiries</a>
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
                <div class="naming" onclick = "adminOption()">
                <h3>
                <?php echo $_SESSION['adminname']; ?>
                </h3>
                <h4>
                <?php echo $_SESSION['adminrole']; ?> &#9660;
                </h4>

                <div class="admin-options">
                    <form action="" method="post">
                    <ul type="none">
                    <li><button name="logoutbtn" type="submit" >Logout</button></li>
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
                    <h1 class="form-topic">Assign Inquiries</h1>
                    <input type="text" name="jid" id="" value="<?php if(isset($_SESSION['job_id'])){
                                echo $_SESSION['job_id'];
                                unset($_SESSION['job_id']);
                            }else{
                                $_SESSION['job_id'] = '';
                                echo $_SESSION['job_id'];

                            }  
                            unset($_SESSION['id']);
                        ?>" placeholder="Job ID. Don't fill when assigning inquiries"> <br></br>
                    <select name="receptionist" class="sec-role" placeholder="Select Receptionist Name" value="">
                            <option value=""><?php if(isset($_SESSION['receptionistName'])){
                                echo $_SESSION['receptionistName'];
                                unset($_SESSION['receptionistName']);
                            }else{
                                $_SESSION['receptionistName'] = 'Select Receptionist Name';
                                echo $_SESSION['receptionistName'];
                                unset($_SESSION['receptionistName']);
                            }?></option>
                            
                            <?php
                                $sql = "SELECT s_id,s_name FROM staff WHERE s_role = 'Receptionist';";
                                $result = mysqli_query($conn,$sql);
                                if($result->num_rows>0){
                                    while($row = $result->fetch_assoc()){
                                        echo "<option value = {$row['s_id']}>
                                            {$row['s_id']} - {$row['s_name']}
                                        </option>";
                                    }
                                }else{
                                    echo "<option selected = 'selected' >
                                            No Receptionist found
                                        </option>";
                                }
                            ?>

                        </select> <br></br>

                        <select name="inquiry" class="sec-role" placeholder="Select Inquiry" value="">
                            <option value="<?php if(isset($_SESSION['InquiryId'])){
                                echo $_SESSION['InquiryId'];
                            }else{echo '';}?>">
                            
                            <?php if(isset($_SESSION['InquiryId'])){
                                echo $_SESSION['InquiryId'];
                                unset($_SESSION['InquiryId']);
                            }else{
                                $_SESSION['InquiryId'] = 'Select Inquiry ID';
                                echo $_SESSION['InquiryId'];
                                unset($_SESSION['InquiryId']);
                            }?></option>

                            <?php
                                $sql = "SELECT i_id FROM inquiry WHERE status = 'Pending';";
                                $result = mysqli_query($conn,$sql);
                                if($result->num_rows>0){
                                    while($row = $result->fetch_assoc()){
                                        echo "<option value = {$row['i_id']}>
                                            {$row['i_id']}
                                        </option>";
                                    }
                                }else{
                                    echo "<option selected = 'selected' >
                                            No inquiries found
                                        </option>";
                                }
                            ?>
                            
                        </select> <br></br>

                        <button type="submit" class="create-btn" name="assign_inquiry">Assign Inquiry</button>
                        <button type="submit" class="create-btn update" name="update_inquiry">Update Inquiry</button>
                    </form>
                    </div>
                </div>

                <?php
                    if(isset($_POST['assign_inquiry'])){
                        $receptionist_id = $_POST['receptionist'];
                        $inquiry_id = $_POST['inquiry'];

                        $assigned_date = date('Y-m-d');
                        $sql2 = "INSERT INTO inquiry_assignment(i_id,s_id,assigned_date) VALUES({$inquiry_id},{$receptionist_id},'{$assigned_date}');";
                        if($conn->query($sql2)===true){
                            $sql3 = "UPDATE inquiry SET status = 'Assigned' WHERE i_id = {$inquiry_id};";
                            if($conn->query($sql3)===true){
                                echo "<script>;
                                alert('Inquiry Assigned');
                                alert('Inquiry Status Updated');
                                location.replace('inquiry.php');</script>";
                            }else{
                                echo "<script>alert('Cannot update status');</script>";   
                            }
                            echo "<script>alert('Inquiry Assigned');
                            location.replace('inquiry.php');</script>";
                        }else{
                            echo "<script>alert('Cannot Assigned the Inquiry ".$conn->error."');
                            location.replace('inquiry.php');</script>";
                        }

                        unset($_POST['receptionist']);
                        unset($_POST['inquiry']);

                    }

                    if(isset($_POST['update_inquiry'])){
                        $receptionist_id = $_POST['receptionist'];
                        $inquiry_id = $_POST['inquiry'];
                        $job_id = $_POST['jid'];
                        
                        $sql = "UPDATE inquiry_assignment SET s_id = {$receptionist_id} , i_id = {$inquiry_id} WHERE j_id = {$job_id}";
                        if($conn->query($sql) === true ){
                            echo "<script>;
                            alert('Inquiry Updated');
                            location.replace('inquiry.php');</script>";
                        }
                        else{
                            echo "<script>;
                            alert('Inquiry Cannot Update');
                            location.replace('inquiry.php');</script>";
                        }

                        unset($_POST['receptionist']);
                        unset($_POST['inquiry']);
                        unset($_POST['jid']);

                    }
                ?>

                        <div class="show-row">
                        <div class="container staff-section">
                        <h1 class="form-topic">All Inquiry Assignments</h1>
                        <table class="staff-table">
                            <thead>
                                <tr scope="row">
                                    <th scope="col">Job Id</th>
                                    <th scope="col">Patient ID</th>
                                    <th scope="col">Patient Name</th>
                                    <th scope="col">Receptionist ID</th>
                                    <th scope="col">Receptionist Name</th>
                                    <th scope="col">Assigned Date</th>
                                    <th scope="col">Inquiry Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    function filltable($conn){
                                        $sql = "SELECT i.i_id,i.j_id,i.assigned_date,i.s_id,s.s_name,inq.p_id, p.p_name,inq.status FROM staff s, inquiry_assignment i, inquiry inq, patient p WHERE (i.i_id = inq.i_id) AND (i.s_id = s.s_id) AND (inq.p_id = p.p_id);";
                                        $result = $conn->query($sql);
                                        if($result->num_rows>0){
                                            while($row=$result->fetch_assoc()){ 
                                            echo "<tr>
                                            <td>{$row['j_id']}</td>
                                            <td>{$row['p_id']}</td>
                                            <td> {$row['p_name']}</td>
                                            <td>{$row['s_id']}</td>
                                            <td>{$row['s_name']}</td>
                                            <td>{$row['assigned_date']}</td>
                                            <td>{$row['status']}</td>
                                            <td><a class='showbtn' href='helper.php?jshowid={$row['j_id']}' ><i class='fa-regular fa-eye'></i></a>
                                            <a class='deletebtn' href='helper.php?jdelid={$row['j_id']}' onclick='delconfirmation()'><i class='fa-solid fa-trash'></i></a>
                                            </td>
                                            </tr>";
                                            }
                                        }
                                        else{
                                            echo"<tr colspan = 7>
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
</div>
</body>
</html>