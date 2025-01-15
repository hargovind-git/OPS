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
    <link rel="stylesheet" href="styles.css">
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
