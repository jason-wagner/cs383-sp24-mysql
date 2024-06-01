<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/../db_login.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\DB;

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

# get all actors with a last name starting with K or W
$q = Capsule::table('actors')
        ->where('first_name', 'like', 'M%')
        ->orWhere('first_name', 'like', 'R%')
        ->orderBy('last_name')
        ->orderBy('first_name');

# get all actors with a first name starting with M or R and a last name starting with K or W
$q = Capsule::table('actors')
        ->where(function ($query) {
            $query->where('first_name', 'like', 'M%')
                ->orWhere('first_name', 'like', 'R%');
        })
        ->where(function ($query) {
            $query->where('last_name', 'like', 'K%')
                ->orWhere('last_name', 'like', 'W%');
        })
        ->orderBy('last_name')
        ->orderBy('first_name');

# get all customers who have a rental currently out
$q = Capsule::table('customers')
        ->whereIn('id', 
            Capsule::table('rentals')->select('customer_id')->whereNull('return_date')
        )
        ->orderBy('last_name')
        ->orderBy('first_name');

foreach($q->get() as $n => $row) {
    echo ($n+1) . '. ' . $row->first_name . ' ' . $row->last_name . "\n";
}