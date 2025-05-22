<?php
$host = 'localhost';
$db   = 'login_app';
$user = 'root';
$pass = 'secret';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>