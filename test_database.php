<?php

// Test creating tables with different names
$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'pisah';

try {
    // Connect to MySQL database
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Test creating a simple table
    $sql = "CREATE TABLE IF NOT EXISTS `test_table` (
        `id` int unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    echo "Test table created successfully.\n";
    
    // Drop it immediately
    $pdo->exec("DROP TABLE `test_table`");
    echo "Test table dropped successfully.\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
