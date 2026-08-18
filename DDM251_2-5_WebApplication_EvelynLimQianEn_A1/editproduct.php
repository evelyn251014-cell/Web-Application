<?php
$servername = "localhost";
$username = "exercise_1";
$password = "CphpmI1W5Xsd/C1x";
$dbname = "exercise_1";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$product_id = isset($_GET['ProductID']) ? $_GET['ProductID'] : '';
$existing_product = null;

if (!empty($product_id)) {
    $product_id_clean = mysqli_real_escape_string($conn, $product_id);
    $fetch_query = "SELECT * FROM products WHERE ProductID = '$product_id_clean' LIMIT 1";
    $fetch_res = mysqli_query($conn, $fetch_query);
    if ($fetch_res && mysqli_num_rows($fetch_res) > 0) {
        $existing_product = mysqli_fetch_assoc($fetch_res);
    }
}

$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST['Name'])) {
        $errors[] = "Please enter product name.";
    }
    if (empty($_POST['Price'])) {
        $errors[] = "Please enter price.";
    }
    if (empty($_POST['Stock'])) {
        $errors[] = "Please enter stock amount.";
    }

    if (empty($errors)) {
        $target_id = mysqli_real_escape_string($conn, $_POST['ProductID']);
        $name = mysqli_real_escape_string($conn, $_POST['Name']);
        $price = (float)$_POST['Price'];
        $stock = (int)$_POST['Stock'];

        $update_query = "UPDATE products 
                        SET Name = '$name', Price = $price, Stock = $stock 
                        WHERE ProductID = '$target_id'";
        
        if (mysqli_query($conn, $update_query)) {
            header("Location: product.php");
            exit();
        } else {
            $errors[] = "Error updating product: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
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

        .form-col {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
        }

        .form-col label {
            color: #333333;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="number"] {
            padding: 10px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            font-size: 14px;
            outline: none;
            width: 320px;
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

    <h1 class="custitle">Edit Product</h1>

    <?php if (!empty($errors)): ?>
        <?php foreach ($errors as $err): ?>
            <div class="error-banner"><?php echo htmlspecialchars($err); ?></div>
        <?php endforeach; ?>
    <?php endif; ?>

    <form method="POST" action="editproduct.php">
        
        <div class="form-col">
            <label for="product-id">Product ID:</label>
            <input type="text" id="product-id" name="ProductID" value="<?php echo htmlspecialchars(isset($existing_product['ProductID']) ? $existing_product['ProductID'] : $product_id); ?>" readonly />
        </div>

        <div class="form-col">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="Name" value="<?php echo htmlspecialchars(isset($existing_product['Name']) ? $existing_product['Name'] : ''); ?>" required />
        </div>

        <div class="form-col">
            <label for="price">Price (RM):</label>
            <input type="number" step="0.01" id="price" name="Price" value="<?php echo htmlspecialchars(isset($existing_product['Price']) ? $existing_product['Price'] : ''); ?>" required />
        </div>

        <div class="form-col">
            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="Stock" value="<?php echo htmlspecialchars(isset($existing_product['Stock']) ? $existing_product['Stock'] : ''); ?>" required />
        </div>

        <div class="action-group">
            <button type="submit" class="btn-action btn-green">UPDATE PRODUCT</button>
            <a href="product.php" class="btn-action">CANCEL</a>
        </div>

    </form>

  </div>

</body>
</html>