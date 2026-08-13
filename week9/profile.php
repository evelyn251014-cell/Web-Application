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

$cus_id = $_SESSION['CusID'] ?? $_SESSION['cus_id'] ?? '';

$user_data = [];
$booking_result = false;

if (!empty($cus_id)) {
    $user_query = "SELECT Username, Email FROM customers WHERE CusID = '$cus_id'";
    $user_result = mysqli_query($conn, $user_query);
    $user_data = mysqli_fetch_assoc($user_result);
}
$booking_query = "SELECT b.Event_Name, b.Event_Date 
                 FROM user_bookings ub
                 JOIN booking b ON ub.Event_ID = b.Event_ID
                 WHERE ub.CusID = '$cus_id'";
$booking_result = mysqli_query($conn, $booking_query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
</head>
<body>

    <a href="booking.php"><button type="button">Back to Booking</button></a>

    <h2>My Profile</h2>
    <p><strong>Username:</strong> <?php echo htmlspecialchars($user_data['Username'] ?? ''); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user_data['Email'] ?? ''); ?></p>

    <hr>

    <h3>My Booked Events</h3>
    <?php if (mysqli_num_rows($booking_result) > 0) { ?>
        <ul>
            <?php while ($row = mysqli_fetch_assoc($booking_result)) { ?>
                <li>
                    <strong>Event Name:</strong> <?php echo htmlspecialchars($row['Event_Name']); ?><br>
                    <strong>Event Date:</strong> <?php echo htmlspecialchars($row['Event_Date']); ?>
                </li>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p>You haven't booked any events yet.</p>
    <?php } ?>

</body>
</html>