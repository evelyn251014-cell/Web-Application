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
$sql = "UPDATE student
        SET
            name='" . $_POST["name"] . "',
            password='" . $_POST["password"] . "',
            yearjoin='" . $_POST["yearjoin"] . "'
        WHERE email='" . $_SESSION["email"] . "'";
        
if (mysqli_query($conn, $sql)) {
  header("Location:profile.php");
} else {
  echo "Error updating record: " . mysqli_error($conn);
}


mysqli_close($conn);
?>
