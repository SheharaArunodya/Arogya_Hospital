
<?php
include('db_files/database.php');
$newdb = new dbclass();
echo "<link rel='stylesheet' type='text/stylesheet' href='css_files/home.css'>";
$conn = $newdb->create_con();

if(isset($_GET['id'])){
    $id = $_GET['id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <h1>
        Admin Id : <?php echo $id ?>
    </h1>
</body>
</html>