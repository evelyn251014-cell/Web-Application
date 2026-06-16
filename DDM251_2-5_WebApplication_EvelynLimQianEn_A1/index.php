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
    $username = $_POST['Username'];
    $password = $_POST['Password'];

    if ($username == "") {
        $message = $message . "* Please enter your username.<br/>";
    }
    
    if ($password == "") {
        $message = $message . "* Please enter your password.<br/>";
    }

if ($username != "" && $password != "" && !$conn->connect_error) {
        
        $sql = "SELECT * FROM customers WHERE Username = '$username'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['Password'] == $password) {
                echo"Customer Found";
                 header("Location: customer.php");
            } else {
                $message = "* Your password is incorrect.<br/>";
            } 
        } else {
            echo "Customer is not found";
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

    .username {
        border: 2px solid black;
        padding: 20px;
        border-radius: 10px;
    }

    .title {
        text-align: center;
        font-size: 30px;
    }

    .submit{
        display: block;
        margin: auto;
    }

    </style>
<body>

    <div class="username">
        <h1 class="title">Welcome</h1>
        <div style="color: red; font-weight: bold;">
            <?php echo $message; ?>
        </div>

        <form target="_self" method="POST">
            <h2>Username</h2>
            <input type="text" name="Username" placeholder="Username">
            <br />
            <h2>Password</h2>
            <input type="password" name="Password" placeholder="Password">
            <br /><br />
            <input type="submit" class="submit" value="Login">
        </form>
    </div>
</body>
</html>