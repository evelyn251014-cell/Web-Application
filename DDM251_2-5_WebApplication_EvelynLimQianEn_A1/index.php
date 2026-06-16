<?php
$servername = "localhost";
$username = "exercise_1";
$password = "CphpmI1W5Xsd/C1x";
$dbname = "exercise_1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

$message="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == "") {
        $user_error = "* Please enter your username.";
    }
    
    if ($password == "") {
        $pass_error = "* Please enter your password.";
    }

    if ($username != "" && $password != "") {
        $sql = "SELECT * FROM customers WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            echo "User Found";
        } else {
            echo "User is not found";
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
        <form target="_self" method="POST">
        <h2>Username</h2>
        <input type="text" name="username" placeholder="Username" required>
            <br />
            <h2>Password</h2>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit">
        </form>
  </div>
</body>
</html>