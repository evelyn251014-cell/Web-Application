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


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <style>
        table {
            border-collapse: collapse;
        }

        table, 
        th,
        td {
            border: 1px solid black;
        }

        .error-message {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <button><a href="booklist.php">Back</a></button>
    <table width="600">

 <?php
     if (isset($_GET["error"]) && !empty($_GET["error"])) {
         echo "<p class='error-message'>" . htmlspecialchars($_GET["error"]) . "</p>";
     }
     ?>

    <tr>
        <th>ISBN</th>
        <th>Title</th>
        <th>Author</th>
        <th>Description</th>
        <th>Price</th>
    <tr>

    <tr>
        <form action="insertbook.php" method="POST">
            <td><input type=text name=ISBN></td>
            <td><input type=text name=title></td>
            <td><input type=text name=author></td>
            <td><textarea cols='50' input type=text name=description></textarea></td>
            <td><input type=text name=price></td>
            <td><input type=submit name="submit_btn" value=add></td>
        </form>
    <tr>
</body>

</html>