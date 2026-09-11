<?php
// config/database.php
// Returns a PDO connection instance for use with Delight Auth and the app

$envHost  = $_ENV['DB_HOST'] ?? getenv('DB_HOST');
$dbname   = $_ENV['DB_NAME']     ?? getenv('DB_NAME')     ?? 'velitasymomentos';
$username = $_ENV['DB_USER']     ?? getenv('DB_USER')     ?? 'root';
$password = $_ENV['DB_PASSWORD'] ?? getenv('DB_PASSWORD') ?? '';
$port     = $_ENV['DB_PORT']     ?? getenv('DB_PORT')     ?? '3306';

// Si no hay variable definida o es localhost/127.0.0.1 (entorno local), usamos el contenedor 'db'
if (empty($envHost) || $envHost === 'localhost' || $envHost === '127.0.0.1') {
    $host = 'db';
} else {
    $host = $envHost;
}

try {
    $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ]);
    return $pdo;
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}


