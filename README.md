# ORMA

 - puoi creare tabelle
 - aggiungere colonne
 - puoi farlo tanto con sqlite quanto con postgresql

## Installazione

 > composer require sensorario/orma

Puo copiare `vendor/sensorario/orma/public/index.php` nella root del progetto ed eseguire l'esempio.
SQLite non richiede alcuna installazione. Per quel che riguarda postgresql, si puo trarre ispirazione da `vendor/sensorario/orma/docker-compose.yaml`.

Buon divertimento

## Test

Dopo aver installato con `composer install`, lanciare il comando `./bin/robo watch:code` che lancera i test ogni volta che un file dentro `src/` o `tests/` verra modificato.

## PDO

I dati PostgreSQL fanno riferimento alla docker presente nel progetto.

```php
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
```

## init

```php
$orma = new Orma($pdo, match($driver) {
    'sqlite' => new SQLiteDriver,
    'postgresql' => new PostgreSQLDriver,
});
```

## create a table

```php
$orma($table)->createTable();
```

## add a column

```php
$orma->addColumn($column);
```
## insert

```php
$orma('table_name')->insert([
    'id' => 42,
]);
```