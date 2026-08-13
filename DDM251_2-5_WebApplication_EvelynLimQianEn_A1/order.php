<?php
$servername = "localhost";
$username = "exercise_1";
$password = "CphpmI1W5Xsd/C1x";
$dbname = "exercise_1";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all orders directly
$query = "SELECT * FROM orders";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order List</title>
    <style>
        * { 
            margin: 0; padding: 0; 
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
        }

        .custitle { 
            color: #ffffff; 
            background-color: #000000; 
            border-radius: 10px; 
            padding: 15px 30px; 
            font-size: 24px; 
            display: inline-block; 
            margin-bottom: 15px; 
        }

        .btn-create { 
            background-color: #000000; 
            color: white; 
            padding: 12px 24px; 
            text-decoration: none; 
            border-radius: 6px; 
            font-weight: bold; 
            display: inline-block; 
        }

        .btn-create:hover { 
            background-color: #333333; 
        }

        .order-table { 
            width: 100%; 
            border-collapse: 
            collapse; 
            background: #ffffff; 
            border-radius: 8px; 
            overflow: hidden; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.05); 
        }

        .order-table th,
         .order-table td { 
            padding: 18px 20px; 
            text-align: left; 
            border-bottom: 1px solid #eeeeee; 
        }

        .order-table th { 
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

    <h1 class="custitle">Order List</h1>

    <div class="button-container">
        <a href="createorder.php" class="btn-create">Add New Order</a>
    </div>
    
    <table class="order-table">
        <tr> 
            <th>Order ID</th>
            <th>Username</th>
            <th>Product</th>
            <th>Price(RM)</th>
            <th>Order Date</th>
            <th colspan="3">Action</th>
        </tr>

        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

                $id = isset($row['Orders_ID']) ? $row['Orders_ID'] : '';
                $user = isset($row['Username']) ? $row['Username'] : '';
                $prod = isset($row['Product']) ? $row['Product'] : '';
                $date = isset($row['Order_Date']) ? $row['Order_Date'] : '';

                // Get product unit price directly from products table
                $price_res = mysqli_query($conn, "SELECT Price FROM products WHERE Name = '$prod' LIMIT 1");
                $unit_price = 0.00;
                if ($price_res && $p_row = mysqli_fetch_assoc($price_res)) {
                    $unit_price = (float)$p_row['Price'];
                }

                $qty = isset($row['Quantity']) ? (int)$row['Quantity'] : 1;
                $calculated_price = $unit_price * $qty;
        ?>
            <tr>
                <td><?php echo $id; ?></td>
                <td><?php echo $user; ?></td>
                <td><?php echo $prod; ?></td>
                <td><?php echo number_format($calculated_price, 2); ?></td>
                <td><?php echo $date; ?></td>
                <td><button class="btn-action">Read</button></td>
               <td>
                <a href="editorder.php?OrderID=<?php echo $id; ?>">
                    <button class="btn-action">Edit</button>
                 </a>
            </td>
                <td>
                    <a href="#" onclick="myFunction('<?php echo $id; ?>')">
                        <button class="btn-action">Delete</button>
                    </a>
                </td>
            </tr>
        <?php
            }
        } 
        mysqli_close($conn);
        ?>
    </table>

</div>

<script>
function myFunction(OrderID) {
    if (confirm("Are you sure you want to delete " + OrderID + "?")) {
        window.location.href = "deleteorder.php?OrderID=" + OrderID;
    }
}
</script>

</body>
</html>