<?php
$servername = "localhost";
$username = "exercise_1";
$password = "CphpmI1W5Xsd/C1x";
$dbname = "exercise_1";

// Create connection

$message = "";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    $message = "Database connection failed: " . $conn->connect_error . "<br>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == "") {
        $message = $message . "* Please enter your username.<br/>";
    }
    
    if ($password == "") {
        $message = $message . "* Please enter your password.<br/>";
    }

    if ($username != "" && $password != "" && !$conn->connect_error) {
        $sql = "SELECT * FROM customers WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $message = "User Found";
        } else {
            $message =  "User is not found";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
  <style>
    *{
      font-size: 20px;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    </style>
<body>
    
<div id="username">
        <div style="color: red; font-weight: bold;">
            <?php echo $message; ?>
        </div>

        <form target="_self" method="POST">
            <h2>Username</h2>
            <input type="text" name="username" placeholder="Username">
            <br />
            <h2>Password</h2>
            <input type="password" name="password" placeholder="Password">
            <br /><br />
            <input type="submit">
        </form>
    </div>
</body>
</html>