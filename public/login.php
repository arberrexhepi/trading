<?php
// Login Page
require_once '../includes/auth.php';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $loginResult = loginUser($username, $password);
        if ($loginResult['success']) {
            header('Location: dashboard.php');
            exit();
        } else {
            $errorMessage = $loginResult['message'];
        }
    } elseif (isset($_POST['register'])) {
        $username = $_POST['reg_username'] ?? '';
        $password = $_POST['reg_password'] ?? '';
        $email = $_POST['reg_email'] ?? '';

        $registerResult = registerUser($username, $password, $email);
        if ($registerResult['success']) {
            header('Location: dashboard.php');
            exit();
        } else {
            $registerErrorMessage = $registerResult['message'];
        }
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
    <div class="container">
        <!-- Login Section -->
        <section class="card mt-lg">
            <h1 class="text-center">Login</h1>
            <?php if (isset($errorMessage)): ?>
                <p class="error text-center"><?php echo htmlspecialchars($errorMessage); ?></p>
            <?php endif; ?>
            <form method="POST" action="" class="form mt-md">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-input" required>

                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-input" required>

                <button type="submit" name="login" class="btn btn-primary mt-md">Login</button>
            </form>
        </section>

        <!-- Register Section -->
        <section class="card mt-lg">
            <h1 class="text-center">Register</h1>
            <?php if (isset($registerErrorMessage)): ?>
                <p class="error text-center"><?php echo htmlspecialchars($registerErrorMessage); ?></p>
            <?php endif; ?>
            <form method="POST" action="" class="form mt-md">
                <label for="reg_username" class="form-label">Username:</label>
                <input type="text" id="reg_username" name="reg_username" class="form-input" required>

                <label for="reg_password" class="form-label">Password:</label>
                <input type="password" id="reg_password" name="reg_password" class="form-input" required>

                <label for="reg_email" class="form-label">Email:</label>
                <input type="email" id="reg_email" name="reg_email" class="form-input" required>

                <button type="submit" name="register" class="btn btn-primary mt-md">Register</button>
            </form>
        </section>
    </div>
</body>

</html>
