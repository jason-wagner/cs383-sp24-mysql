<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/../../../db_login.php';

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

$data = ['first_name' => 'JASON', 'last_name' => 'WAGNER'];
$actor = Actor::create($data);
