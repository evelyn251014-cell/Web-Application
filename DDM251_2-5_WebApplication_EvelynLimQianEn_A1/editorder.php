<?php
$servername = "localhost";
$username = "exercise_1";
$password = "CphpmI1W5Xsd/C1x";
$dbname = "exercise_1";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$order_id = isset($_GET['OrderID']) ? $_GET['OrderID'] : '';

$existing_order = null;
if (!empty($order_id)) {
    $order_id_clean = mysqli_real_escape_string($conn, $order_id);
    $fetch_query = "SELECT * FROM orders WHERE Orders_ID = '$order_id_clean' LIMIT 1";
    $fetch_res = mysqli_query($conn, $fetch_query);
    if ($fetch_res && mysqli_num_rows($fetch_res) > 0) {
        $existing_order = mysqli_fetch_assoc($fetch_res);
    }
}

$customer_result = mysqli_query($conn, "SELECT * FROM customers");
$product_result = mysqli_query($conn, "SELECT * FROM products");

$products_list = [];
if ($product_result && mysqli_num_rows($product_result) > 0) {
    while ($row = mysqli_fetch_assoc($product_result)) {
        $products_list[] = $row;
    }
}

$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST['Username'])) {
        $errors[] = "Please select your username.";
    }
    if (empty($_POST['Product'])) {
        $errors[] = "Please select your product.";
    }
    if (empty($_POST['Quantity'])) {
        $errors[] = "Please select a quantity.";
    }

    if (empty($errors)) {
        $user = mysqli_real_escape_string($conn, $_POST['Username']);
        $prod = mysqli_real_escape_string($conn, $_POST['Product']);
        $qty = (int)$_POST['Quantity'];
        $target_id = mysqli_real_escape_string($conn, $_POST['Orders_ID']);

        $update_query = "UPDATE orders 
                        SET Username = '$user', Product = '$prod', Quantity = $qty 
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box; 
            font-family: Arial, sans-serif; 
        }

        body {
            background-color: #fcfbf9; 
            display: flex;
        }

        .sidebar-menu {
            width: 260px;
            height: 100vh;
            background-color: #000000;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
            z-index: 100;
        }

        .title {
            color: #ffffff;
            margin: 30px;
            font-size: 25px;
            text-decoration: underline;
        }

        .sidebar-menu a, 
        .menu-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-decoration: none;
            color: #ffffff;
            padding: 15px 25px;
            font-size: 18px;
            cursor: pointer;
        }

        .sidebar-menu a:hover, 
        .menu-item:hover {
            color: #ffffff;
            background-color: #5b5b62;
            border-radius: 10px;
        }

        .toggle-input {
            display: none;
        }

        .toggle-input:checked + .menu-item + .sub-menu {
            max-height: 200px;
        }

        .sub-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            background-color: #000000;
        } 

        .sub-menu a {
            display: block;
            text-decoration: none;
            color: #b3b3b3;
            padding: 10px 0 10px 45px;
            font-size: 15px;
            background-color: #000000;
        }

        .sub-menu a:hover {
            color: #ffffff;
            background-color: #1a1a1a;
        }

        .container {
            width: calc(100% - 260px);
            margin-left: 260px;
            padding: 40px;
        }

        .custitle {
            color: #ffffff;
            background-color: #000000;
            border-radius: 10px;
            padding: 15px 30px;
            font-size: 24px;
            display: inline-block;
            margin-bottom: 25px;
        }

        .btn-action {
            background-color: #000;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
        }

        .btn-green { 
            background-color: #34a853; 
        }

        .btn-green:hover {
            background-color: #2d9247;
        }

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
            color: #333333;
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

        .action-group {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

  <div class="sidebar-menu">
    <h2 class="title">Evelyn's Shop</h2>

    <a href="dashboard.php" class="menu-item">
      <span><i class="fa-solid fa-gauge"></i> Dashboard</span>
    </a>

    <input type="checkbox" id="customer-toggle" class="toggle-input">
    <label for="customer-toggle" class="menu-item">
      <span><i class="fa-solid fa-user"></i> Customers</span>
    </label>
    <div class="sub-menu">
      <a href="createcus.php">Create Customer</a>
      <a href="customerlist.php">Customer List</a>
    </div>

    <input type="checkbox" id="product-toggle" class="toggle-input">
    <label for="product-toggle" class="menu-item">
      <span><i class="fa-solid fa-box"></i> Products</span>
    </label>
    <div class="sub-menu">
      <a href="createproduct.php">Create Product</a>
      <a href="product.php">Product List</a>
    </div>

    <input type="checkbox" id="order-toggle" class="toggle-input">
    <label for="order-toggle" class="menu-item">
      <span><i class="fa-solid fa-cart-shopping"></i> Order</span>
    </label>
    <div class="sub-menu">
      <a href="createorder.php">Create Order</a>
      <a href="order.php">Order List</a>
    </div>

    <a href="index.php" class="menu-item">
      <span><i class="fa-solid fa-right-from-bracket"></i> Log out</span>
    </a>
  </div>

  <div class="container">

    <h1 class="custitle">Edit Order</h1>

    <?php if (!empty($errors)): ?>
        <?php foreach ($errors as $err): ?>
            <div class="error-banner"><?php echo htmlspecialchars($err); ?></div>
        <?php endforeach; ?>
    <?php endif; ?>

    <form method="POST" action="editorder.php">
        
        <div class="form-row">
            <label for="orders-id">Order ID:</label>
            <input type="text" id="orders-id" name="Orders_ID" value="<?php echo htmlspecialchars(isset($existing_order['Orders_ID']) ? $existing_order['Orders_ID'] : $order_id); ?>" readonly />
        </div>

        <div class="form-row">
            <label for="username">Username:</label>
            <select name="Username" id="username">
                <option value="">&lt;-- Select Username --&gt;</option>
                <?php 
                if ($customer_result && mysqli_num_rows($customer_result) > 0) {
                    while ($c = mysqli_fetch_assoc($customer_result)) {
                        $selected = (isset($existing_order['Username']) && $existing_order['Username'] == $c['Username']) ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($c['Username']) . "' $selected>" . htmlspecialchars($c['Username']) . "</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-row">
            <label for="product">Product:</label>
            <select name="Product" id="product">
                <option value="">&lt;-- Select Product --&gt;</option>
                <?php foreach ($products_list as $p): ?>
                    <?php $selected = (isset($existing_order['Product']) && $existing_order['Product'] == $p['Name']) ? 'selected' : ''; ?>
                    <option value="<?php echo htmlspecialchars($p['Name']); ?>" <?php echo $selected; ?>>
                        <?php echo htmlspecialchars($p['Name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-row">
            <label for="quantity">Quantity:</label>
            <select name="Quantity" id="quantity">
                <option value="">&lt;-- Select Quantity --&gt;</option>
                <?php for ($i = 1; $i <= 10; $i++): ?>
                    <?php $selected = (isset($existing_order['Quantity']) && (int)$existing_order['Quantity'] === $i) ? 'selected' : ''; ?>
                    <option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
        </div>

        <div class="action-group">
            <button type="submit" class="btn-action btn-green">UPDATE ORDER</button>
            <a href="order.php" class="btn-action">CANCEL</a>
        </div>

    </form>

  </div>

</body>
</html>