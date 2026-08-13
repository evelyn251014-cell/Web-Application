<?php
$servername = "localhost";
$username = "exercise_1";
$password = "CphpmI1W5Xsd/C1x";
$dbname = "exercise_1";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// 1. Get OrderID from URL parameter
$order_id = isset($_GET['OrderID']) ? $_GET['OrderID'] : '';

// 2. Fetch existing order details
$existing_order = null;
if (!empty($order_id)) {
    $order_id_clean = mysqli_real_escape_string($conn, $order_id);
    $fetch_query = "SELECT * FROM orders WHERE Orders_ID = '$order_id_clean' LIMIT 1";
    $fetch_res = mysqli_query($conn, $fetch_query);
    if ($fetch_res && mysqli_num_rows($fetch_res) > 0) {
        $existing_order = mysqli_fetch_assoc($fetch_res);
    }
}

// Fetch Customers and Products for dropdowns
$customer_result = mysqli_query($conn, "SELECT * FROM customers");
$product_result = mysqli_query($conn, "SELECT * FROM products");

$products_list = [];
if ($product_result && mysqli_num_rows($product_result) > 0) {
    while ($row = mysqli_fetch_assoc($product_result)) {
        $products_list[] = $row;
    }
}

// 3. Handle Form Submission & Update
$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST['Username'])) {
        $errors[] = "Please select your username.";
    }
    if (empty($_POST['Product'])) {
        $errors[] = "Please select your product.";
    }

    if (empty($errors)) {
        $user = mysqli_real_escape_string($conn, $_POST['Username']);
        $prod = mysqli_real_escape_string($conn, $_POST['Product']);
        $target_id = mysqli_real_escape_string($conn, $_POST['Orders_ID']);

        // UPDATE existing record without modifying Orders_ID
        $update_query = "UPDATE orders 
                        SET Username = '$user', Product = '$prod' 
                        WHERE Orders_ID = '$target_id'";
        
        if (mysqli_query($conn, $update_query)) {
            header("Location: order.php");
            exit();
        } else {
            $errors[] = "Error updating order: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
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

        .custitle {
            color: #ffffff;
            background-color: #000000;
            border-radius: 10px;
            padding: 15px 30px;
            font-size: 24px;
            display: inline-block;
            margin-bottom: 20px;
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

        .btn-green { background-color: #34a853; }


        .error-banner {
            background-color: #ea4335;
            color: white;
            padding: 12px 20px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .form-row {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .form-row label {
            color: #888888;
            font-weight: bold;
            width: 100px;
        }

        select, input[type="text"] {
            padding: 8px 12px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            font-size: 14px;
            outline: none;
        }

        input[readonly] {
            background-color: #e9ecef;
            cursor: not-allowed;
            color: #555555;
            font-weight: bold;
        }

        .dynamic-box {
            background-color: #f4f4f4;
            padding: 15px 20px;
            border-radius: 6px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .action-group {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<?php include('customer.php'); ?>

<div class="container">

    <h1 class="custitle">Edit Order</h1>

    <?php if (!empty($errors)): ?>
        <?php foreach ($errors as $err): ?>
            <div class="error-banner"><?php echo $err; ?></div>
        <?php endforeach; ?>
    <?php endif; ?>

    <form method="POST" action="editorder.php">
        
        <div class="form-row">
            <label>Order ID:</label>
            <input type="text" name="Orders_ID" value="<?php echo isset($existing_order['Orders_ID']) ? $existing_order['Orders_ID'] : $order_id; ?>" readonly />
        </div>

        <div class="form-row">
            <label>Username:</label>
            <select name="Username">
                <option value=""><-- Select Username --></option>
                <?php 
                if ($customer_result && mysqli_num_rows($customer_result) > 0) {
                    while ($c = mysqli_fetch_assoc($customer_result)) {
                        $selected = (isset($existing_order['Username']) && $existing_order['Username'] == $c['Username']) ? 'selected' : '';
                        echo "<option value='" . $c['Username'] . "' $selected>" . $c['Username'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div class="dynamic-box">
            <label style="color:#888; font-weight:bold;">Product:</label>
            <select name="Product">
                <option value=""><-- Select Product --></option>
                <?php foreach ($products_list as $p): ?>
                    <?php $selected = (isset($existing_order['Product']) && $existing_order['Product'] == $p['Name']) ? 'selected' : ''; ?>
                    <option value="<?php echo $p['Name']; ?>" <?php echo $selected; ?>><?php echo $p['Name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <br><br>

        <div class="action-group">
            <button type="submit" class="btn-action btn-green">UPDATE ORDER</button>
            <a href="order.php" class="btn-action">CANCEL</a>
        </div>

    </form>

</div>

</body>
</html>