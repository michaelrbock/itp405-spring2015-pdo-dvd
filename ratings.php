<?php

if (!isset($_GET['rating_name'])) {
    header('Location: index.php');
}

$rating = $_GET['rating_name'];

// SQL connect info
$host = 'itp460.usc.edu';
$dbname = 'dvd';
$user = 'student';
$password = 'ttrojan';
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

$sql = "
    SELECT title, genre_name, format_name, rating_name
    FROM ratings
    INNER JOIN dvds
    ON dvds.rating_id = ratings.id
    INNER JOIN genres
    ON dvds.genre_id = genres.id
    INNER JOIn formats
    ON dvds.format_id = formats.id
    WHERE rating_name = ?
";

$statement = $pdo->prepare($sql);
$statement->bindParam(1, $rating);
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
