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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box; 
            font-family: Arial, sans-serif; 
        }

        body {
            background-color: #fcfbf9; 
            padding: 40px;
        }

        .container {
            max-width: 1200px;
            margin-left: 290px;
        }

        .button-container {
             padding: 20px;
            text-align: right;
            margin-right: auto;


        }

        .custitle {
            color: #ffffff;
            background-color: #000000;
            border-radius: 10px;
            padding: 15px 30px;
            font-size: 24px;
            display: inline-block;
        }

        .btn-create {
            background-color: #000000;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            display: inline-block;
            transition: background 0.2s;
        }

        .btn-create:hover {
            background-color: #333333;
        }

        .customer-table {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .customer-table th, 
        .customer-table td { 
            padding: 18px 20px; 
            text-align: left; 
            border-bottom: 1px solid #eeeeee;
        }

        .customer-table th {
            background-color: #f4f4f4;
            font-weight: bold;
            color: #333333;
        }

        .btn-action {
            background-color: #000;
            color: white;
            border: none;
            padding: 6px 14px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
        }
    </style>
</head>
<body>
    <?php include('customer.php'); ?>
    <div class="container">

    <div class="button-container">
            <a href="createcus.php" class="btn-create">Create Account</a>
    </div>
    

    <table class="customer-table">
         <h1 class="custitle details">Customer List</h1>
            <tr> 
                <th>CusID</th>
                <th>Username</th>
                <th>First name</th>
                <th>Last name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Phone</th>
            </tr>

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
        <td><button class="btn-action">Edit</button></td>
        <td><a href="#" onclick="myFunction('<?php echo $row['CusID']; ?>')"><button class="btn-action">Delete</button>
        </a>
        </td>
    </tr>
<?php
    }
}
    mysqli_close($conn);
?>
</table>
<script>
function myFunction(CusID) {
    let text = "Are you sure you want to delete " + CusID + "?";

    if (confirm(text) == true) {
        window.location.href = "deletecus.php?CusID=" + CusID;
    }
}
</script>
</body>
</html>