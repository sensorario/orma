<?php


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

$orma = new Orma;
foreach($schema['tables'] as $table => $columns) {
    $orma($table)->createTable();
    foreach($columns as $column) {
        $orma->addColumn($column);
    }
}