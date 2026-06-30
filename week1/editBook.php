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
$ISBN = $_GET["ISBN"];

$sql = "SELECT * FROM booklist WHERE ISBN='$ISBN'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
       <style>
        table {
            border-collapse: collapse;
        }

        table, 
        th,
        tr{
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <button><a href="booklist.php">Back</a></button>
    <button><a href="">Log_out</a></button>
    <table width="600">

      <tr>
        <th>ISBN</th>
        <th>Title</th>
        <th>Author</th>
        <th>Description</th>
        <th>Price</th>
</tr>

    
    <tr>
        <form action="updateeditBook.php" method="POST">
            <td><?php echo $row['ISBN']; ?><input type="hidden" name="ISBN" value="<?php echo $row['ISBN']; ?>"></td>
            <td><input type="text" name="title" value="<?php echo $row['title']; ?>"></td>
            <td><input type="text" name="author" value="<?php echo $row['author']; ?>"></td>
            <td><textarea cols='50' input type=text name=description value="<?php echo $row['description']; ?>"></textarea></td>
            <td><input type="text" name="price" value="<?php echo $row['price']; ?>"></td>
            <td><input type="submit" value="submit"></td>
        </form>
</tr>

</body>
</html>