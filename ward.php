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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
    <script src="https://kit.fontawesome.com/6eb5927010.js" crossorigin="anonymous"></script>
    <title>Room Sheduling Area</title>
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
        .admin-options{
            opacity:0;
            z-index:1000;
            position:fixed;
            transition:0.2s;
            left:90%;
            border:1px solid #5c5cd6;
            width:100px;
            height:100px;
        }
        .admin-options ul li{
            padding:5px;
            margin:5px 3px;
            height:35px;
         text-align: right !important;
         
        }
        .admin-options ul li button{
            color:black;
            cursor: pointer;
            text-decoration: none;
            transition: 0.1s;
            padding:10px;
            font-size:20px;
            border:none;
            background: transparent;
        }
        .admin-options ul li button:hover{
            background-color: #5c5cd6;
            color:white;
        }
        .sidebar-topic{
            padding-top:30px;
            font-size:30px;
            text-align: center !important;
            color:antiquewhite;
        }
        .sidebar ul {
            margin-top:70px;
            margin-left:50px;
        }
        .sidebar ul li{
            margin:10px 0px;
            width:150px;
            background-color: transparent;
            padding:10px;
            border-radius: 20px;
            transition:0.1s;
            font-weight: 600;
        }
        .sidebar ul li a{
            text-decoration: none;
            color:white;
            font-size: 20px;
        }
        .sidebar ul li:hover{
            background-color: white;
            color:black;
        }
        .sidebar ul li:hover > a{
            color:black;
        }
        .sidebar ul .active{
            background-color: white;
            color:black;
        }.sidebar ul .active>a{
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
    .span{
            display:none;
            transition:3s;
        }
        .hidden{
            display:none;
            transition:3s;
        }
        .newroom{
            display:block;
            height:600px;
            width:830px;
            background-color: rgb(255,255,255);
            padding:20px;
            margin-left: 20px;
            box-shadow: 0 10px 16px 0 rgba(10, 10, 10, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            overflow-y:auto;
            transition:3s;
        }
        .new-room-form{
            width:400px;
            height:auto;
            margin-left:auto;
            margin-right:auto;
        }
        .new-room-form button{
            width:400px;
        }
        .new-room-form input, .new-room-form select{
            width: 400px;
            margin-bottom:30px;
        }
        .newroom-btn{
        width:320px;
    }
    .addroomnew-btn{
        background-color:#5c5cd6;
        height:30px;
        margin-left: 30px;
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

        let btnclicked = false;
        $(document).ready(function(){
            $('.newroom-btn').click(function(){
                document.querySelector('#all-rooms').classList.toggle('hidden');
                document.querySelector('#new-room-id').classList.toggle('newroom');
                if(btnclicked == true){
                    document.querySelector('.newroom-btn').innerHTML = 'Add new Ward';
                    btnclicked = false;
                }else{
                    document.querySelector('.newroom-btn').innerHTML = 'Show Ward Shedule';
                    btnclicked = true;
                }
               
            });
            
        });
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
                <li>
                    <a href="inquiry.php">Inquiries</a>
                </li>
                <li >
                    <a href="room.php">Rooms</a>
                </li>
                <li class="active">
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
                    <h1 class="form-topic">New Shedule</h1>
                        <input type="text" name="id" id="" value="<?php if(isset($_SESSION['id'])){
                                echo $_SESSION['id'];
                                unset($_SESSION['id']);
                            }else{
                                $_SESSION['id'] = 'Shedule ID. Dont fill when creating new shedule';
                                echo $_SESSION['id'];
                                unset($_SESSION['id']);
                            }?>
                        " placeholder="Shedule ID. Don't fill when creating new shedule"> <br></br>

                            <select name="ward_id" class="sec-role" placeholder="Select Ward ID" value="">
                            <option value="<?php if(isset($_SESSION['w_id'])){
                                echo $_SESSION['w_id'];
                            }else{echo '';}?>">
                            <?php if(isset($_SESSION['w_id'])){
                                echo $_SESSION['w_id'];
                                unset($_SESSION['w_id']);
                            }else{
                                $_SESSION['w_id'] = 'Select Ward ID';
                                echo $_SESSION['w_id'];
                                unset($_SESSION['w_id']);
                            }?></option>
                           
                           <?php
                                $sql = "SELECT w_id FROM ward";
                                $result = mysqli_query($conn,$sql);
                                if($result->num_rows>0){
                                    while($row = $result->fetch_assoc()){
                                        echo "<option value = {$row['w_id']}>
                                            {$row['w_id']}
                                        </option>";
                                    }
                                }else{
                                    echo "<option selected = 'selected' >
                                            No wards found
                                        </option>";
                                }
                            ?>
                        </select> <br></br>

                        <select name="staff" class="sec-role" placeholder="Select Member" value="">
                            <option value=<?php if(isset($_SESSION['staff_id'])){
                                echo $_SESSION['staff_id'];
                            }else{echo '';}?>

                            ><?php if(isset($_SESSION['staff'])){
                                echo $_SESSION['staff'];
                                unset($_SESSION['staff']);
                            }else{
                                $_SESSION['staff'] = 'Select member';
                                echo $_SESSION['staff'];
                                unset($_SESSION['staff']);
                            }?></option>
                            
                            <?php
                                $sql = "SELECT s_id,s_name FROM staff WHERE NOT (s_role = 'Receptionist' OR s_role = 'Admin')";
                                $result = mysqli_query($conn,$sql);
                                if($result->num_rows>0){
                                    while($row = $result->fetch_assoc()){
                                        echo "<option value = {$row['s_id']}>
                                            {$row['s_id']}-{$row['s_name']}
                                        </option>";
                                    }
                                }else{
                                    echo "<option selected = 'selected' >
                                            No Staff members Found
                                        </option>";
                                }
                            ?>
                        </select> <br></br>

                        <input type="date" name="s_date" id="" value="<?php if(isset($_SESSION['a_date'])){
                                echo $_SESSION['a_date'];
                                unset($_SESSION['a_date']);
                            }else{
                                $_SESSION['a_date'] = '';
                                echo $_SESSION['a_date'];
                            }  
                        ?>" 
                        placeholder="Shedule Date"> <br></br>

                        <select name="shift" class="sec-role" placeholder="Select shift" value="">
                            <option value="<?php if(isset($_SESSION['staff_shift'])){
                                echo $_SESSION['staff_shift'];
                            }else{echo '';}?>"><?php if(isset($_SESSION['staff_shift'])){
                                echo $_SESSION['staff_shift'];
                                unset($_SESSION['staff_shift']);
                            }else{
                                $_SESSION['staff_shift'] = 'Select shift';
                                echo $_SESSION['staff_shift'];
                                unset($_SESSION['staff_shift']);
                            }?></option>
                            <option value="day">Day</option>
                            <option value="night">Night</option>
                        </select> <br></br>

                        <button type="submit" class="create-btn" name="addshedule">Add Shedule</button>
                        <button type="submit" class="create-btn update" name="updateshedule">Update</button>
                        <button type="button" class="create-btn newroom-btn" name="addshedule">Add New Ward</button>
                    </form>
                    </div>
                    <?php
                    if(isset($_POST['addshedule'])){
                        $id = $_POST['id'];
                        $ward_id = $_POST['ward_id'];
                        $shift = $_POST['shift'];
                        $s_date = $_POST['s_date'];
                        $staff = $_POST['staff'];


                        $sql = "INSERT INTO ward_shedule(w_id,s_id,sheduled_date,sheduled_shift) VALUES({$ward_id},{$staff},'{$s_date}','{$shift}');";

                        if($conn->query($sql)===true){
                            unset($id);
                            unset($ward_id);
                            unset($shift);
                            unset($s_date);
                            unset($staff);
                           
                            unset($_POST['addshedule']);
                            echo "<script>
                                alert('Ward sheduled for the staff member');
                                location.replace('room.php');
                            </script>";
                           
                        }else{
                            unset($id);
                            unset($ward_id);
                            unset($shift);
                            unset($s_date);
                            unset($staff);
                           
                            unset($_POST['addshedule']);
                            
                            echo "<script>
                                alert('Cannot shedule this ward for this staff member.');
                                location.replace('room.php');
                            </script>";
                           
                        }

                    }

                    if(isset($_POST['updateshedule'])){
                        $id = $_POST['id'];
                        $ward_id = $_POST['ward_id'];
                        $shift = $_POST['shift'];
                        $s_date = $_POST['s_date'];
                        $staff = $_POST['staff'];
                        $sql = "UPDATE ward_shedule SET w_id = {$ward_id} , s_id = {$staff}, sheduled_date = '{$s_date}', sheduled_shift='{$shift}' WHERE wa_id = {$id}";
                        
                        if($conn->query($sql)===true){
                            unset($id);
                            unset($ward_id);
                            unset($shift);
                            unset($s_date);
                            unset($staff);
                            unset($_POST['updateshedule']);
                            echo "<script>
                                alert('Changes are Saved.');
                                location.replace('ward.php');
                            </script>";
                           
                        }else{
                            unset($id);
                            unset($ward_id);
                            unset($shift);
                            unset($s_date);
                            unset($staff);
                            unset($_POST['updateshedule']);
                            
                            echo "<script>
                                alert('Cannot update shedule');
                                location.replace('ward.php');
                            </script>";
                           
                        }

                    }
                    ?>
                    <div class="show-row">
                        <div class="container staff-section" id="all-rooms">
                        <h1 class="form-topic">All Room Shedules</h1>
                        <table class="staff-table">
                            <thead>
                                <tr scope="row">
                                    <th scope="col">Ref Id</th>
                                    <th scope="col">Ward Id</th>
                                    <th scope="col">Staff Id</th>
                                    <th scope="col">Member Name</th>
                                    <th scope="col">Sheduled Date</th>
                                    <th scope="col">Sheduled Shift</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    function filltable($conn){
                                        $sql = "SELECT * FROM ward_shedule r, staff s WHERE r.s_id = s.s_id";
                                        $result = $conn->query($sql);
                                        if($result->num_rows>0){
                                            while($row=$result->fetch_assoc()){ 
                                            echo "<tr>
                                            <td>$row[wa_id]</td>
                                            <td>$row[w_id]</td>
                                            <td> $row[s_id]</td>
                                            <td> $row[s_name]</td>
                                            <td>$row[sheduled_date]</td>
                                            <td>$row[sheduled_shift]</td>
                                            <td><a class='showbtn' href='helper.php?wshowid={$row['wa_id']}' ><i class='fa-regular fa-eye'></i></a>
                                            <a class='deletebtn' href='helper.php?wdelid={$row['wa_id']}' onclick='delconfirmation()'><i class='fa-solid fa-trash'></i></a>
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

                <div class="container span" id="new-room-id" >
                    <form action="" class="new-room-form" method="POST">
                    <h1 class="form-topic">Add New Ward</h1>
                        <input type="text" name="ward_id" placeholder="Ward id. Don't need to fill">
                        <input type="text" name="ward_capacity" placeholder="Ward Capacity">
                        <select name="ward_head" class="sec-role" id="" aria-placeholder="Select Room Type">
                            <option value="">--Select Head Doctor--</option>
                            <?php
                                $sql = "SELECT s_id,s_name,s_role FROM staff WHERE (s_role = 'Doctor');";
                                $result = $conn->query($sql);
                                if($result->num_rows){
                                    while($row = $result->fetch_assoc()){
                                        echo "<option value = {$row['s_id']}>
                                        {$row['s_id']} - {$row['s_name']} - {$row['s_role']}
                                            </option>";
                                    }
                                }else{
                                    echo "<option>
                                    No records Founds
                                        </option>";
                                }
                            ?>
                        </select>

                        <select name="ward_type" class="sec-role">
                            <option value="">--Select Ward Type--</option>
                            <option value="children only">Children Only</option>
                            <option value="adults only">Adults Only</option>
                            <option value="women only">Women Only</option>
                            <option value="men only">Men Only</option>
                            <option value="surgeries only">Surgeries Only</option>
                            <option value="emergency cases only">Emergency Cases Only</option>
                        </select>

                        <button type="submit" class="addroomnew-btn" name="addnewward">Add New Room</button>
                    </form>
                </div>
            </div>
        <?php
            if(isset($_POST['addnewward'])){
                $capacity = $_POST['ward_capacity'];
                $type = $_POST['ward_type'];
                $head = $_POST['ward_head'];

                echo $capacity, $type, $availability;
                $sql = "INSERT INTO ward(w_capacity,w_head,w_type)VALUES('{$capacity}',{$head},'{$type}');";

                        if($conn->query($sql)===true){
                            unset($capacity);
                            unset($availability);
                            unset($type);
                           
                           
                            unset($_POST['addnewward']);
                            echo "<script>
                                alert('New ward added');
                                location.replace('ward.php');
                            </script>";
                           
                        }else{
                            unset($capacity);
                            unset($availability);
                            unset($type);
                           
                           
                            unset($_POST['addnewward']);
                            echo "<script>
                                alert('New ward cannot add');
                                location.replace('ward.php');
                            </script>";
                           
                        }
            }
        ?>
        </div>
            </div>
        
        </div>

        <?php
            if(isset($_POST['logoutbtn'])){
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