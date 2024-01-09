<?php
    class m0002_add_user_password_column{
        public function up(): void
        {
            $db = \app\core\Application::$app->db;
            $db->getPdo()->exec("ALTER TABLE users ADD COLUMN password VARCHAR(512) NOT NULL");
        }
        public function down(): void
        {
            $db = \app\core\Application::$app->db;
            $db->getPdo()->exec("ALTER TABLE users DROP COLUMN password");
        }
    }
