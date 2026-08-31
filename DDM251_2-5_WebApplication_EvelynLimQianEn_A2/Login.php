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
if (isset($_POST['username'], $_POST['password'])) {
    $user     = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM customers WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $user, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $_SESSION['username'] = $user;
        header("Location: index.php");
        exit(); 
    } else {
        $message = "User is not found or password is incorrect.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BrewMatch</title>
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
            margin-top: 15px;
            margin-bottom: 5px;
            font-size: 14px;
            color: #5C321E;
            font-weight: 600;
        }

        input[type="text"], 
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            margin-bottom: 10px;
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
        input[type="password"]:focus {
            border-color: #8C5A3C;
            outline: none;
            background-color: #FFFFFF;
        }

        .register-link {
            display: block;
            text-align: right;
            margin-top: 5px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #8C5A3C;
            font-weight: 600;
            text-decoration: none;
        }

        .register-link:hover {
            color: #5C321E;
            text-decoration: underline;
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
            margin-top: 10px;
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
    <div class="subtitle">Welcome! Please enter your details.</div>

    <?php if (!empty($message)): ?>
        <div class="error"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="input-title">Username</div>
        <input type="text" name="username" placeholder="Enter your username" required>
        
        <div class="input-title">Password</div>
        <input type="password" name="password" placeholder="Enter your password" required>
        
        <a class="register-link" href="Register.php">Don't have an account? Register</a>

        <input type="submit" name="login" class="button" value="Sign In">
    </form>
</div>

</body>
</html>
<?php
$conn->close();
?>