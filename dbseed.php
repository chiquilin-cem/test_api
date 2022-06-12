<?php
require 'bootstrap.php';

$statement = <<<EOS
    CREATE TABLE IF NOT EXISTS producto (
        id INT NOT NULL AUTO_INCREMENT,
        nombre VARCHAR(100) NOT NULL,
        sku INT NOT NULL,
        marca VARCHAR(100) NOT NULL,
        costo DECIMAL(10,2),
        categoria_id INT DEFAULT NULL,
        PRIMARY KEY (id)
    ) ENGINE=INNODB;

    CREATE TABLE IF NOT EXISTS categoria (
        id INT NOT NULL AUTO_INCREMENT,
        categoria_nombre VARCHAR(100) NOT NULL,
        categoria_atributo VARCHAR(100) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=INNODB;

    INSERT INTO producto
        (id, nombre, sku, marca, costo, categoria_id)
    VALUES
        (1, 'Krasimir', 'Hristozov', null, null, null),
        (2, 'Maria', 'Hristozova', null, null, null),
        (3, 'Masha', 'Hristozova', 1, 2, null),
        (4, 'Jane', 'Smith', null, null, null),
        (5, 'John', 'Smith', null, null, null),
        (6, 'Richard', 'Smith', 4, 5, null),
        (7, 'Donna', 'Smith', 4, 5, null),
        (8, 'Josh', 'Harrelson', null, null, null),
        (9, 'Anna', 'Harrelson', 7, 8, null);
    
    INSERT INTO categoria
        (id, categoria_nombre, categoria_atributo)
    VALUES
        (1, 'Krasimir', 'Hristozov'),
        (2, 'Maria', 'Hristozova'),
        (3, 'Masha', 'Hristozova'),
        (4, 'Jane', 'Smith'),
        (5, 'John', 'Smith'),
        (6, 'Richard', 'Smith'),
        (7, 'Donna', 'Smith'),
        (8, 'Josh', 'Harrelson'),
        (9, 'Anna', 'Harrelson');
    
EOS;

try {
    $createTable = $dbConnection->exec($statement);
    echo "Success!\n";
} catch (\PDOException $e) {
    exit($e->getMessage());
}