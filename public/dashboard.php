<?php
// Dashboard Page
require_once '../includes/auth.php';

// Restrict access to authenticated users
requireAuth();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <h1>Welcome to the Dashboard</h1>

    <p>You are logged in as user ID: <?php echo htmlspecial(@$_SESSION['user_id']) ?><.</p>

    <a href="logout.php">Logout</a>
</body>
</html>
