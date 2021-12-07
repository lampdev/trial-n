<?PHP
function getTopThree()
{
    try {
        $host = "mysql";
        $userName = "trial";
        $password = "trial";
        $dbName = "trial";
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        $dbConn = new PDO("mysql:host=$host;dbname=$dbName", $userName, $password, $options);
        $query = "
    SELECT author_id, name, COUNT(author_id) as count 
    FROM author_book 
    LEFT JOIN authors ON author_book.author_id = authors.id
	GROUP BY author_id 
    ORDER BY count DESC LIMIT 3";

        $sth = $dbConn->prepare($query);
        $sth->execute();
        $authors = $sth->fetchAll(PDO::FETCH_ASSOC);

        if (!$authors) {
            echo "no top three";
            return;
        }

        foreach ($authors as $author) {
            echo "
        <div class='card'>
            <div class='card-body'>
                <h5 class='card-title'> {$author['name']} </h5>
                <p class='card-text'> {$author['count']} </p>
            </div>
        </div>";
        }
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
    header("Location: /index.php");
}
