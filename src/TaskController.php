<?php

class TaskController
{
    public function processRequest(string $method, ?string $id): void
    {
        if ($id === null) {

            switch ($method) {
                case 'GET':
                    echo "index";
                    break;
                case "POST":
                    echo "create";
                    break;
                default:
                    $this->respondMethodNotAllowed(allowed_methods: 'GET, POST');
            }
        } else {
            
            switch ($method) {
                case "GET":
                    echo "show $id";
                    break;
                case "PATCH":
                    echo "update $id";
                    break;
                case "DELETE":
                    echo "delete $id";
                    break;
                default:
                    $this->respondMethodNotAllowed(allowed_methods: 'GET, PATCH, DELETE');
            }
        }
    }

    private function respondMethodNotAllowed(string $allowed_methods): void {
        http_response_code(response_code: 405);
        header(header: "Allow: $allowed_methods");
    }
}










