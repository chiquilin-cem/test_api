<?php
namespace Src\tableGateways;

class ProductoGateway {

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        //Se mostrará el precio de venta, aplicando los siguientes márgenes de utilidad: 
        //Televisor 35%, Laptops 40% y Zapatos 30%. Estos porcentajes estarán definidos en el código fuente.
        $statement = "
            SELECT 
                a.id id, a.nombre nombre, a.sku sku, a.marca marca, a.costo costo, b.categoria_nombre categoria_nombre, b.categoria_atributo categoria_atributo, 
                case 
                    when a.nombre like '%Televisor%' then (a.costo*1.35)
                    when a.nombre like '%Laptop%' then (a.costo*1.4)
                    when a.nombre like '%Zapato%' then (a.costo*1.3)
                end as precio
            FROM
                producto a, categoria b, prodcat c
            WHERE
                a.id = c.producto_id AND
                b.id = c.categoria_id;
        ";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function find($id)
    {
        $statement = "
                SELECT 
                a.id id, a.nombre nombre, a.sku sku, a.marca marca, a.costo costo, b.categoria_nombre categoria_nombre, b.categoria_atributo categoria_atributo, 
                case 
                    when a.nombre like '%Televisor%' then (a.costo*1.35)
                    when a.nombre like '%Laptop%' then (a.costo*1.4)
                    when a.nombre like '%Zapato%' then (a.costo*1.3)
                end as precio
            FROM
                producto a, categoria b, prodcat c
            WHERE
                a.id = c.producto_id AND
                b.id = c.categoria_id AND id = ?;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function insert(Array $input)
    {
        $statement = "
            INSERT INTO producto 
                (nombre, sku, marca, costo)
            VALUES
                (:nombre, :sku, :marca, :costo);
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'nombre' => $input['nombre'],
                'sku'  => $input['sku'],
                'marca' => $input['marca'],
                'costo' => $input['costo']
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function update($id, Array $input)
    {
        $statement = "
            UPDATE producto
            SET 
                nombre = :nombre,
                sku  = :sku,
                marca = :marca,
                costo = :costo
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => (int) $id,
                'nombre' => $input['nombre'],
                'sku'  => $input['sku'],
                'marca' => $input['marca'],
                'costo' => $input['costo']
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function delete($id)
    {
        $statement = "
            DELETE FROM producto
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array('id' => $id));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }
}