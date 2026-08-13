<?php
$servername = "localhost";
$dbusername = "coffee_shop";
$dbpassword = "1ew.Fibz@DynoYxL";
$dbname = "coffee_shop";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shops - Location</title>
</head>
<body>
</body>
</html>