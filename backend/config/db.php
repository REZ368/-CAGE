<?php
// backend/config/db.php

$host = 'sql.infinityfree.com';  // InfinityFree host
$db   = 'if0_39426093_yourdbname';  // Your InfinityFree database name
$user = 'if0_39426093';  // Your InfinityFree username
$pass = 'your_password_here';  // Your InfinityFree password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
} 