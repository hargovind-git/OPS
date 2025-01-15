<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Hardcoded login for demonstration purposes
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === 'admin' && $password === 'password123') {
        $_SESSION['logged_in'] = true;
        header('Location: shop_owner.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-box">
        <h2>Shop Owner Login</h2>
        <form action="shop_owner_login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <?php if (isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
