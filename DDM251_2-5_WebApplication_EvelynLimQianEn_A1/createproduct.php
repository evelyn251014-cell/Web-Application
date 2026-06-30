<?php
$servername = "localhost";
$username = "exercise_1";
$password = "CphpmI1W5Xsd/C1x";
$dbname = "exercise_1";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
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
            margin-top: 20px;
            
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

        .form-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
        }

        .product-table th {
            text-align: left;
            padding: 15px 10px;
            color: #555555;
            font-size: 15px;
            font-weight: 600;
            border-bottom: 2px solid #f4f4f4;
        }

        .product-table td {
            padding: 20px 10px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
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

    <h1 class="page-title">Create Product</h1>

    <div class="form-card">
        <table class="product-table">
            <tr> 
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Price (RM)</th>
                        <th>Stock</th>
</tr>
                <tr>
                    <form action="insertproduct.php" method="POST">
                    <td><input type="text" name="ProductID" class="form-control"></td>
                    <td><input type="text" name="Name" class="form-control"></td>
                    <td><input type="text" name="Price" class="form-control"></td>
                    <td><input type="text" name="Stock" class="form-control"></td>
                    <td style="text-align: right;">
                    <input type="submit" class="btn-add" value="Add"></td>
            </tr>
        </table>
    </div>

</div>

</body>
</html>