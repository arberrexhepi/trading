<?php
require_once '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Access environment variables
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
define('DB_NAME', $_ENV['DB_DATABASE']);

define('DEFAULT_RISK', 2); // Default risk percentage
define('API_BASE_URL', 'https://api.example.com/'); // Base URL for API calls
define('LOG_PATH', __DIR__ . '/../logs/'); // Path to store logs
