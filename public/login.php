<?php
// Login Page
require_once '../includes/auth.php';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $loginResult = loginUser($username, $password);
    if ($loginResult['success']) {
        header('Location: dashboard.php');
        exit();
    } else {
        $errorMessage = $loginResult['message'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <h1>Login</h1>

    <?ph if (isset($errorMessage)): ?>>
        <p style="color: red;"> <?php echo htmlspecial($errorMessage) ?> </p>
    <?ph endif ?>

    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
</form>
</body>
</html>
