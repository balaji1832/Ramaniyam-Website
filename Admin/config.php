<?php
// config.php
$host = "localhost";          // usually localhost
$dbname = "ramaniyam_db";       // your DB name
$user = "root";         // your DB username
$pass = "";     // your DB password

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB connection failed: " . $e->getMessage());
}
