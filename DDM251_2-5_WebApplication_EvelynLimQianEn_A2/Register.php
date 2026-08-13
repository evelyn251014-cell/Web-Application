<?php
$servername = "localhost";
$dbusername = "coffee_shop";
$dbpassword = "1ew.Fibz@DynoYxL";
$dbname = "coffee_shop";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if (isset($_POST['username'], $_POST['password'], $_POST['confirm_password'], $_POST['phone']))  {

    $user = $_POST['username'];
    $pass = $_POST['password'];
    $confirmPass = $_POST['confirm_password'];
    $phone = $_POST['phone'];

if ($pass !== $confirmPass) {
        $message = "Passwords do not match";
    } else {
        $checkSql = "SELECT * FROM customers WHERE username = '$user'";
        $checkResult = $conn->query($checkSql);

    if ($checkResult && $checkResult->num_rows > 0) {
                $message = "Username already exists";
            } else {

                $sql = "INSERT INTO customers (username, password, phone) VALUES ('$user', '$pass', '$phone')";
                
                if ($conn->query($sql) === TRUE) {
                    header("Location: index.php");
                    exit();
                } else {
                    $message = "Error: " . $conn->error;
                }
            }
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        * { 
            font-size: 20px;
            box-sizing: border-box;
        }

        body {
           display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            padding: 20px 0;
            background-color: #E6E2D7;
            color: #3F1D0E;
        }

        .title {
           text-align: center;
            font-size: 40px;
            margin-bottom: 5px;
            color: #3F1D0E; 
            font-weight: bold;
        }

        .subtitle {
            text-align: center;
            font-size: 26px;
            margin-bottom: 20px;
            color: #3F1D0E;
        }

        .box {
             width: 360px;
            background-color: #E4CDB0; 
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(63, 29, 14, 0.15);
        }

        .input-title {
            margin-top: 12px;
            margin-bottom: 5px;
            font-size: 16px;
            color: #3F1D0E;
            font-weight: bold;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .button {
            width: 100%;
            padding: 12px;
            background-color: #A2663C; 
            color: #FFFFFF;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 20px;
            font-weight: bold;
            font-size: 18px;
            transition: background 0.3s ease;
        }

        .login-link {
            display: block;
            text-align: center;
            margin-top: 18px;
            font-size: 15px;
            color: #3F1D0E;
            font-weight: bold;
    }
   </style>
</head>
<body>

<div class="container">
    <h1 class="title">BrewMatch</h1>
    
    <div style="color: red; font-weight: bold; text-align: center; margin-bottom: 10px;">
        <?php echo $message; ?>
    </div>

    <div class="box">
        <h2 class="subtitle">Register</h2>

        <form target="_self" method="POST">

            <div class="input-title">Username</div>
            <input type="text" name="Username">
            
            <div class="input-title">Email</div>
            <input type="email" name="Email">

            <div class="input-title">Password</div>
            <input type="password" name="Password"  minlength="6">

            <div class="input-title">Confirm Password</div>
            <input type="password" name="ConfirmPassword" minlength="6">

            <div class="input-title">Phone</div>
            <input type="text" name="Phone" minlength="10">
            
            <input type="submit" name="register" class="button" value="Register">
            
            <a href="Login.php" class="login-link">Already have an account? Login here</a>
        </form>
    </div>
</div>

</body>
</html>