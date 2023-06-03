<?php
include('db_files/database.php');
$newdb = new dbclass();
$conn = $newdb->create_con();
session_start();

if (isset($_GET['id'])) {
    $staffId = $_GET['id'];
}

$sql = "SELECT * FROM staff WHERE s_id = {$staffId};";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $staffName = $row['s_name'];
        $staffId = $row['s_id'];
        $staffAge = $row['s_age'];
        $staffContact = $row['s_tpno'];
        $staffEmail = $row['s_email'];
        $staffRole = $row['s_role'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings - AHS</title>
    <link rel="stylesheet" href="./css_files/profile.css">
</head>
<body>
    <h1>
        <?php echo $staffId ?>
    </h1>
    <h1>
        <?php echo $staffName ?>
    </h1>
    <h1>
        <?php echo $staffAge ?>
    </h1>
    <h1>
        <?php echo $staffRole ?>
    </h1>
    <h1>
        <?php echo $staffEmail ?>
    </h1>
    <h1>
        <?php echo $staffContact ?>
    </h1>
    
</body>
</html>
