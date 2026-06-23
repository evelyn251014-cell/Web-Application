<?php
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
$Title = $_POST["title"];
$Author = $_POST["author"];
$Description = $_POST["description"];
$price = $_POST["price"];

$sql = "INSERT INTO booklist (ISBN, title, author, description, price)
VALUES ('$_POST[ISBN]' ,'$_POST[title]','$_POST[author]', '$_POST[description]', '$_POST[price]')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
header("Location:booklist.php");
}

$conn->close();
?>