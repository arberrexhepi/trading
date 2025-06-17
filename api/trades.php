<?php
// Trades API
require_once '../includes/auth.php';
require_once '../includes/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retrieve trade history
    requireAuth();
    $userId = $_SESSION['user_id'];
    $trades = getTradeHistory($userId);

    if ($trades) {
        echo json_encode(["success" => true, "trades" => $trades]);
    } else {
        echo json_encode(["success" => false, "message" => "No trade history found."]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Log a new trade
    requireAuth();
    $userId = $_SESSION['user_id'];
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['symbol']) || !isset($data['tradeType']) || !isset($data['quantity']) || !isset($data['price'])) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Missing required fields."]);
        exit();
    }

    $symbol = $data['symbol'];
    $tradeType = $data['tradeType'];
    $quantity = (float)$data['quantity'];
    $price = (float)$data['price'];

    $success = addTrade($userId, $symbol, $tradeType, $quantity, $price);

    if ($success) {
        echo json_encode(["success" => true, "message" => "Trade logged successfully."]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Failed to log trade."]);
    }
} else {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Method not allowed."]);
}
