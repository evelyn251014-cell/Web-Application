<?php
$servername = "localhost";
$username = "evelynlim";
$password = "KOhWKf)4RH8MN.AO";
$dbname = "evelynlim";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (empty($_POST["ISBN"]) || empty($_POST["title"]) || empty($_POST["author"]) || empty($_POST["description"]) || empty($_POST["price"])) {
    
    header("Location: addBook.php?error=Please fill in all fields.");


    }else if (strlen($_POST["ISBN"]) != 13 || !is_numeric($_POST["ISBN"])) {

     header("Location: addBook.php?error=ISBN must be exactly 13 digits.");
    }

    else if (!is_numeric($_POST["price"]) || $_POST["price"] < 0) {
      header("Location: addBook.php?error=Price must contain digits only.");


    } else {
    $ISBN = $_POST["ISBN"];
    $Title = $_POST["title"];
    $Author = $_POST["author"];
    $Description = $_POST["description"];
    $price = $_POST["price"];

    $sql = "INSERT INTO booklist (ISBN, title, author, description, price)
    VALUES ('$_POST[ISBN]' ,'$_POST[title]','$_POST[author]', '$_POST[description]', '$_POST[price]')";

    if ($conn->query($sql) === TRUE) {
      echo "New record created successfully";
    header("Location:booklist.php");
    }  else {
            echo "Error creating record: " . mysqli_error($conn);
        }
   }
$conn->close();
?>