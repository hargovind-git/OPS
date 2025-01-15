<?php
session_start();

// Check for login
if (!isset($_SESSION['logged_in'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($username === 'sahebtelecom' && $password === 'Saheb@1!@#') {
            $_SESSION['logged_in'] = true;
        } else {
            echo "<div class='error-message'>Invalid username or password.</div>";
        }
    }

    // Show styled login form
    echo '<!DOCTYPE html>
          <html lang="en">
          <head>
              <meta charset="UTF-8">
              <meta name="viewport" content="width=device-width, initial-scale=1.0">
              <title>Shop Owner Login</title>
              <link rel="stylesheet" href="styles.css">
              <style>
                  body {
                      font-family: Arial, sans-serif;
                      background-color: #f9f9f9;
                      display: flex;
                      justify-content: center;
                      align-items: center;
                      height: 100vh;
                      margin: 0;
                  }
                  .login-container {
                      background: #ffffff;
                      padding: 20px 30px;
                      border-radius: 8px;
                      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                      width: 100%;
                      max-width: 400px;
                      text-align: center;
                  }
                  .login-container h2 {
                      margin-bottom: 20px;
                      color: #333333;
                  }
                  .login-container input {
                      width: calc(100% - 20px);
                      padding: 10px;
                      margin: 10px 0;
                      border: 1px solid #ccc;
                      border-radius: 4px;
                      font-size: 16px;
                  }
                  .login-container button {
                      background: #007bff;
                      color: #ffffff;
                      border: none;
                      padding: 10px 20px;
                      font-size: 16px;
                      border-radius: 4px;
                      cursor: pointer;
                  }
                  .login-container button:hover {
                      background: #0056b3;
                  }
                  .error-message {
                      color: red;
                      margin-bottom: 10px;
                  }
              </style>
          </head>
          <body>
              <div class="login-container">
                  <h2>Shop Owner Login</h2>
                  <form method="POST" action="shop_owner.php">
                      <input type="text" name="username" id="username" placeholder="Username" required>
                      <input type="password" name="password" id="password" placeholder="Password" required>
                      <button type="submit">Login</button>
                  </form>
              </div>
          </body>
          </html>';
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
                        <a href="uploads/<?php echo urlencode($order['documentName']); ?>" target="_blank">Print</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="logout.php" class="btn admin-btn" style="float: right;">Logout</a>
    </div>
</body>
</html>
