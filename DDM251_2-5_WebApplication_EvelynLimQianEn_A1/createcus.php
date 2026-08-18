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

        .sub-menu a.sub-active {
            text-align: left;
            color: #ffffff; 
            padding-left: 45px;
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
        
        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .form-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            overflow-x: auto;
        }

        .customer-table {
            width: 100%;
            border-spacing: 10px 0px;
            border-collapse: separate;
        }

        .customer-table th {
            text-align: left;
            padding: 15px 10px;
            color: #555555;
            font-size: 15px;
            font-weight: 600;
            border-bottom: 2px solid #f4f4f4;
        }

        .form-control {
            width: 100%;
            padding: 10px;
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

        .btn-add:hover {
            background-color: #333333;
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

    <h1 class="page-title">Create Customer</h1>

    <?php
    if (isset($_GET["error"]) && !empty($_GET["error"])) {
        echo "<p class='error-message'>" . htmlspecialchars($_GET["error"]) . "</p>";
    }
    ?>

    <div class="form-card">
        <form action="insertcust.php" method="POST">
            <table class="customer-table">
                <thead>
                    <tr> 
                        <th>CusID</th>
                        <th>Username</th>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="CusID" class="form-control" required></td>
                        <td><input type="text" name="Username" class="form-control" required></td>
                        <td><input type="text" name="First_name" class="form-control" required></td>
                        <td><input type="text" name="Last_name" class="form-control" required></td>
                        <td><input type="email" name="Email" class="form-control" required></td>
                        <td><input type="password" name="Password" class="form-control" required></td>
                        <td><input type="text" name="Phone" class="form-control" required></td>
                        <td><input type="submit" name="submit_btn" class="btn-add" value="Add"></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>

</div>

</body>
</html>