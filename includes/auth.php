<?php
// Authentication module
session_start();

// Database connection (use the existing db.php)
require_once 'db.php';

// User Registration
function registerUser($username, $password, $email) {
    global $conn;

    // Check if the username or email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        return ["success" => false, "message" => "Username or email already exists."];
    }

    // Insert new user
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashedPassword, $email);

    if ($stmt->execute()) {
        return ["success" => true, "message" => "User registered successfully."];
    } else {
        return ["success" => false, "message" => "Error registering user."];
    }
}

// Ensure user is authenticated
function requireAuth() {
    if (!isAuthenticated()) {
        header("Location: ../public/login.php");
        exit();
    }
}

// User Login
function loginUser($username, $password) {
    global $conn;

    // Retrieve user by username
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $hashedPassword);

    if ($stmt->fetch() && password_verify($password, $hashedPassword)) {
        // Login successful
        $_SESSION['user_id'] = $id;
        return ["success" => true, "message" => "Login successful."];
    } else {


        return ["success" => false, "message" => "Invalid username or password."];
    }
}

// Check if user is authenticated
function isAuthenticated() {
    return isset($_SESSION['user_id']);
}

// User Logout
function logoutUser() {
    session_unset();
    session_destroy();
    return ["success" => true, "message" => "User logged out successfully."];
}

