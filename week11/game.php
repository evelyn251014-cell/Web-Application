<?php
session_start();

$servername = "localhost";
$username = "evelynlim";
$password = "KOhWKf)4RH8MN.AO";
$dbname = "evelynlim";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    $uid = $_SESSION['cus_id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game</title>
</head>
<body>
    <h1>Game 1</h1>
    <button><a href="game1.php">Play Game 1</a></button>
    <h1>Game 2</h1>
    <button><a href="game2.php">Play Game 2</a></button>
    <h1>Game 3</h1>
    <button><a href="game3.php">Play Game 3</a></button>
</body>
</html>