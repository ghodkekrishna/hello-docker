<?php
session_start();
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

// Allow specific headers and methods
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require 'db.php'; // Adjust path if needed

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['email']) || !isset($data['password'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Email and password required']);
    exit;
}

$email = $data['email'];
$password = $data['password'];

try {
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $password === $user['password']) {  // Plain text password check, replace with password_verify if hashed
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['username'];
        
        echo json_encode(['success' => true, 'message' => 'Login successful', 'user' => ['id' => $user['id'], 'name' => $user['username']]]);
    } else {
        http_response_code(401);
        echo json_encode(['success' => false, 'error' => 'Invalid credentials']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error']);
}
