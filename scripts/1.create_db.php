<?php

$host = 'localhost';
$port = 3306;
$user = 'root';         // or user with privileges to create DB
$pass = 'admin';
$dbname = 'message';

try {
    // Connect to MySQL server without database selected
    $pdo = new PDO("mysql:host=$host;port=$port;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

    echo "Database '$dbname' created (or already exists).\n";
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}