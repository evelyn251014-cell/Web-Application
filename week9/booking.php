<?php

$servername = "localhost";
$username = "event_booking";
$password = "KOhWKf)4RH8MN.AO";
$dbname = "event_booking";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['book'])){

    $event_id = $_POST['event_id'];

    // Insert booking
    mysqli_query($conn, "INSERT INTO booking(Event_ID) VALUES('$event_id')");

    echo "<script>
    alert('Booking Successful!')'
    </script>";
    header("Location:booking.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>
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
     <a href=""><input type="submit" value="Profile"></a>
    <div>
        <h1>Please select your date</h1>
        <div class="filter_btn">
            <button class="btn_active" onclick="filterSelection('all')">All<button>
            <button class="btn" onclick="filterSelection('2026-09-25')">2026-09-25<button>
            <button class="btn" onclick="filterSelection('2026-09-27')">2026-09-27<button>
            <button class="btn" onclick="filterSelection('2026-09-30')">2026-09-30<button>
        </div>
    </div>

    <table width="1100">
        <tr>
            <th>Event_ID</th>
            <th>Event_Name</th>
            <th>Slot</th>
        </tr>

        
    <?php
    
    $query = "SELECT * FROM booking";
    $result = mysqli_query($conn, $query);


    $remain = $total - $data['booked'];
    while($row = mysqli_fetch_assoc($result)){
    ?>
        <tr class="filter <?php echo $row['Event_Date']; ?>">
            <td><?php echo $row['Event_ID']; ?></td>
            <td><?php echo $row['Event_Name']; ?></td>
            <td><button>3/3 Slot</button></td>
        </tr>
    <?php
    }
    ?>
</body> 

<script>
let currentDepartment ="all";

function filterSelection(Event_Date) {
    let rows = document.getElementsByClassName("filter");
    let count = 1;

    for (let i = 0; i < rows.length; i++) {

        if (Event_Date == "all" || rows[i].classList.contains(Event_Date)) {
            rows[i].style.display = "";

         } else {
            rows[i].style.display = "none";
        }
    }
}
</script>
</html>