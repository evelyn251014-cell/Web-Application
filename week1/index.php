<?php
session_start();

$servername = "localhost";
$username = "evelynlim";
$password = "KOhWKf)4RH8MN.AO";
$dbname = "evelynlim";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM student WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);
   
    if ($result->num_rows > 0) {
      $_SESSION['email'] = $_POST['email'];
      header("Location:booklist.php");
        echo "User Found";
    } else {
        echo "User is not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
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
</head>
<body>
  <div id="email">
    <form target="_self" method="POST">
      <h2>Enter your Email:</h2>
      <input type="text" name="email">
        <br />
        <h2>Password</h2>
        <input type="password" name="password">
        <input type="submit">
    </form>
  </div>


</body>
</html>