<?php

// Fix database tablespace issues
$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'pisah';

try {
    // Connect to MySQL database
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Drop problematic tables if they exist
    $tables = ['sessions', 'migrations'];
    
    foreach ($tables as $table) {
        try {
            $pdo->exec("DROP TABLE IF EXISTS `$table`");
            echo "Dropped table: $table\n";
        } catch (PDOException $e) {
            echo "Could not drop $table: " . $e->getMessage() . "\n";
        }
    }
    
    // Create migrations table
    $sql = "CREATE TABLE `migrations` (
        `id` int unsigned NOT NULL AUTO_INCREMENT,
        `migration` varchar(255) NOT NULL,
        `batch` int NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    echo "Migrations table created successfully.\n";
    
    // Create sessions table
    $sql = "CREATE TABLE `sessions` (
        `id` varchar(255) NOT NULL,
        `user_id` bigint unsigned DEFAULT NULL,
        `ip_address` varchar(45) DEFAULT NULL,
        `user_agent` text,
        `payload` longtext NOT NULL,
        `last_activity` int NOT NULL,
        PRIMARY KEY (`id`),
        KEY `sessions_user_id_index` (`user_id`),
        KEY `sessions_last_activity_index` (`last_activity`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql);
    echo "Sessions table created successfully.\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
