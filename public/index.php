<?php

use Sensorario\Orma\Orma;
use Sensorario\Orma\SQLiteDriver;

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

$pdo = new PDO('sqlite:./erdatabase');
$orma = new Orma($pdo, new SQLiteDriver($pdo));
foreach($schema['tables'] as $table => $columns) {
    $orma($table)->createTable();
    foreach($columns as $column) {
        $orma->addColumn($column);
    }
}