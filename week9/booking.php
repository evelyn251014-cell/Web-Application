<?php
session_start();

$servername = "localhost";
$username = "event_booking";
$password = "KOhWKf)4RH8MN.AO";
$dbname = "event_booking";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_POST['book'])) {
    $event_id = $_POST['event_id'];
    $cus_id = $_SESSION['CusID'] ?? $_SESSION['cus_id'];

    // 1. 增加已訂人數
    $update_sql = "UPDATE booking SET Booked_count = Booked_count + 1 WHERE Event_ID = '$event_id'";
    mysqli_query($conn, $update_sql);

    // 2. 把這個 Customer 的預訂記錄寫入 user_bookings
    $insert_sql = "INSERT INTO user_bookings (CusID, Event_ID) VALUES ('$cus_id', '$event_id')";
    mysqli_query($conn, $insert_sql);

    echo "<script>alert('Booked successfully!'); window.location.href='profile.php';</script>";
    exit();

    // Refresh page
    echo "<script>
        alert('Booked successfully!');
        window.location.href = 'profile.php';
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
        table { border-collapse: collapse; }
        table, th, td { border: 1px solid black; padding: 8px; }
    </style>
</head>
<body>

    <a href="profile.php"><button type="button">Profile</button></a>

    <div>
        <h1>Please select your date</h1>
        <div class="filter_btn">
            <button class="btn_active" onclick="filterSelection('all')">All</button>
            <button class="btn" onclick="filterSelection('2026-09-25')">2026-09-25</button>
            <button class="btn" onclick="filterSelection('2026-09-27')">2026-09-27</button>
            <button class="btn" onclick="filterSelection('2026-09-30')">2026-09-30</button>
        </div>
    </div>

    <br>

    <table width="1100">
        <tr>
            <th>Event_ID</th>
            <th>Event_Name</th>
            <th>Slot</th>
            <th>Action</th>
        </tr>

    <?php
    // Fetch all events to display on the page
    $query = "SELECT * FROM booking";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        // Calculate remaining slots
        $remaining = $row['Max_capacity'] - $row['Booked_count'];
    ?>

        <tr class="filter <?php echo $row['Event_Date']; ?>">
            <td><?php echo $row['Event_ID']; ?></td>
            <td><?php echo $row['Event_Name']; ?></td>
            
            <!-- Display slots as "2/3" -->
            <td><?php echo $remaining . "/" . $row['Max_capacity']; ?></td>

            <td>
                <?php if ($remaining > 0) { ?>
                    <!-- If slots available, show Book button -->
                    <form method="post">
                        <input type="hidden" name="event_id" value="<?php echo $row['Event_ID']; ?>">
                        <input type="submit" name="book" value="Book">
                    </form>
                <?php } else { ?>
                    <!-- If no slots left, display FULL -->
                    <strong>FULL</strong>
                <?php } ?>
            </td>
        </tr>

    <?php
    }
    ?>
    </table>

<script>
function filterSelection(Event_Date) {
    let rows = document.getElementsByClassName("filter");
    for (let i = 0; i < rows.length; i++) {
        if (Event_Date == "all" || rows[i].classList.contains(Event_Date)) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}
</script>

</body> 
</html>