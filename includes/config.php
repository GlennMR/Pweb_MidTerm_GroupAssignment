<?php
// Environment configuration
define('ENV', 'development'); // Change to 'production' when deploying

// Error reporting
if (ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_mahasiswa');

// Create mysqli connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Session configuration
ini_set('session. cookie_lifetime', 60* 60* 24* 7);
ini_set('session.gc_maxlifetime', 60 * 60* 24*7);
ini_set('session.use_strict_mode', 1);

session_start();

// Security headers (consider moving to a dedicated header file if they cause issues)
// header('X-Content-Type-Options: nosniff');
// header('X-Frame-Options: DENY');
// header('X-XSS-Protection: 1; mode=block');
// if (ENV === 'production') {
//     header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
// }

// Timezone
date_default_timezone_set('Asia/Jakarta');
?>