<?php

use Sensorario\Orma\Orma;
use Sensorario\Orma\SQLiteDriver;
use Sensorario\Orma\PostgreSQLDriver;

require_once __DIR__ . '/../vendor/autoload.php';

$schema = [
    'tables' => [
        'persone' => [
            'nome',
            'cognome',
        ],
        'cose' => [
            'colore',
        ],
        'animali' => [
            'verso',
        ],
    ]
];

$config = [
    'postgresql' => [
        'dns' => 'pgsql:host=database;dbname=your_database_name',
        'username' => 'your_username',
        'password' => 'your_password',
    ],
    'sqlite' => [
        'dns' => 'sqlite:./erdatabase',
    ],
    'db' => 'postgresql',
];

$pdo = new PDO(
    $config[$config['db']]['dns'],
    $config[$config['db']]['username'],
    $config[$config['db']]['password'],
);

$orma = new Orma($pdo, match($config['db']) {
    'sqlite' => new SQLiteDriver,
    'postgresql' => new PostgreSQLDriver,
});

foreach($schema['tables'] as $table => $columns) {
    $orma($table)->createTable();
    foreach($columns as $column) {
        $orma->addColumn($column);
    }
}
