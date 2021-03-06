<?php

if (!isset($_GET['title'])) {
    header('Location: index.php');
}

$title = $_GET['title'];

// SQL connect info
$host = 'itp460.usc.edu';
$dbname = 'dvd';
$user = 'student';
$password = 'ttrojan';
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

$sql = "
    SELECT title, genre_name, format_name, rating_name
    FROM dvds
    INNER JOIN genres
    ON dvds.genre_id = genres.id
    INNER JOIN formats
    ON dvds.format_id = formats.id
    INNER JOIN ratings
    ON dvds.rating_id = ratings.id
    WHERE title LIKE ?
";

$statement = $pdo->prepare($sql);
$like = '%' . $title . '%';
$statement->bindParam(1, $like);
$statement->execute();
$movies = $statement->fetchAll(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

</head>

<body>

    <div>You searched for '<?php echo $title ?>'</div>
    <br>

    <?php foreach($movies as $movie) : ?>
        <div>
            <span class="glyphicon glyphicon-film"></span>
            <p>
                Title: <?php echo $movie->title ?>
            </p>
            <p>
                Genre: <?php echo $movie->genre_name ?>
            </p>
            <p>
                Format: <?php echo $movie->format_name ?>,
            </p>
            <p>
                Rating:
                <a href="/ratings.php?rating_name=<?php echo $movie->rating_name ?>">
                    <?php echo $movie->rating_name ?>
                </a>
            </p>
        </div>
        <br>
    <?php endforeach; ?>

</body>
</html>


