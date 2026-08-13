<?php
$servername = "localhost";
$dbusername = "coffee_shop";
$dbpassword = "1ew.Fibz@DynoYxL";
$dbname = "coffee_shop";

$message = "";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index page</title>

   <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-size: 18px;
        }

        body {
            background-color: #E6E2D7;
            padding: 20px 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #3F1D0E;
        }

        .coffee-card {
            width: 100%;
            max-width: 450px;
            background: #E4CDB0;
            border-radius: 12px;
            padding: 25px 20px;
            box-shadow: 0 4px 15px rgba(63, 29, 14, 0.15);
        }

        .title {
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #3F1D0E; 
        }

        .subtitle {
             text-align: center;
            font-size: 16px;
            color: #3F1D0E;
            margin-bottom: 25px;
            opacity: 0.85;
        }

        .step {
            margin-bottom: 18px;
            border-bottom: 1px solid rgba(162, 102, 60, 0.3);
            padding-bottom: 15px;
        }

        .step-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #3F1D0E;
        }

        select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1.5px solid #A2663C; 
            border-radius: 6px;
            background-color: #FFFFFF;
            color: #3F1D0E;
            outline: none;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background-color: #A2663C;
            color: #ffffff;
            font-size: 18px;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.3s ease;
        }

    </style>
</head>
<body>

<div class="coffee-card">
        
    <h1 class="title"> Craft Your Perfect Coffee</h1>
    <p class="subtitle">Design your own signature coffee!</p>

    <form method="POST">
        <div class="step">
            <div class="step-title">1. Choose Your Coffee Base</div>
            <select name="Coffee Base" required>
            <option value="" disabled selected>Select a base</option>
            <option value="Espresso" >Espresso</option>
            <option value="Cold Brew" >Cold Brew</option>
            <option value="Americano" >Americano</option>
            <option value="Matcha" >Matcha</option>
            </select>
        </div>

        <div class="step">
            <div class="step-title">2. Choose Your Milk</div>
            <select name="Milk" required>
            <option value="" disabled selected>Select Milk</option>
            <option value="Whole Milk" >Whole Milk</option>
            <option value="Oat Milk" >Oat Milk</option>
            <option value="Almond Milk" >Almond Milk</option>
            <option value="No Milk" >No Milk</option>
            </select>
        </div>

        <div class="step">
            <div class="step-title">3. Choose Your Sweetness</div>
            <select name="Sweetness" required>
            <option value="" disabled selected>Select Sweetness</option>
            <option value="100% (Normal sugar)" >100% (Normal sugar)</option>
            <option value= "50% (Half sugar)"> 50% (Half sugar) </option>
            <option value="25% (Less sugar)" >25% (Less sugar)</option>
            <option value="No Sugar" >No Sugar</option>
            </select>
        </div>

        <div class="step">
            <div class="step-title">4. Choose Your Temperature</div>
            <select name="Temperature" required>
            <option value="" disabled selected>Select Temperature</option>
            <option value="Hot" >Hot</option>
            <option value= "Cold"> Cold </option>
            </select>
        </div>

        <div class="step">
            <div class="step-title">5. Choose Your Topping</div>
            <select name="Topping" required>
            <option value="" disabled selected>Select Topping</option>
            <option value="Caramel Drizzle" >Caramel Drizzle</option>
            <option value= "Whipped Cream"> Whipped Cream </option>
            <option value="Cocoa Powder" >Cocoa Powder</option>
            <option value="None" >None</option>
            </select>
        </div>

        <input type="submit" name="build_drink" 
        class="btn-submit" value="Complete Your Drink">

    </forms>
</div>
        
        
    
</body>
</html>