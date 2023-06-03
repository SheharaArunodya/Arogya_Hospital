<?php
    session_start();
    include('db_files/database.php');
    $newdb = new dbclass();
    $conn = $newdb->create_con();
    try{
        if($_GET['showid']){
            $sql = "SELECT * FROM staff WHERE s_id = {$_GET['showid']}";
            $result = $conn->query($sql);
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){ 
                    $_SESSION['id'] = $row['s_id'];
                    $_SESSION['name'] = $row['s_name'];
                    $_SESSION['age'] = $row['s_age'];
                    $_SESSION['srole'] = $row['s_role'];
                    $_SESSION['tpno'] = $row['s_tpno'];
                    $_SESSION['email'] = $row['s_email'];
                    $_SESSION['pw'] = '';
                    echo "<script>location.replace('staff.php');</script>";
                }
            }
        }
    
        if($_GET['delid']){
            $sql = "DELETE FROM staff WHERE s_id = {$_GET['delid']};";
            $result = $conn->query($sql);
            if($result===true){
                echo "<script>
                        alert('Member Removed Successfully');
                        location.replace('staff.php');
                        </script>";
            }else{
                echo "<script>
                        alert('Cannot remove');
                        location.replace('staff.php');
                        </script>";
            }
        }
    
        if($_GET['pshowid']){
            $sql = "SELECT * FROM patient WHERE p_id = {$_GET['pshowid']}";
            $result = $conn->query($sql);
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){ 
                    $_SESSION['id'] = $row['p_id'];
                    $_SESSION['name'] = $row['p_name'];
                    $_SESSION['age'] = $row['p_age'];
                    $_SESSION['address'] = $row['p_add'];
                    $_SESSION['tpno'] = $row['p_tpno'];
                    $_SESSION['email'] = $row['p_email'];
                    $_SESSION['pw'] = '';
                    echo "<script>location.replace('patients.php');</script>";
                }
            }
        }
        if($_GET['pdelid']){
            $sql = "DELETE FROM patient WHERE p_id = {$_GET['pdelid']};";
            $result = $conn->query($sql);
            if($result===true){
                echo "<script>
                        alert('Patient Removed Successfully');
                        location.replace('patients.php');
                        </script>";
            }else{
                echo "<script>
                        alert('Cannot remove');
                        location.replace('patients.php');
                        </script>";
            }
        }
    
        if($_GET['jshowid']){
            $sql = "SELECT * FROM inquiry_assignment WHERE j_id = {$_GET['jshowid']}";
            $result = $conn->query($sql);
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){ 
                    $_SESSION['job_id'] = $row['j_id'];
                    $_SESSION['InquiryId'] = $row['i_id'];
                    $staffid = $row['s_id'];
                    
                    $sql2 = "SELECT s_name FROM staff WHERE s_id = {$staffid};";
                    $result2 = $conn->query($sql2);
                    $row = $result2 -> fetch_assoc();
                    $staffname = $row['s_name'];
    
                    $_SESSION['receptionistName'] = "{$staffid} - {$staffname}";
    
                    echo "<script>
                    location.replace('inquiry.php');
                    </script>";
                }
            }
        }
        if($_GET['jdelid']){
    
            $sql2 = "SELECT i_id FROM inquiry_assignment WHERE j_id = {$_GET['jdelid']};";
            $result=$conn->query($sql2);
            $row = $result->fetch_assoc();
            $inq_id = $row['i_id'];
    
            $sql = "DELETE FROM inquiry_assignment WHERE j_id = {$_GET['jdelid']};";
            $result = $conn->query($sql);
            if($result===true){
                echo "<script>
                        alert('Inquiry Assignment Removed');</script>";
                $sql3 = "UPDATE inquiry SET status = 'Pending' WHERE i_id = {$inq_id};";
                if($conn->query($sql3)){
                    echo "<script>
                    alert('Inquiry status changed');
                    location.replace('inquiry.php');
                    </script>";
                }else{
                    echo "<script>
                    alert('Inquiry status cannot change');
                    location.replace('inquiry.php');
                    </script>";
                }
            }else{
                echo "<script>
                        alert('Cannot remove the Inquiry Assignment');
                        location.replace('inquiry.php');
                        </script>";
            }
        }
    
        if($_GET['roomshowid']){
            $sql = "SELECT * FROM room_assignment WHERE ra_id = {$_GET['roomshowid']}";
            $result = $conn->query($sql);
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){ 
                   
    
                    $_SESSION['staff_shift'] = $row['sheduled_shift'];
                    $_SESSION['a_date'] = $row['sheduled_date'];
                    $staffid = $row['s_id'];
                    $_SESSION['r_id'] = $row['r_id'];
                    $_SESSION['id'] = $row['ra_id'];
                    
                    $sql2 = "SELECT s_id,s_name FROM staff WHERE s_id = {$staffid};";
                    $result2 = $conn->query($sql2);
                    while($row=$result2->fetch_assoc()){
                        $staffname = $row['s_name'];
                        $_SESSION['staff_id'] = $row['s_id'];
    
                    }
                   
    
                    $_SESSION['staff'] = "{$staffid}-{$staffname}";
                   
                    echo "<script>
                    location.replace('room.php');
                    </script>";
    
    
                }
            }
        }
    
        if($_GET['roomdelid']){
            $sql = "DELETE FROM room_assignment WHERE ra_id = {$_GET['roomdelid']};";
            $result = $conn->query($sql);
            if($result===true){
                echo "<script>
                        alert('Shedule Removed Successfully');
                        location.replace('room.php');
                        </script>";
            }else{
                echo "<script>
                        alert('Cannot remove');
                        location.replace('room.php');
                        </script>";
            }
        }
        if($_GET['wshowid']){
            $sql = "SELECT * FROM ward_shedule WHERE wa_id = {$_GET['wshowid']}";
            $result = $conn->query($sql);
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){ 
                   
    
                    $_SESSION['staff_shift'] = $row['sheduled_shift'];
                    $_SESSION['a_date'] = $row['sheduled_date'];
                    $staffid = $row['s_id'];
                    $_SESSION['w_id'] = $row['w_id'];
                    $_SESSION['id'] = $row['wa_id'];
                    
                    $sql2 = "SELECT s_id,s_name FROM staff WHERE s_id = {$staffid};";
                    $result2 = $conn->query($sql2);
                    while($row=$result2->fetch_assoc()){
                        $staffname = $row['s_name'];
                        $_SESSION['staff_id'] = $row['s_id'];
    
                    }
                   
    
                    $_SESSION['staff'] = "{$staffid}-{$staffname}";
                   
                    echo "<script>
                    location.replace('ward.php');
                    </script>";
    
    
                }
            }
        }
    
        if($_GET['wdelid']){
            $sql = "DELETE FROM ward_shedule WHERE wa_id = {$_GET['wdelid']};";
            $result = $conn->query($sql);
            if($result===true){
                echo "<script>
                        alert('Shedule Removed Successfully');
                        location.replace('ward.php');
                        </script>";
            }else{
                echo "<script>
                        alert('Cannot remove');
                        location.replace('ward.php');
                        </script>";
            }
        }
    
        if($_GET['tshowid']){
            $sql = "SELECT * FROM theater_shedule WHERE ta_id = {$_GET['tshowid']}";
            $result = $conn->query($sql);
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){ 
                   
    
                    $_SESSION['staff_shift'] = $row['sheduled_shift'];
                    $_SESSION['a_date'] = $row['sheduled_date'];
                    $staffid = $row['s_id'];
                    $_SESSION['t_id'] = $row['t_id'];
                    $_SESSION['id'] = $row['ta_id'];
                    
                    $sql2 = "SELECT s_id,s_name FROM staff WHERE s_id = {$staffid};";
                    $result2 = $conn->query($sql2);
                    while($row=$result2->fetch_assoc()){
                        $staffname = $row['s_name'];
                        $_SESSION['staff_id'] = $row['s_id'];
    
                    }
                   
    
                    $_SESSION['staff'] = "{$staffid}-{$staffname}";
                   
                    echo "<script>
                    location.replace('theater.php');
                    </script>";
    
    
                }
            }
        }
    
        if($_GET['tdelid']){
            $sql = "DELETE FROM theater_shedule WHERE ta_id = {$_GET['tdelid']};";
            $result = $conn->query($sql);
            if($result===true){
                echo "<script>
                        alert('Shedule Removed Successfully');
                        location.replace('theater.php');
                        </script>";
            }else{
                echo "<script>
                        alert('Cannot remove');
                        location.replace('theater.php');
                        </script>";
            }
        }
    }catch(Exception $ex){
        echo "<script>
                        alert('Error with Syntaxes');
                        location.replace('".$ex."');
                        </script>";
    }
?>