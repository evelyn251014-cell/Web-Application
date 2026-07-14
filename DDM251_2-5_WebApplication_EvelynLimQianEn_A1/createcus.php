<?php
$servername = "localhost";
$username = "exercise_1";
$password = "CphpmI1W5Xsd/C1x";
$dbname = "exercise_1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Customer</title>
    <style>
         * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif; `
        }

        body {
            background-color: #fcfbf9;
            padding: 40px;
        }

        .container {
            max-width: 1200px;
            margin-left: 290px;
            margin-top: 20px;
        }

        .customer-table {
            width: 100%;
            border-spacing: 15px 0px;
            border-collapse: separate;
        }
        .customer-table th {
            text-align: left;
            padding: 15px 10px;
            color: #555555;
            font-size: 15px;
            font-weight: 600;
            border-bottom: 2px solid #f4f4f4;
        }

        .page-title {
            color: #ffffff;
            background-color: #000000;
            border-radius: 12px;
            padding: 15px 30px;
            font-size: 26px;
            display: inline-block;
            font-weight: bold;
            margin-bottom: 30px;
        }
        
         .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .form-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .form-control {
            width: 100%;
            padding: 10px 10px;
            border: 1px solid #dddddd;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
        }

        .btn-add {
            background-color: #000000;
            color: #ffffff;
            border: none;
            padding: 10px 24px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    
     <?php include('customer.php'); ?>

     <div class="container">

     <h1 class="page-title">Create Customer</h1>

     <?php
     if (isset($_GET["error"]) && !empty($_GET["error"])) {
         echo "<p class='error-message'>" . htmlspecialchars($_GET["error"]) . "</p>";
     }
     ?>

    <div class="form-card">
            <table class="customer-table">
                <tr> 
                    <th>CusID</th>
                    <th>Username</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Phone</th>
                </tr>

                <tr>
                    <form action="insertcust.php" method="POST">
                        <td><input type="text" name="CusID" class="form-control"></td>
                        <td><input type="text" name="Username" class="form-control"></td>
                        <td><input type="text" name="First_name" class="form-control"></td>
                        <td><input type="text" name="Last_name" class="form-control"></td>
                        <td><input type="text" name="Email" class="form-control"></td>
                        <td><input type="password" name="Password" class="form-control"></td>
                        <td><input type="text" name="Phone" class="form-control"></td>
                        <td><input type="submit" name="submit_btn" class="btn-add" value="Add"></td>
                </tr>
            </table>
        </form>
    </div>
</div>
</body>
</html>