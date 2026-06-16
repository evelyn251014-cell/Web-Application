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
    <title>Document</title>
</head>
<body>

<style>
    table {
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }
</style>

<table width="800">
     <tr> 
         <th>Name</th>
          <th>Email</th> 
         <th>Yearjoin</th>   
     </tr>

    <?php 
    $sql = "SELECT * FROM student";
    $result = $conn->query($sql);

    while($row = $result->fetch_assoc()) {
    ?> 
        <tr> 
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['yearjoin']; ?></td>
            <td><button>Edit</button></td>
        </tr>
    <?php
    }   

    mysqli_close($conn);
    ?>
    <a href=""><input type="submit" value="Back"></a>

</body>
</html>