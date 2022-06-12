<?php
require 'bootstrap.php';

$statement = <<<EOS
    CREATE TABLE IF NOT EXISTS producto (
        id INT NOT NULL AUTO_INCREMENT,
        nombre VARCHAR(100) NOT NULL,
        sku INT NOT NULL,
        marca VARCHAR(100) NOT NULL,
        costo DECIMAL(10,2),
        PRIMARY KEY (id)
    ) ENGINE=INNODB;

    CREATE TABLE IF NOT EXISTS categoria (
        id INT NOT NULL AUTO_INCREMENT,
        categoria_nombre VARCHAR(100) NOT NULL,
        categoria_atributo VARCHAR(100) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=INNODB;

    CREATE TABLE IF NOT EXISTS prodcat (
        id INT NOT NULL AUTO_INCREMENT,
        producto_id INT NOT NULL,
        categoria_id INT NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=INNODB;

    INSERT INTO producto
        (id, nombre, sku, marca, costo)
    VALUES
        (1, 'Televisor', '120001', 'TCL', '3500'),
        (2, 'Televisor', '120002', 'ASUS', '4500'),
        (3, 'Televisor', '120003', 'TCL', '3500'),
        (4, 'Laptop', '130001', 'Huawei', '10500'),
        (5, 'Laptop', '130002', 'Dell', '13500'),
        (6, 'Laptop', '130003', 'Lenovo', '23500'),
        (7, 'Zapato', '150001', 'BubleGummers', '500'),
        (8, 'Zapato', '150002', 'Nike', '1000'),
        (9, 'Zapato', '150003', 'Adidas', '1200');
    
    INSERT INTO categoria
        (id, categoria_nombre, categoria_atributo)
    VALUES
        (1, 'Tipo de Pantalla', 'LED'),
        (2, 'Tipo de Pantalla', 'LCD'),
        (3, 'Tipo de Pantalla', 'OLED'),
        (4, 'Tamaño de Pantalla', '40 Pulgadas'),
        (5, 'Tamaño de Pantalla', '50 Pulgadas'),
        (6, 'Tamaño de Pantalla', '60 Pulgadas'),
        (7, 'Procesador', 'Intel'),
        (8, 'Procesador', 'AMD'),
        (9, 'Memoria RAM', '8GB'),
        (10, 'Memoria RAM', '12GB'),
        (11, 'Memoria RAM', '16GB'),
        (12, 'Material', 'Piel'),
        (13, 'Material', 'Plastico'),
        (14, 'Numero', '16'),
        (15, 'Numero', '18'),
        (16, 'Numero', '20'),
        (17, 'Numero', '22'),
        (18, 'Numero', '24'),
        (19, 'Numero', '26'),
        (20, 'Numero', '28'),
        (21, 'Numero', '30');

    INSERT INTO prodcat
        (id, producto_id, categoria_id)
    VALUES
        (1,'1','1'),
        (2,'1','4'),
        (3,'2','2'),
        (4,'2','4'),
        (5,'3','3'),
        (6,'3','6'),
        (7,'4','7'),
        (8,'4','10'),
        (9,'5','7'),
        (10,'5','11'),
        (11,'6','8'),
        (12,'6','9'),
        (13,'7','13'),
        (14,'7','19'),
        (15,'8','12'),
        (16,'8','21'),
        (17,'9','12'),
        (18,'9','21');
    
EOS;

try {
    $createTable = $dbConnection->exec($statement);
    echo "Success!\n";
} catch (\PDOException $e) {
    exit($e->getMessage());
}