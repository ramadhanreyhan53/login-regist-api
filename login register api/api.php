<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$conn = new mysqli("localhost", "root", "", "user_db");

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit();
}

// Handle requests
$input = json_decode(file_get_contents("php://input"), true);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($input['action'] === 'register') {
        $username = $input['username'];
        $password = password_hash($input['password'], PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "User registered"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Registration failed"]);
        }
        $stmt->close();
    } elseif ($input['action'] === 'login') {
        $username = $input['username'];
        $password = $input['password'];

        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if ($hashed_password && password_verify($password, $hashed_password)) {
            echo json_encode(["status" => "success", "message" => "Login successful"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid credentials"]);
        }
        $stmt->close();
    }
}
$conn->close();
