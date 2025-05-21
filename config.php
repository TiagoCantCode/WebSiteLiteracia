<?php
$host = '127.0.0.1'; // or 'localhost'
$dbname = 'health_qa';
$username = 'root';
$password = ''; // Empty password for XAMPP default

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>