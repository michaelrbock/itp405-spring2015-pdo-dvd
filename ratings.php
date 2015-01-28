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

<?php foreach($movies as $movie) : ?>
    <div>
        <?php echo $movie->title ?>
        <a href="/ratings.php?rating_name=<?php echo $movie->rating_name ?>">
            <?php echo $movie->rating_name ?>
        </a>
    </div>
<?php endforeach; ?>
