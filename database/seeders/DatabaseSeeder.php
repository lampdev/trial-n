<?PHP

function runSeeders()
{
    $json = file_get_contents("../database/data/source.json");
    $source = json_decode($json);

    $host = "mysql";
    $userName = "trial";
    $password = "trial";
    $dbName = "trial";
    $options = [
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    try {
        $dbConn = new PDO("mysql:host=$host;dbname=$dbName", $userName, $password, $options);
        $bookPrepare = $dbConn->prepare("INSERT INTO `books` SET
            `title`            = :title,
            `isbn`             = :isbn,
            `pageCount`        = :pageCount,
            `thumbnailUrl`     = :thumbnailUrl,
            `shortDescription` = :shortDescription,
            `longDescription`  = :longDescription,
            `status`           = :status
        ");

        $authorPrepare = $dbConn->prepare("INSERT INTO `authors` (`name`)
            VALUES (:name) ON DUPLICATE KEY UPDATE id = LAST_INSERT_ID(id)");

        $authorBookPrepare = $dbConn->prepare("INSERT INTO `author_book` 
            SET
                `book_id`   = :book_id,
                `author_id` = :author_id
        ");

        foreach ($source as $value) {
            $authorsId = [];

            foreach ($value->authors as $name) {
                if (!empty($name)) {
                    $author = [
                        "name" => $name
                    ];

                    $authorPrepare->execute($author);
                    $authorId = $dbConn->lastInsertId();

                    if ($authorId != 0) {
                        $authorsId[] = $authorId;
                    }
                }
            }

            $book = [
                "title"            => $value->title,
                "isbn"             => isset($value->isbn) ? $value->isbn : '',
                "pageCount"        => $value->pageCount,
                "thumbnailUrl"     => isset($value->thumbnailUrl) ? $value->thumbnailUrl : '',
                "shortDescription" => isset($value->shortDescription) ? $value->shortDescription : '',
                "longDescription"  => isset($value->longDescription) ? $value->longDescription : '',
                "status"           => $value->status
            ];
            $bookPrepare->execute($book);
            $bookId = $dbConn->lastInsertId();

            foreach ($authorsId as $id) {
                $authorBook = [
                    "book_id"    => $bookId,
                    "author_id"  => $id
                ];

                $authorBookPrepare->execute($authorBook);
            }

        }
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
    header("Location: /index.php");
}
