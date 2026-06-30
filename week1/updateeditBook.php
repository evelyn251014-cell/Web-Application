<?php
session_start();

$servername = "localhost";
$username = "evelynlim";
$password = "KOhWKf)4RH8MN.AO";
$dbname = "evelynlim";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$ISBN = $_POST["ISBN"];
$title = $_POST["title"];
$author = $_POST["author"];
$description = $_POST["description"];
$price = $_POST["price"];

$sql = "UPDATE booklist SET
        title='$title',
        author='$author',
        description='$description',
        price='$price'
        WHERE ISBN='$ISBN'";


if (mysqli_query($conn, $sql)) {
  header("Location:booklist.php");
} else {
  echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
