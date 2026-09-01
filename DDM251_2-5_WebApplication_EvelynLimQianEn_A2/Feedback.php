<?php
session_start();

$conn = new mysqli("localhost", "coffee_shop", "1ew.Fibz@DynoYxL", "coffee_shop");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: login.php");
    exit();
}

$shop_id = intval($_GET['shop_id'] ?? 0);
$drink   = $_GET['drink'] ?? 'your drink';
$message = "";

// Get current logged-in username and their User_id from DB
$logged_user = $_SESSION['username'] ?? '';
$user_id     = "Anonymous";

if ($logged_user) {
    $stmt_u = $conn->prepare("SELECT User_id FROM customers WHERE Username = ?");
    $stmt_u->bind_param("s", $logged_user);
    $stmt_u->execute();
    $res_u = $stmt_u->get_result()->fetch_assoc();
    if ($res_u) {
        $user_id = "User #" . $res_u['User_id'];
    }
    $stmt_u->close();
}

$stmt = $conn->prepare("SELECT * FROM shop WHERE Shop_id = ?");
$stmt->bind_param("i", $shop_id);
$stmt->execute();
$shop = $stmt->get_result()->fetch_assoc() ?: ['Name' => 'Unknown Cafe', 'Specialty_base' => ''];
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    $rating  = intval($_POST['rating'] ?? 0);
    $comment = trim($_POST['comment'] ?? '');
    
    // Check if the user ticked the checkbox to show username
    $show_username = isset($_POST['show_username']);
    
    if ($show_username && !empty($logged_user)) {
        $display_name = $logged_user;
    } else {
        $display_name = $user_id; // Fallback to User ID
    }

    $res = $conn->query("SELECT MAX(Feedback_id) AS max_id FROM feedback");
    $feedback_id = (($res ? $res->fetch_assoc()['max_id'] : null) ?? 0) + 1;

    $stmt = $conn->prepare("INSERT INTO feedback (Feedback_id, Shop_id, Username, Rating, Comment, Feedback_date) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("iisis", $feedback_id, $shop_id, $display_name, $rating, $comment);
    if ($stmt->execute()) {
        $message = "Thank you for your feedback!";
    }
    $stmt->close();
}

$stmt_fb = $conn->prepare("SELECT Username, Rating, Comment, Feedback_date FROM feedback WHERE Shop_id = ? ORDER BY Feedback_id DESC");
$stmt_fb->bind_param("i", $shop_id);
$stmt_fb->execute();
$feedback_result = $stmt_fb->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Feedback</title>
    <style>
        * { 
            box-sizing: border-box; 
            margin: 0; 
            padding: 0; 
        }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: #F4EFEB radial-gradient(#D6C7B8 1px, transparent 1px) 0 0/24px 24px; 
            padding: 40px 15px; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            color: #2C1810; 
        }
        .container { 
            max-width: 600px; 
            width: 100%; 
            margin: auto; 
            background: white; 
            padding: 30px; 
            border-radius: 15px; 
            box-shadow: 0 12px 32px rgba(63, 29, 14, 0.08); 
        }
        .top-nav { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 20px; 
        }
        .btn-back, 
        .btn-logout { 
            padding: 10px 16px; 
            font-size: 14px; 
            font-weight: 600; 
            border-radius: 10px; 
            text-decoration: none; 
            color: #FFF; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.1); 
        }
        .btn-back { 
            background: #5C321E; 
        }
        .btn-back:hover { 
            background: #422314; 
        }
        .btn-logout { 
            background: #C62828; 
        }
        .btn-logout:hover { 
            background: #8E0000; 
        }
        h1, 
        .Shop_name, 
        .sub-text { 
            text-align: center; 
        }
        h1 { 
            margin-bottom: 10px; 
        }
        .Shop_name { 
            color: #8C5A3C; 
            margin-bottom: 10px; 
        }
        .sub-text { 
            font-size: 14px; 
            color: #5C321E; 
            margin-bottom: 25px; 
            padding-bottom: 15px; 
            border-bottom: 1px solid #E5D8CC; 
        }
        .success { 
            color: #4A6B3C; 
            background: #ECF6E8; 
            border: 1px solid #C9DFC0; 
            padding: 12px; 
            border-radius: 8px; 
            margin-bottom: 20px; 
            text-align: center; 
            font-weight: 600; 
        }
        .feedback { 
            background: #FAF7F5; 
            border: 1px solid #E5D8CC; 
            padding: 15px; 
            margin-top: 15px; 
            border-radius: 10px; 
        }
        .username { 
            font-weight: 700; 
        }
        .rating { 
            color: #8C5A3C; 
            font-weight: bold; 
            margin: 5px 0 7px; 
        }
        .feedback-date { 
            color: #7A6055; 
            font-size: 12px; 
            margin-top: 10px; 
        }
        .form-title { 
            margin: 30px 0 15px; 
        }
        label { 
            font-weight: 600; 
            font-size: 14px; 
        }
        textarea, 
        select { 
            width: 100%; 
            padding: 10px; 
            margin: 5px 0 15px; 
            border: 1px solid #D6C7B8; 
            border-radius: 8px; 
            font-family: inherit; 
        }
        textarea { 
            height: 100px; 
            resize: vertical; 
        }
        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 10px 0 15px;
            font-size: 14px;
            font-weight: 600;
            color: #5C321E;
        }
        .checkbox-container input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        .btn-submit { 
            width: 100%; 
            padding: 14px; 
            background: #5C321E; 
            color: #FFF; 
            font-size: 15px; 
            font-weight: 600; 
            border: none; 
            border-radius: 10px; 
            cursor: pointer; 
            box-shadow: 0 4px 12px rgba(92, 50, 30, 0.2); 
        }
        .btn-submit:hover { 
            background: #422314; 
        }
    </style>
</head>
<body>

<div class="container">

    <div class="top-nav">
        <a href="Shop.php?series=<?= urlencode($shop['Specialty_base']) ?>&drink=<?= urlencode($drink) ?>" class="btn-back">
            ← Back to Cafes
        </a>
        <a href="?action=logout" class="btn-logout" onclick="return confirm('Are you sure you want to log out?');">
            Log Out
        </a>
    </div>

    <h1>Customer Feedback</h1>

    <h2 class="Shop_name">
        <?= htmlspecialchars($shop['Name']) ?>
    </h2>

    <p class="sub-text">
        Feedback for this cafe
    </p>

    <?php if ($message): ?>
        <div class="success">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <h2>Customer Reviews</h2>

    <?php if ($feedback_result->num_rows > 0): ?>
        <?php while ($fb = $feedback_result->fetch_assoc()): ?>
            <div class="feedback">
                <div class="username">
                    <?= htmlspecialchars($fb['Username']) ?>
                </div>

                <div class="rating">
                    Rating: <?= htmlspecialchars($fb['Rating']) ?>/5
                </div>

                <p>
                    <?= htmlspecialchars($fb['Comment']) ?>
                </p>

                <div class="feedback-date">
                    <?= htmlspecialchars($fb['Feedback_date']) ?>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="margin-top:15px;">
            No feedback yet for this cafe.
        </p>
    <?php endif; ?>

    <h2 class="form-title">Give Your Feedback</h2>

    <form method="POST">
        <!-- Checkbox to toggle Username vs User ID -->
        <div class="checkbox-container">
            <input type="checkbox" id="show_username" name="show_username" value="1">
            <label for="show_username">Display my Username (<b><?= htmlspecialchars($logged_user) ?></b>) publicly</label>
        </div>
        <p style="font-size: 12px; color: #7A6055; margin-bottom: 15px;">
            If unchecked, your feedback will be posted under <b><?= htmlspecialchars($user_id) ?></b>.
        </p>

        <label>Rating</label>
        <select name="rating" required>
            <option value="">Choose rating</option>
            <option value="5">5 - Excellent</option>
            <option value="4">4 - Good</option>
            <option value="3">3 - Average</option>
            <option value="2">2 - Poor</option>
            <option value="1">1 - Very Poor</option>
        </select>

        <label>Comment</label>
        <textarea name="comment" placeholder="Write your feedback..." required></textarea>

        <button type="submit" name="submit" class="btn-submit">
            Submit Feedback
        </button>
    </form>

</div>

</body>
</html>
<?php
$stmt_fb->close();
$conn->close();
?>