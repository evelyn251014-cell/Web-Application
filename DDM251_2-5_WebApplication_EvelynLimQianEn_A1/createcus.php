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
        .details {
            margin-left: 280px;
        }

        .table {
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, 
        th, 
        td {  
            text-align: auto;
        }

        .custitle {
            width: 75%;
            color: #ffffff;
            background-color: #000000;
            border-radius: 10px;
            padding: 20px; 
            margin-top: 20px;
            margin-bottom: 20px;
        }
        
        .error-message {
            margin-left: 280px;
            margin-bottom: 15px;
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    
     <?php include('customer.php'); ?>

     <h1 class="custitle details">Create Customer</h1>

     <?php
     if (isset($_GET["error"]) && !empty($_GET["error"])) {
         echo "<p class='error-message'>" . htmlspecialchars($_GET["error"]) . "</p>";
     }
     ?>

    <div class="details">
        <form action="insertcust.php" method="POST">
            <table>
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
                    <td><input type="text" name="CusID"></td>
                    <td><input type="text" name="Username"></td>
                    <td><input type="text" name="First_name"></td>
                    <td><input type="text" name="Last_name"></td>
                    <td><input type="text" name="Email"></td>
                    <td><input type="password" name="Password"></td>
                    <td><input type="text" name="Phone"></td>
                    <td><input type="submit" name="submit_btn" value="add"></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>