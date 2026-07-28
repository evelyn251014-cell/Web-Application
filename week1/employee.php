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
    <title>Employee List</title>
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
</head>
<body>
<div class="filter_btn">
    <button class="btn active" onclick="filterSelection('all')">All</button>
    <button class="btn" onclick="filterSelection('HR')">HR</button>
    <button class="btn" onclick="filterSelection('IT')">IT</button>
    <button class="btn" onclick="filterSelection('Finance')">Finance</button>
    <button class="btn" onclick="downloadCSV()">Download CSV</button>
</div>
    <table width="1100">
        <tr>
            <th>ID</th>
            <th width="300">Name</th>
            <th>Department</th>
        <tr>
    <?php
    $query = "SELECT * FROM book1";

    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
    ?>
       <tr class="filter <?php echo $row['Department']; ?>">
            <td><?php echo $row['ID']; ?></td>
            <td><?php echo $row['Name']; ?></td>
            <td><?php echo $row['Department']; ?></td>
        </tr>
    <?php 
    }
    ?>
</body>

<script>
let currentDepartment ="all";

function filterSelection(department) {
    currentDepartment = department;

    let rows = document.getElementsByClassName("filter");
    let count = 1;

    for (let i = 0; i < rows.length; i++) {

        if (department == "all" || rows[i].classList.contains(department)) {
            rows[i].style.display = "";

            rows[i].cells[0].innerHTML = count;
            count++;

        } else {
            rows[i].style.display = "none";
        }
    }
}

function downloadCSV() {
    window.location.href = "download.php?department="+ currentDepartment;
}
</script>
</html>