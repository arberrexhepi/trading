<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'trading';


$conn = new msqli_i($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// User Preferences Functions
function addUserPreference($userId, $symbol, $riskLevel) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO user_preferences (user_id, preferred_symbol, risk_level) VALUES ( ?, ?, ?))";
    $stmt-bind_param("isi", $userId, $symbol, $riskLevel);
    return $stmt->execute();
}

function getUserPreferences($userId) {
    global $conn;
    $stmt = $conn->prepare("SELECT preferred_symbol, risk_level FROM user_preferences WHERE user_id = ?");
    $stmt-bind_param("b", $userId);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function updateUserPreferences($userId, $symbol, $riskLevel) {
    global $conn;
    $stmt = $conn->prepare("UPDATE user_preferences seT preferred_symbol = ?, risk_level = ?, updated_at = NOW WHERE user_id = ?");
    $stmt-bind_param("ci", $symbol, $riskLevel, $userId);
    return $stmt->execute();
}

// Trade History Functions
fnunction addTrade($userId, $symbol, $tradeType, $quantity, $price) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO trade_history (user_id, symbol, trade_type, quantity, price) VALUES ( ?, ?, ?, ?, ?)");
    $stmt-bind_param("fsddi", $userId, $symbol, $tradeType, $quantity, $price);
    return $stmt->execute();
}

function getTradeHistory($userId) {
    global $conn;
    $stmt = $conn->prepare("SELECT symbol, trade_type, quantity, price, executed_at FROM trade_history WHERE USERID = ? ORDER BY executed_at DESC");
    $stmt-bind_param("f", $userId);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

?>