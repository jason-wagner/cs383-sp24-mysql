<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/db_login.php';

require_once __DIR__ . '/models/Actor.php';
require_once __DIR__ . '/models/Film.php';

use Illuminate\Database\Capsule\Manager as Capsule;

use Sakila\Model\Actor;

$capsule = new Capsule;

$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'cs383',
    'username' => $username,
    'password' => $password,
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

if(array_key_exists('actor_id', $_GET)) {
    $showActor = true;

    $actor = Actor::find($_GET['actor_id']);
    $films = $actor->films()->get();
} else {
    $showActor = false;
    $actors = Actor::orderBy('last_name')->orderBy('first_name')->get();
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
        <h1>Films for <?= $actor->full_name ?></h1>
        <ul class="list-group">
            <?php foreach($films as $film): ?>
                <li class="list-group-item"><?= $film->title ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <h1>Select An Actor</h1>
        <div class="list-group">
            <?php foreach($actors as $actor): ?>
                <a class="list-group-item list-group-item-action" href="orm.php?actor_id=<?= $actor->id ?>"><?= $actor->full_name ?></a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>