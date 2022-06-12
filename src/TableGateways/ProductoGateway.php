<?php
namespace Src\TableGateways;

class ProductoGateway {

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $statement = "
            SELECT 
                id, nombre, sku, marca, costo, categoria_id
            FROM
                producto;
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
                id, nombre, sku, marca, costo, categoria_id
            FROM
                producto
            WHERE id = ?;
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
                (nombre, sku, marca, costo, categoria_id)
            VALUES
                (:nombre, :sku, :marca, :costo, :categoria_id);
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'nombre' => $input['nombre'],
                'sku'  => $input['sku'],
                'marca' => $input['marca'],
                'costo' => $input['costo'],
                'categoria_id' => $input['categoria_id'] ?? null,
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
                costo = :costo,
                categoria_id = :categoria_id
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => (int) $id,
                'nombre' => $input['nombre'],
                'sku'  => $input['sku'],
                'marca' => $input['marca'],
                'costo' => $input['costo'],
                'categoria_id' => $input['categoria_id'] ?? null,
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