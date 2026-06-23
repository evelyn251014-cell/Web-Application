<?php
session_start();

$servername = "localhost";
$username = "evelynlim";
$password = "KOhWKf)4RH8MN.AO";
$dbname = "evelynlim";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// SQL to update a record
$sql = "UPDATE student SET name='Joe' WHERE email='".$_SESSION["email"]."', password='".$_SESSION["password"]."', yearjoin='".$_SESSION["yearjoin"]."'" ;

if (mysqli_query($conn, $sql)) {
  header("Location:profile.php");
  echo "Record updated successfully";
} else {
  echo "Error updating record: " . mysqli_error($conn);
}


mysqli_close($conn);
?>
