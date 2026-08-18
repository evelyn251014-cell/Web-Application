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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_number'])) {
    
    $uid = $_SESSION['cus_id'];


    $result = $conn->query("SELECT G3_GameClick FROM guest WHERE UID = '$uid'");
    $row = $result->fetch_assoc();
    $current_count = (int)($row['G3_GameClick'] ?? 0);
    if ($current_count >= 2) {
        echo "<script>alert('Limit reached! You cannot submit more than 2 times.'); window.location.href='game3.php';</script>";
        exit();
    }
    
    $selected_number = (int)$_POST['btn_number'];

    $sql = "UPDATE guest SET G3 = '$selected_number', G3_GameClick = G3_GameClick + 1 WHERE UID = '$uid'";

    if ($conn->query($sql) === TRUE) {
        $new_count = $current_count + 1;
        echo "<script>alert('Updated! Play count: " . $new_count . "/2'); window.location.href='game3.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Game 3</title>
</head>
<body>

    <button><a href="game.php">Back</a></button>

    <h1>Game 3</h1>

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