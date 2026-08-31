<?php
$servername = "localhost";
$dbusername = "coffee_shop";
$dbpassword = "1ew.Fibz@DynoYxL";
$dbname     = "coffee_shop";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$series = isset($_GET["series"]) ? trim($_GET["series"]) : "";
$drink  = isset($_GET["drink"]) ? trim($_GET["drink"]) : "your drink";

$series_clean = strtolower($series);

if ($series_clean === "coffee") {
    $keyword = "Coffee";
} elseif ($series_clean === "matcha") {
    $keyword = "Matcha";
} else {
    $keyword = "";
}

if ($keyword !== "") {

    $stmt = $conn->prepare(
        "SELECT *
         FROM shop
         WHERE Specialty_base = ?
         ORDER BY Shop_id ASC"
    );

    $stmt->bind_param("s", $keyword);
    $stmt->execute();

    $result = $stmt->get_result();

} else {
    $result = false;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafe</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
          rel="stylesheet">
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

        .shop-card {
            width: 100%;
            max-width: 520px;
            background: #FFFFFF;
            border-radius: 20px;
            padding: 35px 30px;
            box-shadow: 0 12px 32px rgba(63, 29, 14, 0.08);
            border: 1px solid rgba(162, 102, 60, 0.12);
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid #E5D8CC;
        }

        .section-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            color: #8C5A3C;
            margin-bottom: 6px;
        }

        .drink-name {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 700;
            color: #2C1810;
            line-height: 1.3;
        }

        .shop-box {
            background: #FAF7F5;
            padding: 18px 20px;
            margin-bottom: 20px;
            border-radius: 12px;
            border: 1px solid #E5D8CC;
            border-left: 4px solid #8C5A3C;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .shop-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(63, 29, 14, 0.06);
        }

        .shop-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 12px;
            cursor: pointer;
            transition: opacity 0.2s ease;
        }

        .shop-img:hover {
            opacity: 0.9;
        }

        .shop-name {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
            color: #2C1810;
            margin-bottom: 6px;
        }

        .shop-desc {
            font-size: 13.5px;
            color: #7A6055;
            margin-bottom: 12px;
            font-style: italic;
            line-height: 1.4;
        }

        .shop-detail {
            font-size: 14px;
            color: #422314;
            margin-bottom: 6px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
            line-height: 1.4;
        }

        .shop-detail:last-child {
            margin-bottom: 0;
        }

        .btn-submit {
            display: block;
            width: 100%;
            padding: 14px;
            background-color: #5C321E;
            color: #FFFFFF;
            font-size: 15px;
            font-family: inherit;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 15px;
            box-shadow: 0 4px 12px rgba(92, 50, 30, 0.2);
            transition: all 0.2s ease;
        }

        a {
            text-decoration: none;
        }

        .btn-submit:hover {
            background-color: #422314;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(92, 50, 30, 0.28);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            padding-top: 50px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.85);
        }

        .modal-content {
            margin: auto;
            display: block;
            max-width: 90%;
            max-height: 80vh;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.5);
        }

        .close {
            position: absolute;
            top: 20px;
            right: 35px;
            color: #FFF;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }

        .no-shop {
            text-align: center;
            padding: 25px 10px;
            color: #7A6055;
        }
    </style>
</head>

<body>

<div class="shop-card">
    <div class="header">
        <p class="section-label">
            Choose where you want to enjoy your custom drink
        </p>
        <h1 class="drink-name">
            Your
            <?php echo htmlspecialchars($drink); ?>
            is available at these cafes.
        </h1>
    </div>

    <?php

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $imageName = !empty($row["Shop_Img"])
                ? $row["Shop_Img"]
                : "default_shop.jpg";

    ?>

        <div class="shop-box">
            <img src="img/<?php echo htmlspecialchars($imageName); ?>"
                 alt="<?php echo htmlspecialchars($row["Name"]); ?>"
                 class="shop-img"
                 onclick="openModal(this.src)">


            <h2 class="shop-name">
                <?php
                echo htmlspecialchars($row["Name"]);
                ?>
            </h2>


            <p class="shop-desc">
                <?php
                echo htmlspecialchars($row["Description"]);
                ?>
            </p>

            <p class="shop-detail">
                <b>Opening Hours:</b>
                <?php
                echo htmlspecialchars($row["Opening Hours"]);
                ?>
            </p>


            <p class="shop-detail">
                <b>Address:</b>
                <?php
                echo htmlspecialchars($row["Address"]);
                ?>
            </p>


            <p class="shop-detail">
                <b>Phone:</b>
                <?php
                echo htmlspecialchars($row["Phone"]);
                ?>
            </p>

            <a href="Feedback.php?shop_id=<?php echo urlencode($row["Shop_id"]); ?>&drink=<?php echo urlencode($drink); ?>">

                <button type="button" class="btn-submit">

                    View Feedback

                </button>

            </a>

        </div>

    <?php

        }

    } else {

    ?>

        <div class="no-shop">

            <p>
                Sorry, there are no cafes available for this drink.
            </p>

        </div>

    <?php

    }

    ?>


    <a href="index.php">

        <button type="button" class="btn-submit">

            Go back to make a new drink

        </button>

    </a>
</div>

<div id="imageModal"
     class="modal"
     onclick="closeModal()">

    <span class="close">&times;</span>

    <img class="modal-content"
         id="imgFull">
</div>


<script>

    function openModal(src) {

        document.getElementById('imageModal').style.display = 'block';

        document.getElementById('imgFull').src = src;
    }

    function closeModal() {

        document.getElementById('imageModal').style.display = 'none';
    }

</script>

</body>
</html>

<?php

if (isset($stmt)) {
    $stmt->close();
}

$conn->close();

?>