<?php
$servername = "localhost";
$username = "exercise_1";
$password = "CphpmI1W5Xsd/C1x";
$dbname = "exercise_1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$CusID = $_POST["CusID"];
$Username = $_POST["Username"];
$First_name = $_POST["First_name"];
$Last_name = $_POST["Last_name"];
$Email = $_POST["Email"];
$Password = $_POST["Password"];
$Phone = $_POST["Phone"];

$sql = "INSERT INTO customers (CusID, Username, First_name, Last_name, Email, Password, Phone)
VALUES ('$_POST[CusID]' ,'$_POST[Username]','$_POST[First_name]', '$_POST[Last_name]', '$_POST[Email]','$_POST[Password]', '$_POST[Phone]')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
header("Location:customerlist.php");
} 
$conn->close();
?>