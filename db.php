<?php
// --- ENABLE ERROR REPORTING FOR DEBUGGING ---
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$user = "";
$pass = "";
$db_name = "";

$conn = new mysqli($host, $user, $pass, $db_name);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>