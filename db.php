<?php
$host = '127.0.0.1'; // changed from 'localhost' to IP
$db   = 'login_app';
$user = 'root';
$pass = 'secret';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
