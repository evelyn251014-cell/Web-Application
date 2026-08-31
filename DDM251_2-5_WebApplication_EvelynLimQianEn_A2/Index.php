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

$base = isset($_POST["base"]) ? $_POST["base"] : "";
$milk = isset($_POST["milk"]) ? $_POST["milk"] : "";
$sweetness = isset($_POST["sweetness"]) ? $_POST["sweetness"] : "";
$temperature = isset($_POST["temp"]) ? $_POST["temp"] : ""; 
$topping = isset($_POST["topping"]) ? $_POST["topping"] : "";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Craft Your Coffee</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F4EFEB;
            background-image: radial-gradient(#D6C7B8 1px, transparent 1px);
            background-size: 24px 24px;
            padding: 40px 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #2C1810;
        }

        .coffee-card {
            width: 100%;
            max-width: 480px;
            background: #FFFFFF;
            border-radius: 20px;
            padding: 35px 30px;
            box-shadow: 0 12px 32px rgba(63, 29, 14, 0.08);
            border: 1px solid rgba(162, 102, 60, 0.12);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .title {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: #2C1810;
            margin-bottom: 6px;
        }

        .subtitle {
            font-size: 14px;
            color: #7A6055;
            font-weight: 500;
        }

        .step {
            margin-bottom: 20px;
        }

        .step-label {
            display: block;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 700;
            color: #8C5A3C;
            margin-bottom: 6px;
        }

        .select-wrapper {
            position: relative;
        }

        .select-wrapper::after {
            content: '▾';
            font-size: 14px;
            color: #8C5A3C;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
        }

        select {
            width: 100%;
            padding: 12px 40px 12px 14px;
            font-size: 15px;
            font-family: inherit;
            font-weight: 500;
            border: 1.5px solid #E5D8CC;
            border-radius: 10px;
            background-color: #FAF7F5;
            color: #2C1810;
            outline: none;
            appearance: none;
            -webkit-appearance: none;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        select:focus {
            border-color: #8C5A3C;
            background-color: #FFFFFF;
            box-shadow: 0 0 0 3px rgba(140, 90, 60, 0.12);
        }

        select:hover {
            border-color: #B8977E;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background-color: #5C321E;
            color: #FFFFFF;
            font-size: 16px;
            font-family: inherit;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 10px;
            box-shadow: 0 4px 12px rgba(92, 50, 30, 0.2);
            transition: all 0.2s ease;
        }

        .btn-submit:hover {
            background-color: #422314;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(92, 50, 30, 0.28);
        }

        .btn-submit:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>

<div class="coffee-card">
    <div class="header">
        <h1 class="title">Craft Your Perfect Coffee</h1>
        <p class="subtitle">Design your signature brew step-by-step</p>
</div>

    <form action="Finalcoffee.php" method="POST">
        <div class="step">
            <label class="step-label" for="base">1. Select Base</label>
            <div class="select-wrapper">
                <select name="base" id="base" required>
                    <option value="">Choose Coffee Base</option>
                    <option value="Espresso">Espresso</option>
                    <option value="Cold Brew">Cold Brew</option>
                    <option value="Matcha">Matcha</option>
                </select>
            </div>
        </div>

        <div class="step">
            <label class="step-label" for="milk">2. Select Milk</label>
            <div class="select-wrapper">
                <select name="milk" id="milk">
                    <option value="">Choose Milk Option</option>
                    <option value="Whole Milk">Whole Milk</option>
                    <option value="Oat Milk">Oat Milk</option>
                    <option value="No Milk">No Milk</option>
                </select>
            </div>
        </div>

        <div class="step">
            <label class="step-label" for="sweetness">3. Sweetness Level</label>
            <div class="select-wrapper">
                <select name="sweetness" id="sweetness">
                    <option value="">Choose Sweetness</option>
                    <option value="100%">100% (Standard)</option>
                    <option value="50%">50% (Less Sweet)</option>
                    <option value="No Sugar">Unsweetened</option>
                </select>
            </div>
        </div>

        <div class="step">
            <label class="step-label" for="temp">4. Temperature</label>
            <div class="select-wrapper">
                <select name="temp" id="temp">
                    <option value="">Choose Temperature</option>
                    <option value="Hot">Hot</option>
                    <option value="Cold">Iced</option>
                </select>
            </div>
        </div>

        <div class="step">
            <label class="step-label" for="topping">5. Add Toppings</label>
            <div class="select-wrapper">
                <select name="topping" id="topping">
                    <option value="">Choose Topping</option>
                    <option value="Caramel Drizzle">Caramel Drizzle</option>
                    <option value="Whipped Cream">Whipped Cream</option>
                    <option value="None">None</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn-submit">Find Coffee Shop</button>
    </form>
</div>

</body>
</html>