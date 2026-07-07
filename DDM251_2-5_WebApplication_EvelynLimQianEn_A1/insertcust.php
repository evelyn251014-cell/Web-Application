<?php
$servername = "localhost";
$username = "exercise_1";
$password = "CphpmI1W5Xsd/C1x";
$dbname = "exercise_1";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the "add" button was clicked
if (isset($_POST["submit_btn"])) {

  if (empty($_POST["CusID"]) || empty($_POST["Username"]) || empty($_POST["First_name"]) || empty($_POST["Last_name"]) || empty($_POST["Email"]) || empty($_POST["Password"]) || empty($_POST["Phone"])) {
        
        header("Location: createcus.php?error=Please fill in all fields. All data is required!");
        exit();

    } else if (strlen($_POST["Password"]) != 6) {
        
        header("Location: createcus.php?error=Password must be exactly 6 digits.");
        exit();

    } else {
        
        $insert = "INSERT INTO customers (CusID, Username, First_name, Last_name, Email, Password, Phone) 
                   VALUES ('" . $_POST["CusID"] . "', '" . $_POST["Username"] . "', '" . $_POST["First_name"] . "', '" . $_POST["Last_name"] . "', '" . $_POST["Email"] . "', '" . $_POST["Password"] . "', '" . $_POST["Phone"] . "')";  

        if (mysqli_query($conn, $insert)) {
            header("Location: customerlist.php");
            exit();
        } else {
            echo "Error creating record: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>