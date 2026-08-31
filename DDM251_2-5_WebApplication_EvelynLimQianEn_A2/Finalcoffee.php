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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $base = $_POST["base"] ?? "";
    $milk = $_POST["milk"] ?? "";
    $sweetness = $_POST["sweetness"] ?? "";
    $temperature = $_POST["temp"] ?? "";
    $topping = $_POST["topping"] ?? "";
} else {
    $base = "";
    $milk = "";
    $sweetness = "";
    $temperature = "";
    $topping = "";
}

$drink = "";
$series = "";

if ($base == "Matcha" && $milk == "Oat Milk" && $temperature == "Cold") {
    $drink = "Iced Oat Matcha Latte";
    $series = "Matcha";

} else if ($base == "Matcha" && ($milk == "Whole Milk" || $milk == "Fresh Milk") && $temperature == "Cold") {

    $drink = "Iced Matcha Latte";
    $series = "Matcha";

} else if ($base == "Matcha" && ($milk == "Whole Milk" || $milk == "Fresh Milk" || $milk == "Oat Milk") && $temperature == "Hot") {

    $drink = "Hot Matcha Latte";
    $series = "Matcha";

} else if ($base == "Matcha" && $milk == "No Milk") {

    $drink = "Pure Matcha Tea";
    $series = "Matcha";
}

else if($base == "Espresso" && ($milk == "Whole Milk" || $milk == "Fresh Milk") && $temperature == "Cold") {

    $drink = "Iced Latte";
    $series = "Coffee";

} else if ($base == "Espresso" && $milk == "Oat Milk" && $temperature == "Cold") {

    $drink = "Iced Oat Latte";
    $series = "Coffee";

} else if ($base == "Espresso" && ($milk == "Whole Milk" || $milk == "Fresh Milk") && $temperature == "Hot" && $topping == "Whipped Cream") {

    $drink = "Cappuccino";
    $series = "Coffee";

} else if ($base == "Espresso" && ($milk == "Whole Milk" || $milk == "Fresh Milk") && $temperature == "Hot") {

    $drink = "Latte";
    $series = "Coffee";

} else if ($base == "Espresso" && $milk == "No Milk") {

    $drink = "Americano";
    $series = "Coffee";


} else {

    $drink = "Custom Coffee";
    $series = "Specialty";

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Custom Coffee Order</title>
    
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
            text-align: center;
        }

        .title {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: #2C1810;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .subtitle {
            font-size: 14px;
            color: #7A6055;
            font-weight: 500;
            margin-bottom: 24px;
        }

        .drink-badge {
            background-color: #FAF7F5;
            border: 1.5px solid #E5D8CC;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .drink-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            color: #8C5A3C;
            margin-bottom: 6px;
        }

        .drink {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            color: #5C321E;
        }

        .order-details {
            background: #FFFFFF;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 25px;
            text-align: left;
            border: 1px dashed #E5D8CC;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            font-size: 14px;
            border-bottom: 1px solid #FAF7F5;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #7A6055;
            font-weight: 500;
        }

        .detail-value {
            color: #2C1810;
            font-weight: 600;
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
            box-shadow: 0 4px 12px rgba(92, 50, 30, 0.2);
            transition: all 0.2s ease;
            text-decoration: none;
            display: block;
        }

        .btn-submit:hover {
            background-color: #422314;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(92, 50, 30, 0.28);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        a {
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="coffee-card">
    <div class="title">Your Custom Order</div>
    <p class="subtitle">Here is your crafted drink match</p>

    <div class="drink-badge">
        <div class="drink-label">Matched Coffee</div>
        <div class="drink"><?php echo htmlspecialchars($drink); ?></div>
    </div>

    <?php if (!empty($base)): ?>
    <div class="order-details">
        <div class="detail-row">
            <span class="detail-label">Base:</span>
            <span class="detail-value"><?php echo htmlspecialchars($base); ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Milk:</span>
            <span class="detail-value"><?php echo htmlspecialchars($milk ?: 'None'); ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Sweetness:</span>
            <span class="detail-value"><?php echo htmlspecialchars($sweetness ?: 'Standard'); ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Temperature:</span>
            <span class="detail-value"><?php echo htmlspecialchars($temperature ?: 'Hot'); ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Topping:</span>
            <span class="detail-value"><?php echo htmlspecialchars($topping ?: 'None'); ?></span>
        </div>
    </div>
    <?php endif; ?>

    <a href="Shop.php?series=<?php echo urlencode($series); ?>&drink=<?php echo urlencode($drink); ?>">

    <button type="button" class="btn-submit">
        Choose Cafe
    </button>

</a>
</div>

</body>
</html>