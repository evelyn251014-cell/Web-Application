<?php
$servername = "localhost";
$username = "exercise_1";
$password = "CphpmI1W5Xsd/C1x";
$dbname = "exercise_1";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
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

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .custitle {
            color: #ffffff;
            background-color: #000000;
            border-radius: 10px;
            padding: 12px 25px;
            font-size: 24px;
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

        .product-table {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .product-table th, 
        .product-table td { 
            padding: 18px 20px; 
            text-align: left; 
            border-bottom: 1px solid #eeeeee;
        }

        .product-table th {
            background-color: #f4f4f4;
            font-weight: bold;
            color: #333333;
        }

        .btn-action {
            background-color: #000000;
            color: white;
            border: none;
            padding: 6px 14px;
            border-radius: 4px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            transition: background 0.2s;
        }

        .btn-action:hover {
            background-color: #333333;
        }

        .btn-red {
            background-color: #ea4335;
        }

        .btn-red:hover {
            background-color: #c53929;
        }

        .action-cell {
            display: flex;
            gap: 10px;
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
    <div class="header-section">
        <h1 class="custitle">Product List</h1>
        <a href="createproduct.php" class="btn-create">Add New Product</a>
    </div>
    
    <table class="product-table">
        <thead>
            <tr> 
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Price (RM)</th>
                <th>Stock</th>

            </tr>
        </thead>
        <tbody>
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $product_id = isset($row['ProductID']) ? $row['ProductID'] : '';
                $price = isset($row['Price']) ? (float)$row['Price'] : 0.00;
        ?>
            <tr>
                <td><?php echo htmlspecialchars($product_id); ?></td>
                <td><?php echo htmlspecialchars($row['Name']); ?></td>
                <td><?php echo number_format($price, 2); ?></td> 
                <td><?php echo htmlspecialchars($row['Stock']); ?></td>
                <td>
                    <div class="action-cell">
                        <a href="editproduct.php?ProductID=<?php echo urlencode($product_id); ?>" class="btn-action">Edit</a>
                        <a href="deleteproduct.php?ProductID=<?php echo urlencode($product_id); ?>" class="btn-action btn-red" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                    </div>
                </td>
            </tr>
        <?php
            }
        } 
        mysqli_close($conn);
        ?>
        </tbody>
    </table>
  </div>

</body>
</html>