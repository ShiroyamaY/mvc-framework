<?php

namespace app\core;

class Database
{
    private \PDO $pdo;
    private static  ?Database $instance = null;
    public static function getInstance(array $config) : self{
        if(!self::$instance instanceof self){
            self::$instance = new self($config);
        }
        return self::$instance;
    }
    private function __construct(array $config){
        $dsn = $config['dsn'];
        $user = $config['user'];
        $password = $config['password'];
        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
    }
    public function getPdo(): \PDO
    {
        return $this->pdo;
    }
    public function applyMigrations(): void
    {
        $this->createMigrationTable();
        $applied = $this->getAppliedMigrations();

        $files = scandir(Application::$ROOT_DIR . '/migrations');

        $toApplyMigrations = array_diff($files,$applied);
        $newMigrations = [];
        foreach ($toApplyMigrations as $migration){
            if ($migration === '.' || $migration === '..'){
                continue;
            }
            require_once Application::$ROOT_DIR . "/migrations/$migration";
            $filename = pathinfo($migration,PATHINFO_FILENAME);
            $instance = new $filename();
            $this->log("Applying migration $filename");
            $instance->up();
            $this->log("Applied migration $filename");
            $newMigrations[] = $migration;
        }
        if (!empty($newMigrations)){
            $this->saveMigrations($newMigrations);
        }else
        {
            $this->log("All migrations are applied");
        }
    }
    public function createMigrationTable(): void
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY ,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;
        ");
    }
    public function getAppliedMigrations(): bool|array
    {
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }
    public function saveMigrations(array $migrations): void
    {
        $str = implode(',', array_map( fn($m) => "('$m')", $migrations));
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $str");
        $statement->execute();
    }
    protected function log($message){
        echo '['.date('Y-m-d').'] - ' . $message . PHP_EOL."\n";
    }
}