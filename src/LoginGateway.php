<?php
/**
 * This file contains the src/LoginGateway.php file for project AWS-0001-A.
 *
 * File information:
 * Project Name: AWS-0001-A
 * Section Name: src
 * File Name: LoginGateway.php
 * File Author: Troy L. Marker
 * Language: PHP 8.3
 *
 * @noinspection PhpUndefinedVariableInspection
 *
 * File Copyright: 06/29/2024
 */
declare(strict_types=1);

/**
 * Class LoginGateway
 *
 * This class handles the login functionality for users.
 */
class LoginGateway {

    private PDO $conn;

    /**
     * Class constructor.
     *
     * @param Database $database The database object.
     *
     * @return void
     */
    public function __construct(Database $database) {
        $this->conn = $database->getConnection();
    }

    /**
     * Logs in a user.
     *
     * @param string $id The ID of the application.
     * @param string $username The username of the user.
     * @param string $password The password of the user.
     *
     * @return array An array containing the login result.
     *               - If the login is successful, it will have the following keys:
     *                 - "code" (string): The status code for a successful login (e.g. "200").
     *                 - "appId" (string): The ID of the application.
     *                 - "userId" (string): The ID of the user.
     *                 - "colDepartment" (string): The department of the user.
     *                 - "colRole" (string): The role of the user.
     *               - If the username or password is invalid, it will have the following keys:
     *                 - "code" (string): The status code for an invalid login (e.g. "403").
     *                 - "message" (string): The error message for an invalid login (e.g. "Invalid username or password.").
     *               - If the user is unauthorized, it will have the following keys:
     *                 - "code" (string): The status code for an unauthorized login (e.g. "401").
     *                 - "message" (string): The error message for an unauthorized login (e.g. "Unauthorized.").
     */
    public function login(string $id, string $username, string $password): array {
        $sql = "SELECT * FROM tbl_users WHERE colName = :colName";
        $stmt = $this->conn->prepare(query: $sql);
        $stmt->bindParam(param: ':colName', var: $username);
        $stmt->execute();
        $user = $stmt->fetchAll(mode: PDO::FETCH_ASSOC);
        if (!$user) {
            $retval = [
                "code" => "403",
                "message" => "Invalid username or password."
            ];
        } elseif (password_verify($password, $user[0]['colPassword'])) {
            $sql = "SELECT * FROM tbl_applications WHERE colId = :colId";
            $stmt = $this->conn->prepare(query: $sql);
            $stmt->bindParam(param: ':colId', var: $id);
            $stmt->execute();
            $apps = $stmt->fetchAll(mode: PDO::FETCH_ASSOC);
            if (($user[0]['colDepartment'] == $apps[0]['colDepartment']) && ($user[0]['colRole'] == $apps[0]['colRole'])) {
                $retval = [
                    'code' => '200',
                    'appId' => $apps[0]['colId'],
                    'userId' => $user[0]['colId'],
                    'colDepartment' => $user[0]['colDepartment'],
                    'colRole' => $user[0]['colRole']
                ];
            } else {
                $retval = [
                    'code' => "401",
                    'message' => "Unauthorized."
                ];
            }
        }
        return $retval;
    }
}