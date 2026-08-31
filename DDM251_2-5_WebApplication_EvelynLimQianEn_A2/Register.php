<?php
session_start();

$servername = "localhost";
$dbusername = "coffee_shop";
$dbpassword = "1ew.Fibz@DynoYxL";
$dbname     = "coffee_shop";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if (isset($_POST['register'])) {
    $user        = trim($_POST['Username']);
    $email       = trim($_POST['Email']);
    $pass        = $_POST['Password'];
    $confirmPass = $_POST['ConfirmPassword'];
    $phone       = trim($_POST['Phone']);

    if ($pass !== $confirmPass) {
        $message = "Passwords do not match.";
    } else {
        
        $stmt_check = $conn->prepare("SELECT Username FROM customers WHERE Username = ?");
        $stmt_check->bind_param("s", $user);
        $stmt_check->execute();
        $check_result = $stmt_check->get_result();

        if ($check_result->num_rows > 0) {
            $message = "Username already exists.";
        } else {

            $countResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM customers");
            $countData   = mysqli_fetch_assoc($countResult);
            $new_id      = $countData['total'] + 1;

            $stmt_insert = $conn->prepare("INSERT INTO customers (User_id, Username, Email, Password, Phone) VALUES (?, ?, ?, ?, ?)");
            $stmt_insert->bind_param("issss", $new_id, $user, $email, $pass, $phone);

            if ($stmt_insert->execute()) {
                $_SESSION['username'] = $user;
                header("Location: index.php");
                exit();
            } else {
                $message = "Error: " . $stmt_insert->error;
            }
            $stmt_insert->close();
        }
        $stmt_check->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - BrewMatch</title>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F4EFEB;
            background-image: radial-gradient(#D6C7B8 1px, transparent 1px);
            background-size: 24px 24px;
            padding: 40px 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #2C1810;
            margin: 0;
            box-sizing: border-box;
        }

        .container {
            max-width: 450px;
            width: 100%;
            margin: auto;
            background: white;
            padding: 35px 30px;
            border-radius: 15px;
            box-shadow: 0 12px 32px rgba(63, 29, 14, 0.08);
            box-sizing: border-box;
        }

        .title {
            text-align: center;
            font-size: 32px;
            margin: 0 0 5px 0;
            color: #2C1810;
            font-weight: 700;
        }

        .subtitle {
            text-align: center;
            font-size: 16px;
            color: #8C5A3C;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #E5D8CC;
        }

        .input-title {
            margin-top: 12px;
            margin-bottom: 5px;
            font-size: 14px;
            color: #5C321E;
            font-weight: 600;
        }

        input[type="text"], 
        input[type="email"], 
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-top: 2px;
            margin-bottom: 8px;
            box-sizing: border-box;
            border: 1px solid #E5D8CC;
            border-radius: 8px;
            font-family: inherit;
            font-size: 15px;
            color: #2C1810;
            background-color: #FAF7F5;
            transition: border-color 0.2s ease;
        }

        input[type="text"]:focus, 
        input[type="email"]:focus, 
        input[type="password"]:focus {
            border-color: #8C5A3C;
            outline: none;
            background-color: #FFFFFF;
        }

        .button {
            display: block;
            width: 100%;
            padding: 14px;
            background-color: #5C321E;
            color: #FFFFFF;
            font-size: 15px;
            font-family: inherit;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 20px;
            box-shadow: 0 4px 12px rgba(92, 50, 30, 0.2);
            transition: all 0.2s ease;
        }

        .button:hover {
            background-color: #422314;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(92, 50, 30, 0.28);
        }

        .button:active {
            transform: translateY(0);
        }

        .login-link {
            display: block;
            text-align: center;
            margin-top: 18px;
            font-size: 14px;
            color: #8C5A3C;
            font-weight: 600;
            text-decoration: none;
        }

        .login-link:hover {
            color: #5C321E;
            text-decoration: underline;
        }

        .error {
            color: #D9534F;
            background: #ffecec;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="title">BrewMatch</h1>
    <div class="subtitle">Create an account to get started</div>

    <?php if (!empty($message)): ?>
        <div class="error"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="input-title">Username</div>
        <input type="text" name="Username" placeholder="Enter your username" required>

        <div class="input-title">Email</div>
        <input type="email" name="Email" placeholder="Enter your email" required>

        <div class="input-title">Password</div>
        <input type="password" name="Password" placeholder="Enter password" required>

        <div class="input-title">Confirm Password</div>
        <input type="password" name="ConfirmPassword" placeholder="Re-enter password" required>

        <div class="input-title">Phone</div>
        <input type="text" name="Phone" placeholder="Enter phone number" required>

        <input type="submit" name="register" class="button" value="Register">

        <a href="Login.php" class="login-link">Already have an account? Login here</a>
    </form>
</div>

</body>
</html>

<?php
mysqli_close($conn);
?>