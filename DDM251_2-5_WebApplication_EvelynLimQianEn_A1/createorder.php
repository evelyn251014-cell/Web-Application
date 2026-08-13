<?php
$servername = "localhost";
$username = "exercise_1";
$password = "CphpmI1W5Xsd/C1x";
$dbname = "exercise_1";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch Customers and Products
$customer_result = mysqli_query($conn, "SELECT * FROM customers");
$product_result = mysqli_query($conn, "SELECT * FROM products");

$products_list = [];
if ($product_result && mysqli_num_rows($product_result) > 0) {
    while ($row = mysqli_fetch_assoc($product_result)) {
        $products_list[] = $row;
    }
}

// Handle Form Submission & Validation
$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST['Username'])) {
        $errors[] = "please selected your username.";
    }

    if (isset($_POST['Product'])) {
        foreach ($_POST['Product'] as $index => $prod) {
            $qty = $_POST['Quantity'][$index] ?? '';
            if (empty($prod)) {
                $errors[] = "please selected your product.";
            }
            if (empty($qty)) {
                $errors[] = "please selected your quantity.";
            }
        }
    }

  // Save to Database
    if (empty($errors)) {
        $user = mysqli_real_escape_string($conn, $_POST['Username']);
        $order_date = date("Y-m-d H:i:s");

        foreach ($_POST['Product'] as $index => $prod_name) {
            $prod_clean = mysqli_real_escape_string($conn, $prod_name);
            
            // Query without Quantity column
            $query = "INSERT INTO orders (Username, Product, Order_Date) 
                      VALUES ('$user', '$prod_clean', '$order_date')";
            mysqli_query($conn, $query);
        }

        header("Location: order.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
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
        }

        select {
            padding: 8px 12px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            font-size: 14px;
            outline: none;
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

    <h1 class="custitle">Create Order</h1>

    <!-- Display Validation Errors -->
    <?php if (!empty($errors)): ?>
        <?php foreach ($errors as $err): ?>
            <div class="error-banner"><?php echo $err; ?></div>
        <?php endforeach; ?>
    <?php endif; ?>

    <form method="POST" action="createorder.php">
        
        <!-- Customer Dropdown -->
        <div class="form-row">
            <label>Username:</label>
            <select name="Username">
                <option value=""><-- Select Username --></option>
                <?php 
                if ($customer_result && mysqli_num_rows($customer_result) > 0) {
                    while ($c = mysqli_fetch_assoc($customer_result)) {
                        echo "<option value='" . $c['Username'] . "'>" . $c['Username'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>

        <!-- Dynamic Product Section -->
        <div id="product-container">
            <div class="dynamic-box">
                <label>Product:</label>
                <select name="Product[]">
                    <option value=""><-- Select Product --></option>
                    <?php foreach ($products_list as $p): ?>
                        <option value="<?php echo $p['Name']; ?>"><?php echo $p['Name']; ?></option>
                    <?php endforeach; ?>
                </select>

                <label>Quantity:</label>
                <select name="Quantity[]">
                    <option value=""><-- Select Quantity --></option>
                    <?php for ($i = 1; $i <= 10; $i++): ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>

        <!-- Row Control Buttons -->
        <div class="action-group">
            <button type="button" class="btn-action" onclick="addRow()">ADD</button>
            <button type="button" class="btn-action" onclick="removeRow()">DELETE PRODUCT</button>
        </div>

        <br><br>

        <!-- Form Buttons -->
        <div class="action-group">
            <button type="submit" class="btn-action btn-green">SUBMIT</button>
            <a href="order.php" class="btn-action">BACK TO ORDER LIST</a>
        </div>

    </form>

</div>

<script>
function addRow() {
    let container = document.getElementById("product-container");
    let firstBox = container.children[0];
    let newBox = firstBox.cloneNode(true);

    let selects = newBox.getElementsByTagName("select");
    selects[0].selectedIndex = 0;
    selects[1].selectedIndex = 0;

    container.appendChild(newBox);
}

function removeRow() {
    let container = document.getElementById("product-container");
    if (container.children.length > 1) {
        container.removeChild(container.lastElementChild);
    } else {
        alert("At least one product entry is required!");
    }
}
</script>

</body>
</html>