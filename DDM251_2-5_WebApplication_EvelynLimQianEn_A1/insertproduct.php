<?php
$servername = "localhost";
$username = "exercise_1";
$password = "CphpmI1W5Xsd/C1x";
$dbname = "exercise_1";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST["submit_btn"])) {

    // 1. NO EMPTY ALLOWED: Strict string check so '0' works but completely blank fails
    if (
        !isset($_POST["ProductID"]) || $_POST["ProductID"] === "" ||
        !isset($_POST["Name"])      || $_POST["Name"] === "" ||
        !isset($_POST["Price"])     || $_POST["Price"] === "" ||
        !isset($_POST["Stock"])     || $_POST["Stock"] === ""
    ) {
        header("Location: createproduct.php?error=Please fill in all fields.");
        exit();
    }
    
    else if (!is_numeric($_POST["Price"]) || $_POST["Price"] < 0) {
        header("Location: createproduct.php?error=Price must contain digits only.");
        exit();
    }
    
       else {
        $productID = $_POST["ProductID"];
        $name = $_POST["Name"];
        $price = $_POST["Price"];
        $stock = $_POST["Stock"];

        $insert = "INSERT INTO products (ProductID, Name, Price, Stock)
                   VALUES ('$productID', '$name', '$price', '$stock')";

        if (mysqli_query($conn, $insert)) {
            header("Location: product.php");
            exit();
        } else {
            echo "Error creating record: " . mysqli_error($conn);
        }
    }
}
mysqli_close($conn);
?>