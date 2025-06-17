<?php
require_once '../includes/db.php'; // Database connection
require_once '../includes/auth.php'; // Authentication
require_once '../includes/logger.php'; // Error logging
require_once '../includes/validation.php'; // Input validation

requireAuth();

header('Content-Type: application/json');

// Get input data
$data = json_decode(file_get_contents('php://input'), true);

// Handle GET request to retrieve preferences
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userId = $_SESSION['user_id'] ?? null;

    if (!$userId) {
        logError("Unauthorized access attempt to GET preferences.");
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'User not authenticated.']);
        exit;
    }

    $preferences = getUserPreferences($userId);

    if ($preferences) {
        echo json_encode(['success' => true, 'preferences' => $preferences]);
    } else {
        logError("No preferences found for user ID: $userId.");
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'No preferences found.']);
    }
    exit;
}

// Handle POST request to update preferences
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'] ?? null;

    if (!$userId) {
        logError("Unauthorized access attempt to POST preferences.");
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'User not authenticated.']);
        exit;
    }

    // Validate input
    if (!isset($data['symbol']) || !validateSymbol($data['symbol'])) {
        logError("Invalid symbol provided: " . json_encode($data));
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid symbol format.']);
        exit;
    }

    if (!isset($data['riskLevel']) || !validateRiskLevel($data['riskLevel'])) {
        logError("Invalid risk level provided: " . json_encode($data));
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Risk level must be between 1 and 5.']);
        exit;
    }

    $symbol = $data['symbol'];
    $riskLevel = (int) $data['riskLevel'];

    try {
        $existingPreferences = getUserPreferences($userId);

        if ($existingPreferences) {
            $success = updateUserPreferences($userId, $symbol, $riskLevel);
        } else {
            $success = addUserPreference($userId, $symbol, $riskLevel);
        }

        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Preferences updated successfully.']);
        } else {
            logError("Database operation failed for user ID: $userId.");
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to update preferences.']);
        }
    } catch (Exception $e) {
        logError("Exception occurred: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'An internal error occurred.']);
    }
    exit;
}

// If method not allowed
logError("Invalid request method: " . $_SERVER['REQUEST_METHOD']);
http_response_code(405);
echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
