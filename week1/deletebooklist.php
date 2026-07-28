<?php
$servername = "localhost";
$username = "evelynlim";
$password = "KOhWKf)4RH8MN.AO";
$dbname = "evelynlim";

$conn = new mysqli($servername, $username, $password, $dbname);

// Create connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$ISBN = $_GET["ISBN"];

// SQL to delete a record
$sql = "DELETE FROM booklist WHERE ISBN= '$ISBN'";

if (mysqli_query($conn, $sql)) {
  header("Location:booklist.php");
} else {
  echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>