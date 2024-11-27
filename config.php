<?php
// Database configuration
define('DB_HOST', 'localhost');    // Database host
define('DB_USER', 'root');         // Database username
define('DB_PASS', '');             // Database password
define('DB_NAME', 'kalarrrii'); // Database name

// Base URL of the project
define('BASE_URL', 'http://localhost/kalarrrii/');

// Paths
define('UPLOAD_PATH', __DIR__ . '/uploads/');
define('LOG_PATH', __DIR__ . '/logs/');

// Default settings
define('DEFAULT_LANGUAGE', 'en');
define('SITE_NAME', 'Sanjivani Organics');
define('CONTACT_EMAIL', 'info@sanjivaniorganics.com');

// Error reporting (set to 0 for production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection


// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Autoload classes (if applicable)
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/classes/' . $class . '.php';
    if (file_exists($file)) {
        include $file;
    }
});


try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Database connection successful";
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}


// Custom configuration can be added here
?>
