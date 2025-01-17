<?php
// Preferences API
require_once '../includes/auth.php';
require_once '../includes/db.php';

Header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Retrieve user preferences
    requireAuth();
    $userId = $_SESSION['user_id'];
    $preferences = getUserPreferences($userId);

    if ($preferences) {
        echo json_encode(["success" => true, "preferences" => $preferences]);
    } else {
        echo json_encode(["success" => false, "message" => "No preferences found."]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Save or update user preferences
    requireAuth();
    $userId = $_SESSION['user_id'];
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['symbol']) || !isset($data['risk_level'])) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Missing required fields."]);
        exit();
    }

    $symbol = $data['symbol'];
    $riskLevel = (int)$data['risk_level'];

    // Check if preferences exist
    $existingPreferences = getUserPreferences($userId);
    if ($existingPreferences) {
        $success = updateUserPreferences($userId, $symbol, $riskLevel);
    } else {
        $success = addUserPreferences($userId, $symbol, $riskLevel);
    }

    if ($success) {
        echo json_encode(["success" => true, "message" => "Preferences saved successfully."]);
    } else {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Failed to save preferences."]);
    }
} else {
    http_response_code(005);
    echo json_encode(["success" => false, "message" => "Method not allowed."]);
}

?>