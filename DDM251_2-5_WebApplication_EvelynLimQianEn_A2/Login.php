<?php
$servername = "localhost";
$dbusername = "Coffee_shop";
$dbpassword = "1ew.Fibz@DynoYxL";
$dbname = "Coffee_shop";

$message = "";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    $message = "Database connection failed: " . $conn->connect_error . "<br>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['login'])) {

        $username = $_POST['Username'];
        $password = $_POST['Password'];

        if ($username == "") {
            $message .= "* Please enter your username.<br/>";
        }

        if ($password == "") {
            $message .= "* Please enter your password.<br/>";
        }

        if ($username != "" && $password != "") {

            $stmt = $conn->prepare("SELECT * FROM customers WHERE Username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {

                $row = $result->fetch_assoc();

                if ($row['Password'] == $password) {
                    header("Location: customer.php");
                    exit();
                } else {
                    $message = "* Your password is incorrect.<br/>";
                }

            } else {
                $message = "* Customer is not found.<br/>";
            }
        }
    }


    if (isset($_POST['register'])) {

        $username = $_POST['Username'];
        $email = $_POST['Email'];
        $password = $_POST['Password'];
        $confirmPassword = $_POST['ConfirmPassword'];


        if ($username == "") {
            $message .= "* Please enter username.<br>";
        }

        if ($email == "") {
            $message .= "* Please enter email.<br>";
        }

        if ($password == "") {
            $message .= "* Please enter password.<br>";
        }

        if ($password != $confirmPassword) {
            $message .= "* Password does not match.<br>";
        }


        if ($message == "") {

            $check = $conn->prepare("SELECT Username FROM customers WHERE Username = ?");
            $check->bind_param("s", $username);
            $check->execute();

            $result = $check->get_result();


            if ($result->num_rows > 0) {

                $message = "* Username already exists.<br>";

            } else {

            $stmt = $conn->prepare(
                    "INSERT INTO customers (Username, Email, Password) VALUES (?, ?, ?)"
                );

                $stmt->bind_param(
                    "sss",
                    $username,
                    $email,
                    $password
                );


                if ($stmt->execute()) {
                    $message = "Registration successful. You can login now.<br>";
                } else {
                    $message = "Registration failed.<br>";
                }
            }
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <style>
        *{ 
            font-size: 20px;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        .title {
            text-align: center;
            font-size: 40px;
        }

        .subtitle {
            text-align: center;
            font-size: 30px;
        }

    
        .box {
            width: 300px;
            background-color: #f2f2f2;
            padding: 20px;
            border-radius: 8px;
        }

   </style>
</head>
<body>
<div class="container">
    <h1 class="title">BrewMatch</h1>
    <div style="color: red; font-weight: bold;">
            <?php echo $message; ?>
</div>

<div class="box">
<h2 class="subtitle">Login</h2>
<form method="POST">
    <h2 class="input">Username</h2>
    <input type="text" name="Username" placeholder="Username">
    <br />
    <h2 class="input">Password</h2>
    <input type="password" name="Password" placeholder="Password">
    <br />
    <input type="submit" name="Login" class="button" value="Login">
</form>
</div>
</body>

</html>


