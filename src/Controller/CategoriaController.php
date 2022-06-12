<?php
namespace Src\controller;

use Src\tableGateways\categoriaGateway;

class categoriaController {

    private $db;
    private $requestMethod;
    private $userId;

    private $categoriaGateway;

    public function __construct($db, $requestMethod, $userId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;

        $this->categoriaGateway = new categoriaGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->userId) {
                    $response = $this->getCategoria($this->userId);
                } else {
                    $response = $this->getAllCategorias();
                };
                break;
            case 'POST':
                $response = $this->createCategoriaFromRequest();
                break;
            case 'PUT':
                $response = $this->updateCategoriaFromRequest($this->userId);
                break;
            case 'DELETE':
                $response = $this->deleteCategoria($this->userId);
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

    private function getAllCategorias()
    {
        $result = $this->categoriaGateway->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getCategoria($id)
    {
        $result = $this->categoriaGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function createCategoriaFromRequest()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateCategoria($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->categoriaGateway->insert($input);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    private function updateCategoriaFromRequest($id)
    {
        $result = $this->categoriaGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateCategoria($input)) {
            return $this->unprocessableEntityResponse();
        }
        $this->categoriaGateway->update($id, $input);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function deleteCategoria($id)
    {
        $result = $this->categoriaGateway->find($id);
        if (! $result) {
            return $this->notFoundResponse();
        }
        $this->categoriaGateway->delete($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function validateCategoria($input)
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