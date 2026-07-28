<?php
$conn = new mysqli("localhost", "evelynlim", "KOhWKf)4RH8MN.AO", "evelynlim");

$department = $_GET["department"] ?? "all";

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=employee.csv");

$output = fopen("php://output", "w");

fputcsv($output, array("ID", "Name", "Department"));

if ($department == "all") {
    $sql = "SELECT * FROM book1";
} else {
    $sql = "SELECT * FROM book1 WHERE Department='$department'";
}

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    fputcsv($output, array(
        $row["ID"],
        $row["Name"],
        $row["Department"]
    ));
}

fclose($output);
$conn->close();
exit();
?>