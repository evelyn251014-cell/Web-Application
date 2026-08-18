<?php
$servername = "localhost";
$username = "exercise_1";
$password = "CphpmI1W5Xsd/C1x";
$dbname = "exercise_1";

$conn = mysqli_connect($servername, $username, $password, $dbname);

$cus_id = isset($_GET['CusID']) ? $_GET['CusID'] : '';
$row = [];

if ($cus_id) {
    $res = mysqli_query($conn, "SELECT * FROM customers WHERE CusID = '$cus_id'");
    $row = mysqli_fetch_assoc($res);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['CusID'];
    $user = $_POST['Username'];
    $fname = $_POST['First_name'];
    $lname = $_POST['Last_name'];
    $email = $_POST['Email'];
    $pass = $_POST['Password'];
    $phone = $_POST['Phone'];

    $sql = "UPDATE customers SET Username='$user', First_name='$fname', Last_name='$lname', Email='$email', Password='$pass', Phone='$phone' WHERE CusID='$id'";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: customerlist.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
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
            background-color: #000; 
            position: fixed; 
            top: 0; 
            left: 0; 
            padding-top: 20px; 
            z-index: 100; 
        }

        .title { 
            color: #fff; 
            margin: 30px; 
            font-size: 25px; 
            text-decoration: underline; 
        }

        .sidebar-menu a, .menu-item { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            text-decoration: none; 
            color: #fff; 
            padding: 15px 25px; 
            font-size: 18px; 
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
            transition: max-height 0.3s ease; 
            background-color: #000; 
        }

        .sub-menu a { 
            display: block; 
            text-decoration: none; 
            color: #b3b3b3; 
            padding: 10px 0 10px 45px; 
            font-size: 15px; 
        }

        .sub-menu a:hover { 
            color: #fff; 
            background-color: #1a1a1a; 
        }

        .container { 
            width: calc(100% - 260px); 
            margin-left: 260px; 
            padding: 40px; 
        }

        .custitle { 
            color: #fff;
            background-color: #000; 
            border-radius: 10px;
            padding: 15px 30px; 
            font-size: 24px; 
            display: inline-block;
             margin-bottom: 25px; 
            }
        
        .form-col { 
            display: flex; 
            flex-direction: column; 
            margin-bottom: 15px; 
        }
        
        .form-col label { 
            font-weight: bold; 
            margin-bottom: 5px; 
            color: #333; 
        }
        
        .form-col input { 
            padding: 10px; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
            width: 320px; 
            font-size: 14px;
        }

        input[readonly] {
            background-color: #e9ecef;
            cursor: not-allowed;
        }

        .btn { background-color: #34a853; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: bold; }
        .btn-cancel { background-color: #000; text-decoration: none; display: inline-block; margin-left: 10px; }
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

  <!-- Form Container -->
  <div class="container">
    <h1 class="custitle">Edit Customer</h1>

    <form method="POST">
        <div class="form-col">
            <label>CusID:</label>
            <input type="text" name="CusID" value="<?php echo isset($row['CusID']) ? $row['CusID'] : $cus_id; ?>" readonly>
        </div>
        <div class="form-col">
            <label>Username:</label>
            <input type="text" name="Username" value="<?php echo isset($row['Username']) ? $row['Username'] : ''; ?>" required>
        </div>
        <div class="form-col">
            <label>First Name:</label>
            <input type="text" name="First_name" value="<?php echo isset($row['First_name']) ? $row['First_name'] : ''; ?>" required>
        </div>
        <div class="form-col">
            <label>Last Name:</label>
            <input type="text" name="Last_name" value="<?php echo isset($row['Last_name']) ? $row['Last_name'] : ''; ?>" required>
        </div>
        <div class="form-col">
            <label>Email:</label>
            <input type="email" name="Email" value="<?php echo isset($row['Email']) ? $row['Email'] : ''; ?>" required>
        </div>
        <div class="form-col">
            <label>Password:</label>
            <input type="password" name="Password" value="<?php echo isset($row['Password']) ? $row['Password'] : ''; ?>" required>
        </div>
        <div class="form-col">
            <label>Phone:</label>
            <input type="text" name="Phone" value="<?php echo isset($row['Phone']) ? $row['Phone'] : ''; ?>" required>
        </div>
        <div style="margin-top: 20px;">
            <button type="submit" class="btn">UPDATE</button>
            <a href="customerlist.php" class="btn btn-cancel">CANCEL</a>
        </div>
    </form>
  </div>

</body>
</html>