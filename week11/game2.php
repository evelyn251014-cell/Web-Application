<?php
session_start();

$servername = "localhost";
$username = "evelynlim";
$password = "KOhWKf)4RH8MN.AO";
$dbname = "evelynlim";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$_SESSION['play_count'] = $_SESSION['play_count'] ?? 0;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_number'])) {
    if ($_SESSION['play_count'] >= 2) {
        echo "<script>alert('Limit reached! You cannot submit more than 2 times.'); window.location.href='game1.php';</script>";
        exit();
    }
    
    $email = $_SESSION['email'];
    $selected_number = (int)$_POST['btn_number'];
    

    $sql = "UPDATE guest SET G2 = '$selected_number' WHERE Email = '$email'";

   if ($conn->query($sql) === TRUE) {
        $_SESSION['play_count']++;
        echo "<script>alert('Updated! Play count: " . $_SESSION['play_count'] . "/2'); window.location.href='game2.php';</script>";
        exit();
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Game 1</title>
</head>
<body>

    <h1>Game 2</h1>

    <form method="POST">
        <button type="submit" name="btn_number" value="0">0</button>
        <button type="submit" name="btn_number" value="1">1</button>
        <button type="submit" name="btn_number" value="2">2</button>
        <button type="submit" name="btn_number" value="3">3</button>
        <button type="submit" name="btn_number" value="4">4</button>
        <button type="submit" name="btn_number" value="5">5</button>
    </form>

</body>
</html>