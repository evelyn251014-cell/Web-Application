<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
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
    <button><a class="link href="profile.php>Back</a></button>
    <button><a class="link href=">Log_out</a></button>
    <table width="600">

    <tr>
        <th>Password</th>
        <th>Confirm Password</th>
        <th>Name</th>
        <th>Year Joined</th>
    <tr>

    <tr>
        <form action="text.php" method="POST">
            <td><input type=password name=password></td>
            <td><input type=password name=confirmpassword></td>
            <td><input type=text name=name></td>
            <td><input type=text name=yearjoin></td>
            <td><input type=submit value=Submit></td>
        </form>
    <tr>
</body>
</html>