<?php
require 'config.php';

// change these:
$username = "";
$password = "";

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO admins (username, password_hash) VALUES (:u, :p)");
$stmt->execute([
    ':u' => $username,
    ':p' => $passwordHash
]);

echo "Admin user created: $username";
