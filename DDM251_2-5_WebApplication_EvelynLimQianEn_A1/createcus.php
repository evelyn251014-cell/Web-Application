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
        .btn-submit {
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

    </style>
</head>
<body>
     <?php include('customer.php'); ?>

     <h1 class="custitle details">Create Customer</h1>

    <div class="details">
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
                 <form action="insertcust.php" method="POST">
                <td><input type="text" name=CusID></td>
                <td><input type="text"  name=Username></td>
                <td><input type="text"  name=First_name></td>
                <td><input type="text"  name=Last_name></td>
                <td><input type="text"  name=Email></td>
                <td><input type="Password" name=Password></td>
                <td><input type="text" name=Phone></td>
                <td><input type=submit value=add ></td>
                 </form>
             <tr>
    </div>
</body>
</html>