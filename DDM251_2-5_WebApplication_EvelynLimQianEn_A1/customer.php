<?php
$servername = "localhost";
$username = "exercise_1";
$password = "CphpmI1W5Xsd/C1x";
$dbname = "exercise_1";
?>
   

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer</title>
</head>
  <style>
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
      padding-top: 20px 15px;
      box-sizing: border-box;
      box-sizing: border-box;
    }

    .sidebar-menu a, .menu-item {
      display: flex;
      justify-content: space-between;
      text-align: center;
      text-decoration: none;
      color: #ffffff;
      padding: 15px 25px;
      font-size: 20px;
      cursor: pointer;
    }

    .title a{
      color: #ffffff;
      margin:30px;
      font-size: 30px;
    }

    .sidebar-menu a:hover, .menu-item:hover {
      color: #ffffff;
      background-color: #5b5b62;
      border-radius: 10px;
}

    .toggle-input {
      display: none;
    }

    .toggle-input:checked ~ .sub-menu{
      color: #000000;
      max-height: 200px;
      opacity: 1;
    }
    
    .toggle-input:checked ~ .menu-item .arrow {
          transform: rotate(180deg);
        }

    .sub-menu {
      max-height: 0;
      overflow:hidden;
      transition:0.2s;
      background-color: #000000;
    } 

    .sub-menu a {
      display: block;
      text-decoration: none;
      color: #b3b3b3;
      padding: 10px 0;
      font-size: 15px;
      background-color: #000000;
    }

    .sub-menu a.sub-active {
      text-align: left;
      color: #ffffff; 
      padding-left: 40px;
    }

    .sub-menu a:hover {
      color: #ffffff;
    }
  
    </style>
    
<body>
  <div class="sidebar-menu">
    <h2 class= "title"><a href="">Dashboard</a></h2>

    <input type="checkbox" id="customer-toggle" class="toggle-input" checked>
    <label for="customer-toggle" class="menu-item actives">
      <span>Customers</span>
      <div class="arrow">▼</div>
    </label>

    <div class="sub-menu">
      <a href="createcus.php" class="sub-active">Create customer</a>
      <a href="customerlist.php" class="sub-active">Customer List</a>
    </div>

    <a href="">Products</a>
    <a href="">Orders</a>
    <a href="index.php">Log out</a>
  </div>


</body>
</html>