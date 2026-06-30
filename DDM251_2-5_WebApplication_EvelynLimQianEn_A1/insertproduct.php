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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ProductID"])) {

    $ProductID = $_POST["ProductID"];
    $Name      = $_POST["Name"];
    $Price     = $_POST["Price"];
    $Stock     = $_POST["Stock"];

    $sql = "INSERT INTO products (ProductID, Name, Price, Stock)
            VALUES ('$ProductID', '$Name', '$Price', '$Stock')";

    if ($conn->query($sql) === TRUE) {
        header("Location: product.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>