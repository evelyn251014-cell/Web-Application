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
    alert('You have booked successfully!');
    window.location.href = 'booking.php';
    </script>";

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
     <a href="profile.php"><input type="submit" value="Profile"></a>
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

$query = "SELECT * FROM booking WHERE Event_Name IS NOT NULL AND Event_Name != ''";
$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_assoc($result)){

    if(empty($row['Event_Name'])){
        continue;
    }

    $event_id = $row['Event_ID'];

    // your slot code here
    $total = 3;

    $booking_query = "SELECT COUNT(*) AS booked 
                      FROM booking 
                      WHERE Event_ID='$event_id'";

    $booking_result = mysqli_query($conn, $booking_query);
    $data = mysqli_fetch_assoc($booking_result);

    $remain = $total - $data['booked'];

?>

<tr class="filter <?php echo $row['Event_Date']; ?>">

    <td><?php echo $row['Event_ID']; ?></td>

    <td><?php echo $row['Event_Name']; ?></td>

    <td>
        <?php echo $remain . "/" . $total; ?> Slot
    </td>

    <td>

    <?php if($remain > 0){ ?>

        <form method="post">


    <input type="hidden" 
    name="event_id"
    value="<?php echo $row['Event_ID']; ?>">


    <input type="submit" 
    name="book"
    value="Book">

        </form>

    <?php } else { ?>

        Full

    <?php } ?>

    </td>

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