<?php
/**
 * This file contains the public/index.php file for project AWS-0001-A.
 *
 * File information:
 * Project Name: AWS-0001-A
 * Section Name: api
 * File Name: index.php
 * File Author: Troy L. Marker
 * Language: PHP 8.3
 *
 * File Copyright: 06/22/2024
 */
declare(strict_types=1);

define("ROOT_PATH", dirname(path: __DIR__));
spl_autoload_register(callback: function (string $class_name) {
    require ROOT_PATH . "/src/" . str_replace(search: "\\", replace: "/", subject: $class_name) . ".php";
});
$dotenv = new DotEnv;
$dotenv->load(path: dirname(path: ROOT_PATH) . "/RWS-0001-A/config/.env");
set_exception_handler(callback: "\\ErrorHandler::handleException");
$path = parse_url($_SERVER["REQUEST_URI"], component: PHP_URL_PATH);
$parts = explode(separator: "/", string: $path);
$resource = $parts[1];
$id       = $parts[2] ?? null;
$username = $parts[3] ?? null;
$password = $parts[4] ?? null;
header(header: 'Content-Type: application/json; charset=UTF-8');
if ($resource != "login") {
    http_response_code(response_code: 404);
    echo json_encode([
        "code" => '404',
        "message" => 'Page Not Found'
    ]);
    exit;
}
$database = new Database($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
$login_gateway = new LoginGateway($database);
$controller = new LoginController($login_gateway);
try {
    $controller->processRequest($_SERVER['REQUEST_METHOD'], $id, $username, $password);
} catch (Exception $e) {
}









