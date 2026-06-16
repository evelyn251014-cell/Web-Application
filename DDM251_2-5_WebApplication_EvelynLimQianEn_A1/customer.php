
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation bar</title>
</head>
  <style>
    *{
      font-size: 20px;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      background-color: #f4f6f9;
    }

    .sidebar-menu {
      width: 260px;
      height: 100vh;
      background-color: #000000; 
      position: fixed;
      top: 0;
      left: 0;
      padding-top: 20px;
      box-sizing: border-box;
      border-top-right-radius: 15px;
      border-bottom-right-radius: 15px;
    }

    .sidebar-menu a {
      display: block;
      color: #ffffff;
      text-decoration: none;
      padding: 15px 25px;
      font-size: 20px;
      transition: all 0.3s ease;
    }

    .sidebar-menu a:hover {
      background-color: #ffffff; 
      color: #000000;
      padding-left: 35px;
    }

    </style>
<body>

<div id="sidebar">
  <div class="sidebar-menu">
    <a href="">Dashboard</a>
    <a href="">Customers</a>
    <a href="">Products</a>
    <a href="">Orders</a>
    <a href="index.php">Log out</a>
  </div>

</div>
</body>
</html>