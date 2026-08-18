<?php
$servername = "localhost";
$username = "exercise_1";
$password = "CphpmI1W5Xsd/C1x";
$dbname = "exercise_1";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$res1 = $conn->query("SELECT COUNT(*) AS total FROM orders;");
$total_orders = ($res1) ? $res1->fetch_assoc()['total'] : 0;

$res2 = $conn->query("SELECT COUNT(*) AS total FROM products WHERE Name NOT IN (SELECT DISTINCT Product FROM orders)");
$unsold_products = ($res2) ? $res2->fetch_assoc()['total'] : 0;

$res3 = $conn->query("SELECT COUNT(*) AS total FROM customers WHERE Username NOT IN (SELECT DISTINCT Username FROM orders)");
$inactive_customers = ($res3) ? $res3->fetch_assoc()['total'] : 0;

$top3_query = "SELECT p.Name AS name, SUM(o.Quantity) AS total 
               FROM orders o 
               JOIN products p ON o.Product = p.Name 
               GROUP BY p.Name 
               ORDER BY total DESC 
               LIMIT 3";
               
$top3_result = $conn->query($top3_query);

$top3_products = [];
if ($top3_result && $top3_result->num_rows > 0) {
    while ($row = $top3_result->fetch_assoc()) {
        $top3_products[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      background-color: #f4f6f9;
      display: flex;
    }

    .sidebar-menu {
      width: 260px;
      height: 100vh;
      background-color: #000000;
      position: fixed;
      top: 0;
      left: 0;
      padding: 20px 15px;
    }

    .title {
      color: #ffffff;
      margin: 30px;
      font-size: 25px;
      text-decoration: underline;
    }

    .sidebar-menu a, .menu-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      text-decoration: none;
      color: #ffffff;
      padding: 15px 25px;
      font-size: 20px;
      cursor: pointer;
    }

    .sidebar-menu a:hover, .menu-item:hover {
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
      transition: max-height 0.2s ease-in-out;
      background-color: #000000;
    } 

    .sub-menu a {
      display: block;
      color: #b3b3b3;
      padding: 10px 0 10px 40px;
      font-size: 15px;
    }

    .sub-menu a:hover {
      color: #ffffff;
    } 

    .dashboard-table {
      width: calc(100% - 260px); 
      margin-left: 260px;        
      padding: 40px;             
    }

    .welcome-title {
      text-align: center;
      font-size: 50px;
      font-weight: bold;
      color: #000;
      padding: 50px;
    }

    .top-card {
      display: flex;
      gap: 3.5%;
      margin-bottom: 40px;
    }

    .card, .bottom-card {
      background: #ffffff;
      border-radius: 12px;
      padding: 20px 20px 20px 85px;
      position: relative;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .card {
      flex: 1;
      text-align: right;
      min-height: 90px;
    }

    .bottom-card {
      padding: 25px;
    }

    .card-icon {
      position: absolute;
      top: -15px;
      left: 20px;
      width: 55px;
      height: 55px;
      border-radius: 12px;
      background-color: #2c2c2c;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #ffffff;
      font-size: 20px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .card-title, .bottom-card-header {
      font-size: 13px;
      color: #888888;
      text-align: right;
      margin-bottom: 8px;
    }

    .card-value {
      font-size: 22px;
      font-weight: bold;
      color: #333333;
    }

    .bottom-products-table {
      width: 100%;
      border-collapse: collapse;
    }

    .bottom-products-table td {
      padding: 14px 10px;
      font-size: 15px;
      color: #777777;
      border-bottom: 1px solid #f0f0f0;
    }

    .bottom-products-table tr:last-child td {
      border-bottom: none;
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

  <div class="dashboard-table">
    <h1 class="welcome-title">Welcome</h1>

    <div class="top-card">
      <div class="card">
        <div class="card-icon icon-dark">
          <i class="fa-solid fa-couch"></i>
        </div>
        <div class="card-title">Total Orders</div>
        <div class="card-value"><?php echo $total_orders; ?></div>
      </div>

      <div class="card">
        <div class="card-icon icon-dark">
          <i class="fa-solid fa-box"></i>
        </div>
        <div class="card-title">Products Haven't Sold</div>
        <div class="card-value"><?php echo $unsold_products; ?></div>
      </div>

      <div class="card">
        <div class="card-icon icon-dark">
          <i class="fa-solid fa-user"></i>
        </div>
        <div class="card-title">Customers Haven't Purchased</div>
        <div class="card-value"><?php echo $inactive_customers; ?></div>
      </div>
    </div>

    <div class="bottom-card">
      <div class="card-icon icon-dark">
        <i class="fa-solid fa-couch"></i>
      </div>

      <div class="bottom-card-header">Top 3</div>

      <table class="bottom-products-table">
        <tbody>
          <?php if (!empty($top3_products)): ?>
            <?php foreach ($top3_products as $product): ?>
              <tr>
                <td style="width: 50%;"><?php echo htmlspecialchars($product['name']); ?></td>
                <td style="width: 50%; text-align: center;"><?php echo htmlspecialchars($product['total']); ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="2">No sales recorded.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>