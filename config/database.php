<?php
// config/database.php
// Returns a PDO connection instance for use with Delight Auth and the app

$host     = $_ENV['DB_HOST']     ?? getenv('DB_HOST')     ?? '127.0.0.1';
$dbname   = $_ENV['DB_NAME']     ?? getenv('DB_NAME')     ?? 'velitasymomentos';
$username = $_ENV['DB_USER']     ?? getenv('DB_USER')     ?? 'root';
$password = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?? '';
$port     = $_ENV['DB_PORT']     ?? getenv('DB_PORT')     ?? '3306';

try {
    $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}


