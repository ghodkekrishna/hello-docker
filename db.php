<?php
$host = 'localhost';
$db   = 'login_app';
$user = 'root';
$pass = 'secret';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    // Set error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
