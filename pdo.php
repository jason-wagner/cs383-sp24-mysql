<?php

require_once __DIR__ . '/db_login.php';

$conn = new PDO("mysql:host=localhost;dbname=cs383", $username, $password, [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);

if(array_key_exists('actor_id', $_GET)) {
    $showActor = true;

    $query = $conn->prepare("SELECT CONCAT(first_name, ' ', last_name) AS actor FROM actors WHERE id = :actor");
    $query->execute(['actor' => $_GET['actor_id']]);
    $actor = $query->fetch()['actor'];

    $query = $conn->prepare("SELECT title FROM films WHERE id IN(SELECT film_id FROM actor_film WHERE actor_id = :actor) ORDER BY release_year, title");
    $query->execute(['actor' => $_GET['actor_id']]);
} else {
    $showActor = false;
    $query = $conn->query("SELECT id, CONCAT(first_name, ' ', last_name) AS actor FROM actors ORDER BY last_name, first_name");
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Actors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <?php if($showActor): ?>
        <h1>Films for <?= $actor ?></h1>
        <ul class="list-group">
            <?php while($row = $query->fetch()): ?>
                <li class="list-group-item"><?= $row['title'] ?></li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <h1>Select An Actor</h1>
        <div class="list-group">
            <?php while($row = $query->fetch()): ?>
                <a class="list-group-item list-group-item-action" href="pdo.php?actor_id=<?= $row['id'] ?>"><?= $row['actor'] ?></a>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>