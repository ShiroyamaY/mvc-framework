<?php
use app\core\Application;
class  m0001_initial{
    public function up(): void
    {
        $sql = "CREATE TABLE users(
                id INT AUTO_INCREMENT PRIMARY KEY ,
                email VARCHAR(255) NOT NULL,
                firstname VARCHAR(255) NOT NULL ,
                lastname VARCHAR(255) NOT NULL,
                status TINYINT DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE INNODB;";
        $db =Application::$app->db;
        $db->getPdo()->exec($sql);
    }
    public function down(): void
    {
        $sql ="DROP TABLE users";
        $db = Application::$app->db;
        $db->getPdo()->exec($sql);
    }
}