<?php
$servername = "localhost";
$username = "exercise_1";
$password = "CphpmI1W5Xsd/C1x";
$dbname = "exercise_1";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM customers";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer List</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif; 
        }

      .button-container {
            padding: 20px;
            text-align: right;
            margin-right: auto;
        }
        .details {
            margin-left: 290px;
            max-width: 1200px;
        }

        .table {
            width: 100%;
            margin-right: auto;
            border-collapse: collapse;
            margin-bottom: 20px;
            overflow: hidden;
        }
        table, 
        th, 
        td { 
            padding: 20px; 
            text-align: left:
        }
        .custitle {
            color: #ffffff;
            background-color: #000000;
            border-radius: 10px;
            padding: 20px 30px;
            margin-right: 20px;
        }

        .btn-create {
            background-color:#000000;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            display: inline-block;
        }
    </style>
</head>
<body>
    <?php include('customer.php'); ?>
    <div class="button-container">
            <a href="createcus.php" class="btn-create">Create Account</a>
    </div>
    
    <table width="600">
    <h1 class="custitle details">Customer List</h1>

    <div>
        <table class="details">
            <tr> 
                <th>CusID</th>
                <th>Username</th>
                <th>First name</th>
                <th>Last name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Phone</th>
            </tr>
    </div>
 <?php
    $query = "SELECT * FROM customer";
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
?>
    <tr>
        <td><?php echo $row['CusID']; ?></td>
        <td><?php echo $row['Username']; ?></td>
        <td><?php echo $row['First_name']; ?></td> 
        <td><?php echo $row['Last_name']; ?></td>
        <td><?php echo $row['Email']; ?></td>
        <td><?php echo $row['Password']; ?></td>
        <td><?php echo $row['Phone']; ?></td>
        <td><input type=submit value= Edit></td>
    </tr>
<?php
    }
}
    mysqli_close($conn);
?>
</table>

</body>
</html>