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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script type="module" src="../includes/form_validation.js" defer></script>
</head>
<body>
    <h1>Welcome to the Dashboard</h1>

    <section>
        <h2>User Preferences</h2>
        <p>Preferred Symbol: <span id="preferred-symbol">Loading...</span></p>
        <p>Risk Level: <span id="risk-level">Loading...</span></p>
        <form id="update-preferences-form">
            <label for="symbol-input">Preferred Symbol:</label>
            <input type="text" id="symbol-input" required pattern="^[A-Za-z0-9]{1,10}$" title="Symbol must be alphanumeric and up to 10 characters.">

            <label for="risk-input">Risk Level:</label>
            <input type="number" id="risk-input" min="1" max="5" required>

            <button type="submit">Update Preferences</button>
        </form>
        <div id="preferences-error" style="color: red; display: none;">Please fill out the form correctly.</div>
    </section>

    <section>
        <h2>Trade History</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Symbol</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Executed At</th>
                </tr>
            </thead>
            <tbody id="trade-history">
                <tr><td colspan="5">Loading...</td></tr>
            </tbody>
        </table>
    </section>

    <section>
        <h2>Log a New Trade</h2>
        <form id="log-trade-form">
            <label for="trade-symbol">Symbol:</label>
            <input type="text" id="trade-symbol" required pattern="^[A-Za-z0-9]{1,10}$" title="Symbol must be alphanumeric and up to 10 characters.">

            <label for="trade-type">Type:</label>
            <select id="trade-type" required>
                <option value="BUY">BUY</option>
                <option value="SELL">SELL</option>
            </select>

            <label for="trade-quantity">Quantity:</label>
            <input type="number" id="trade-quantity" step="0.01" required min="0.01" title="Quantity must be at least 0.01">

            <label for="trade-price">Price:</label>
            <input type="number" id="trade-price" step="0.01" required min="0.01" title="Price must be at least 0.01">

            <button type="submit">Log Trade</button>
        </form>
        <div id="trade-error" style="color: red; display: none;">Please fill out the form correctly.</div>
    </section>

    <a href="logout.php">Logout</a>
</body>
</html>
