<?php
$servername = "localhost";
$username = "exercise_1";
$password = "CphpmI1W5Xsd/C1x";
$dbname = "exercise_1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$OrderID = $_GET["OrderID"];


$sql = "DELETE FROM orders WHERE Orders_ID = '$OrderID'";

if (mysqli_query($conn, $sql)) {
    header("Location: order.php");
    exit();
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>