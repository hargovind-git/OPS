<?php
session_start();

// Check for login
if (!isset($_SESSION['logged_in'])) {
    header("Location: shop_owner_login.php");
    exit;
}

// Load orders from JSON
$jsonFilePath = 'orders.json';
$orders = file_exists($jsonFilePath) ? json_decode(file_get_contents($jsonFilePath), true) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop Owner Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container2">
        <h1>Shop Owner Dashboard</h1>
        <table>
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Mobile Number</th>
                    <th>Document Name</th>
                    <th>Pages</th>
                    <th>Print Type</th>
                    <th>Estimated Cost</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $index => $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['customerName']); ?></td>
                    <td><?php echo htmlspecialchars($order['customerMobile']); ?></td>
                    <td><?php echo htmlspecialchars($order['documentName']); ?></td>
                    <td><?php echo htmlspecialchars($order['pages']); ?></td>
                    <td><?php echo htmlspecialchars($order['printType'] === 'bw' ? 'Black & White' : 'Color'); ?></td>
                    <td><?php echo htmlspecialchars($order['estimatedCost']); ?> INR</td>
                    <td><?php echo htmlspecialchars($order['status']); ?></td>
                    <td>
                        <form method="POST" action="update_status.php">
                            <input type="hidden" name="index" value="<?php echo $index; ?>">
                            <button type="submit" name="status" value="done">Mark Done</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
</body>
</html>
