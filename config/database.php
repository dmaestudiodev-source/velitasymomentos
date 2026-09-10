<?php
// config/database.php
// Returns a PDO connection instance for use with Delight Auth and the app

$host = 'db';
$dbname = 'velitasymomentos';
$username = 'root';
$password = '';


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}



