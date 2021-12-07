<?PHP

function getBooksByAuthor()
{
    try {
        $author = $_POST['name'];

        if (empty($author)) {
            return;
        }

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
            SELECT title, shortDescription
            FROM authors
            LEFT JOIN author_book ON authors.id = author_book.author_id
            LEFT JOIN books ON author_book.book_id = books.id
            WHERE name = '$author'
        ";

        $sth = $dbConn->prepare($query);
        $sth->execute();
        $books = $sth->fetchAll(PDO::FETCH_ASSOC);

        if (!$books) {
            echo "no top three";
            return;
        }

        foreach ($books as $book) {
            echo "
        <div class='card'>
            <div class='card-body'>
                <h5 class='card-title'> {$book['title']} </h5>
                <p class='card-text'> {$book['shortDescription']} </p>
            </div>
        </div>";
        }
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
    header("Location: /index.php");
}
