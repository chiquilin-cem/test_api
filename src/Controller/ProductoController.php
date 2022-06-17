<?php
namespace Src\Controller;

use Src\tableGateways\productoGateway;

class productoController {

    private $db;
    private $requestMethod;
    private $productoId;

    private $productoGateway;

    public function __construct($db, $requestMethod, $productoId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->productoId = $productoId;

        $this->productoGateway = new productoGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->productoId) {
                    $response = $this->getProducto($this->productoId);
                } else {
                    $response = $this->getAllProductos();
                };
                break;
            case 'POST':
                $response = $this->createProductoFromRequest();
                break;
            case 'PUT':
                echo "Put call";
                $response = $this->updateProductoFromRequest($this->productoId);
                break;
            case 'DELETE':
                $response = $this->deleteProducto($this->productoId);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function getAllProductos()
    {
        $result = $this->productoGateway->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getProducto($id)
    {
        $result = $this->productoGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function createProductoFromRequest()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateproducto($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->productoGateway->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    private function updateProductoFromRequest($id)
    {
        echo "Validamos el id: ".$id;
        $result = $this->productoGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateproducto($input)) {
            return $this->unprocessableEntityResponse();
        }
        echo "Validado vamos a modiciar";
        $this->productoGateway->update($id, $input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function deleteProducto($id)
    {
        $result = $this->productoGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $this->productoGateway->delete($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function validateproducto($input)
    {
        if (! isset($input['nombre'])) {
            return false;
        }
        if (! isset($input['sku'])) {
            return false;
        }
        return true;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}