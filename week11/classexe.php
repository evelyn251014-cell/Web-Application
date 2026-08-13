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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $age   = (int)($_POST['age'] ?? 0);

    date_default_timezone_set('Asia/Kuala_Lumpur');
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = '';

    for ($i = 0; $i < 6; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }

    $uid = date('YmdHis') . "_" . $code;

    // Insert auto-generated UID into the database
   $sql = "INSERT INTO guest (Name, Email, Age, UID, G1, G2, G3) VALUES ('$name', '$email', '$age', '$uid', 0, 0, 0)";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['email'] = $email;
        $_SESSION['cus_id'] = $uid;

        echo "<script>alert('Registration Successful!'); window.location.href='game.php';</script>";
        exit();
    } else {
        echo "Database Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>

    <div class="container">
        <form target="_self" method="POST">
            <h3>Name:</h3>
            <input type="text" name="name" required>
            <h3>Email:</h3>
            <input type="email" name="email" required>
            <h3>Age:</h3>
            <input type="number" name="age" required>
            <br><br>
            <input type="submit" value="Submit">
        </form>
    </div>

</body>
</html>