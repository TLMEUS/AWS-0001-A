<?php
/**
 * This file contains the src/LoginController.php file for project AWS-0001-A.
 *
 * File information:
 * Project Name: AWS-0001-A
 * Section Name: src
 * File Name: LoginController.php
 * File Author: Troy L. Marker
 * Language: PHP 8.3
 *
 * @noinspection ALL
 *
 * File Copyright: 06/22/2024
 */
declare(strict_types=1);

/**
 * Class LoginController
 *
 * This class handles the login request for the application.
 */
readonly class LoginController {

    public function __construct(private LoginGateway $gateway) {

    }

    /**
     * Processes the request based on the given method and id.
     *
     * @param string $method The request method.
     * @param string|null $id The id parameter. Can be null if missing.
     * @param string|null $username
     * @param string|null $password
     * @return void
     *
     * @throws Exception If an error occurs during processing.
     */
    public function processRequest(string $method, ?string $id, ?string $username, ?string $password): void {
        if ($username === null) {
            http_response_code(response_code: 406);
            echo json_encode([
                "code" => '406',
                "message" => 'Missing username parameter'
            ]);
        } elseif ($password === null) {
            http_response_code(response_code: 406);
            echo json_encode([
                "code" => '406',
                "message" => 'Missing password parameter'
            ]);
        } elseif ($id === null) {
            http_response_code(response_code: 406);
            echo json_encode([
                "code" => '406',
                "message" => 'Missing id parameter'
            ]);
        } else {
            switch ($method) {
                case 'GET':
                    $result = $this->gateway->login($id, $username, $password);
                    if($result['code'] == '200') {
                        echo json_encode($result);
                    }
                    break;
                default:
                    $this->respondMethodNotAllowed(allowed_methods: "GET");
                    break;
            }
        }
    }

    /**
     * Responds with a "Method Not Allowed" error and sets the allowed methods header.
     *
     * @param string $allowed_methods A comma-separated list of allowed methods.
     *
     * @return void
     *
     * @throws Exception If an error occurs during processing.
     */
    private function respondMethodNotAllowed(string $allowed_methods): void {
        http_response_code(response_code: 405);
        header(header: "Allow: $allowed_methods");
    }
}