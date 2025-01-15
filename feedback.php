<?php
// Get query parameters
$customerName = htmlspecialchars($_GET['name'] ?? '');
$customerMobile = htmlspecialchars($_GET['mobile'] ?? '');
$pageCount = htmlspecialchars($_GET['pages'] ?? '');
$printType = htmlspecialchars($_GET['type'] ?? '');
$estimatedCost = htmlspecialchars($_GET['cost'] ?? '');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            color: #fff;
            text-align: center;
            padding: 50px;
        }
        .feedback-box {
            background: rgba(255, 255, 255, 0.9);
            color: #333;
            border-radius: 10px;
            padding: 30px;
            display: inline-block;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        h1 {
            color: #ff7e5f;
        }
        .highlight {
            color: #ff7e5f;
            font-weight: bold;
        }
        .btn-home {
            background-color: #ff7e5f;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
            margin-top: 20px;
        }
        .btn-home:hover {
            background-color: #feb47b;
        }
    </style>
</head>
<body>
    <div class="feedback-box">
        <h1>Thank You, <?php echo $customerName; ?>!</h1>
        <p>Your order has been received. Here's your order summary:</p>
        <p><strong>Name:</strong> <?php echo $customerName; ?></p>
        <p><strong>Mobile:</strong> <?php echo $customerMobile; ?></p>
        <p><strong>Pages:</strong> <?php echo $pageCount; ?></p>
        <p><strong>Print Type:</strong> <?php echo ($printType === 'bw') ? 'Black & White' : 'Color'; ?></p>
        <p><strong>Estimated Cost:</strong> <span class="highlight"><?php echo $estimatedCost; ?> INR</span></p>
        <p>You can return to the homepage whenever you're ready:</p>
        <button class="btn-home" onclick="window.location.href='index.html';">Go to Home</button>
    </div>
</body>
</html>
