<?php

namespace app\core\Database;

class Database
{
    public \PDO $pdo;
    public function __construct(array $config)
    {
        $dsn = $config["dsn"];
        $user = $config["user"];
        $password = $config["password"];
        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
    public function applyMigrations(){
        //Creating The migrations Table in database to track the migrations that are applied
        $this->createMigrationsTable();
        //Getting the migrations that are applied from DataBase
        $appliedMigrations = $this->getAppliedMigrations();
        $newMigrations = [];
        //Getting the migrations files from migrations folder
        $migrationsFiles = scandir(Application::$ROOT_DIR.'/migrations');
        //Comparing migrations from Db and From the migrations folder
        $newMigration_toApply = array_diff($migrationsFiles, $appliedMigrations);
        foreach ($newMigration_toApply as $migration) {
            if ($migration === "." OR $migration === ".."){
                continue;
            }
            $className = (string)pathinfo($migration, PATHINFO_FILENAME);
            $className = '\app\migrations\\'.$className;
            $migrationInstance = new $className();
            $this->log("Applying migration ". $migration);
            $migrationInstance->Up();
            $this->log("Migration Applied.");
            $newMigrations[] = $migration;
        }
        if (!empty($newMigrations)){
            $this->saveMigrations($newMigrations);
        }else{
            $this->log("All migrations are applied.");
        }
    }
    public function saveMigrations(array $migrations){
        $migrations = implode(",",array_map(fn($m) => "('$m')", $migrations));
        var_dump($migrations);
        $sqlStatement = "
            INSERT INTO migrations 
                (migration)
            VALUES 
                $migrations
            ";
        $statement = $this->pdo->prepare($sqlStatement);
        $statement->execute();
    }
    public function createMigrationsTable(){
        $sqlStatement = "
            CREATE TABLE IF NOT EXISTS migrations
            (
                id INT AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;

        ";
        $this->pdo->exec($sqlStatement);
    }
    public function getAppliedMigrations(){
        $sqlStatement = "SELECT migration FROM migrations";
        $statement = $this->pdo->prepare($sqlStatement);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }
    public function log($message){
        echo "[".date("Y-m-d H:i:s")."] - ".$message.PHP_EOL;
    }
}