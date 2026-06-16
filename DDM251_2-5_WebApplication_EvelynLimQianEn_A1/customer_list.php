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

$sql = "SELECT * FROM customers";
// Execute the SQL query
$result = $conn->query($sql);

// Process the result set
if ($result->num_rows > 0) {
  // Output data of each row
  while($row = $result->fetch_assoc()) {
    echo "CusID: " . $row["CusID"]. " - Username: " . $row["Username"]. " First_name: " . $row["First_name"]. " Last_name: " . $row["Last_name"]. " Email: " . $row["email"].  " Password: " . $row["password"].  " Phone: " . $row["phone"]."<br>";
  }
} else {
  echo "0 results";
}



$conn->close();
?>