<?php
// Entry point for the Trading App
require_once '../includes/auth.php';
require_once '../includes/config.php';

// Start session management
session_start();

// Redirect logic
if (!isAuthenticated()) {
    header("Location: login.php");
    exit();
}

header("Location: dashboard.php");
exit();

