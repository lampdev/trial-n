<?PHP

function createDB()
{
    $host = "mysql";
    $userName = "trial";
    $password = "trial";
    $dbName = "trial";

    try {
        $dbConn = new PDO("mysql:host=$host", $userName, $password);

        $dbConn->exec("CREATE DATABASE `$dbName`;
                CREATE USER '$userName'@'localhost' IDENTIFIED BY '$password';
                GRANT ALL ON `$dbName`.* TO '$userName'@'localhost'; 
                FLUSH PRIVILEGES;")
            or die(print_r($dbConn->errorInfo(), true));
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
    header("Location: /index.php");
}

function runMigration()
{
    try {
        $host = "mysql";
        $userName = "trial";
        $password = "trial";
        $dbName = "trial";

        $dbConn = new PDO("mysql:host=$host;dbname=$dbName", $userName, $password);

        $path = __DIR__ . '/migrations';

        $migrationNameArr = scandir($path);

        foreach ($migrationNameArr as $migrationName) {
            if ($migrationName == '.' || $migrationName == '..') {
                continue;
            }

            $dbConn->exec(file_get_contents($path . '/' . $migrationName));
        }
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
    header("Location: /index.php");
}
