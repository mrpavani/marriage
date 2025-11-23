<?php

$config = require __DIR__ . '/config.php';

echo "Initializing MySQL database...\n";

try {
    // Connect to MySQL server (without dbname) to create database if not exists
    $pdo = new PDO("mysql:host={$config['host']}", $config['user'], $config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $dbname = $config['dbname'];
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database '$dbname' checked/created.\n";
    
} catch (PDOException $e) {
    die("DB Connection Error: " . $e->getMessage() . "\n");
}

// Now connect using the Database class (which uses the config with dbname)
require_once __DIR__ . '/src/Database.php';
$db = Database::getInstance()->getConnection();

$schema = file_get_contents(__DIR__ . '/database/schema.sql');

try {
    // Split schema by semicolon to execute statements individually
    // This is a simple split, for complex schemas use a better parser
    $statements = array_filter(array_map('trim', explode(';', $schema)));

    foreach ($statements as $stmt) {
        if (!empty($stmt)) {
            $db->exec($stmt);
        }
    }
    echo "Tables created successfully.\n";

    // Create default admin user if not exists
    $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE username = 'admin'");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $password = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (username, password_hash) VALUES ('admin', ?)");
        $stmt->execute([$password]);
        echo "Default admin user created (admin / admin123).\n";
    } else {
        echo "Admin user already exists.\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
