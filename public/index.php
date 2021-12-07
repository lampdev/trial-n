<?PHP
set_time_limit(0);

include_once "../database/MysqlConnect.php";
include_once "../database/seeders/DatabaseSeeder.php";
include_once "../templates/Author.php";
include_once "../templates/Book.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trial</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>

<?PHP
    $action = $_POST['button'];
    if (isset($action)) {
        $action();
    }
    ?>

    <form method="post">
        <input type="submit" name="button" class="button" value="createDB" />
    </form>
    <br />
    <form method="post">
        <input type="submit" name="button" class="button" value="runMigration" />
    </form>
    <br />
    <form method="post">
        <input type="submit" name="button" class="button" value="runSeeders" />
    </form>
    <br />

    <form method="post">
        <input type="text" name="name" />
        <input type="submit" name="button" class="button" value="getBooksByAuthor" />
    </form>

    <div class="container">
        <?php
        getTopThree();
        ?>
    </div>



</body>

</html>