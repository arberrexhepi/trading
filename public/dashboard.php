<?php
// Dashboard Page
require_once '../includes/auth.php';
require_once '../includes/db.php';

// Restrict access to authenticated users
requireAuth();

// Fetch user preferences
$userId = $_SESSION['user_id'];
$userPreferences = getUserPreferences($userId);

// Fetch trade history
$tradeHistory = getTradeHistory($userId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script type="module" src="../includes/form_validation.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const updatePreferencesForm = document.getElementById('update-preferences-form');
            const logTradeForm = document.getElementById('log-trade-form');

            updatePreferencesForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const symbol = document.getElementById('symbol-input').value;
                const riskLevel = document.getElementById('risk-input').value;

                fetch('../api/preferences.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ symbol, riskLevel })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Preferences updated successfully.');
                    } else {
                        document.getElementById('preferences-error').style.display = 'block';
                    }
                });
            });

            logTradeForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const symbol = document.getElementById('trade-symbol').value;
                const tradeType = document.getElementById('trade-type').value;
                const quantity = document.getElementById('trade-quantity').value;
                const price = document.getElementById('trade-price').value;

                fetch('../api/trades.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ symbol, tradeType, quantity, price })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Trade logged successfully.');
                        location.reload();
                    } else {
                        document.getElementById('trade-error').style.display = 'block';
                    }
                });
            });
        });
    </script>
</head>
<body>
    <!-- Container for the Dashboard -->
    <div class="container">
        <!-- Dashboard Header -->
        <header class="text-center mt-lg">
            <h1>Welcome to the Dashboard</h1>
        </header>

        <!-- Main Content: Preferences, Trade History, and Log a New Trade -->
        <main>
            <!-- Preferences Section -->
            <section class="card mt-lg">
                <h2 class="section-title">User Preferences</h2>
                <div class="card-content">
                    <?php if ($userPreferences): ?>
                        <p><strong>Preferred Symbol:</strong> <span id="preferred-symbol" class="highlight"><?php echo htmlspecialchars($userPreferences['preferred_symbol']); ?></span></p>
                        <p><strong>Risk Level:</strong> <span id="risk-level" class="highlight"><?php echo htmlspecialchars($userPreferences['risk_level']); ?></span></p>
                    <?php else: ?>
                        <p class="text-muted">No user preferences found.</p>
                    <?php endif; ?>
                </div>

                <form id="update-preferences-form" class="form mt-md">
                    <label for="symbol-input" class="form-label">Preferred Symbol:</label>
                    <input type="text" id="symbol-input" class="form-input" required pattern="^[A-Za-z0-9]{1,10}$" title="Symbol must be alphanumeric and up to 10 characters.">

                    <label for="risk-input" class="form-label">Risk Level:</label>
                    <input type="number" id="risk-input" class="form-input" min="1" max="5" required>

                    <button type="submit" class="btn btn-primary mt-md">Update Preferences</button>
                </form>
                <div id="preferences-error" class="error mt-md" style="display: none;">Please fill out the form correctly.</div>
            </section>

            <!-- Trade History Section -->
            <section class="card mt-lg">
                <h2 class="section-title">Trade History</h2>
                <div class="card-content">
                    <table class="table">
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
                            <?php if (empty($tradeHistory)): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No trade history available.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($tradeHistory as $trade): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($trade['symbol']); ?></td>
                                        <td><?php echo htmlspecialchars($trade['trade_type']); ?></td>
                                        <td><?php echo htmlspecialchars($trade['quantity']); ?></td>
                                        <td><?php echo htmlspecialchars($trade['price']); ?></td>
                                        <td><?php echo htmlspecialchars($trade['executed_at']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Log a New Trade Section -->
            <section class="card mt-lg">
                <h2 class="section-title">Log a New Trade</h2>
                <form id="log-trade-form" class="form mt-md">
                    <label for="trade-symbol" class="form-label">Symbol:</label>
                    <input type="text" id="trade-symbol" class="form-input" name="symbol" required pattern="^[A-Za-z0-9]{1,10}$" title="Symbol must be alphanumeric and up to 10 characters.">

                    <label for="trade-type" class="form-label">Type:</label>
                    <select id="trade-type" class="form-input" name="tradeType" required>
                        <option value="BUY">BUY</option>
                        <option value="SELL">SELL</option>
                    </select>

                    <label for="trade-quantity" class="form-label">Quantity:</label>
                    <input type="number" id="trade-quantity" class="form-input" name="quantity" step="0.01" required min="0.01" title="Quantity must be at least 0.01">

                    <label for="trade-price" class="form-label">Price:</label>
                    <input type="number" id="trade-price" class="form-input" name="price" step="0.01" required min="0.01" title="Price must be at least 0.01">

                    <button type="submit" class="btn btn-primary mt-md">Log Trade</button>
                </form>
                <div id="trade-error" class="error mt-md" style="display: none;">Please fill out the form correctly.</div>
            </section>
        </main>

        <!-- Logout Section -->
        <footer class="mt-lg text-center">
            <a href="logout.php" class="btn btn-secondary">Logout</a>
        </footer>
    </div>
</body>


</html>
