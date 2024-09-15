<?php
/**
 * This file contains the src/Database.php file for project AWS-0001-A.
 *
 * File information:
 * Project Name: AWS-0001-A
 * Section Name: src
 * File Name: Database.php
 * File Author: Troy L. Marker
 * Language: PHP 8.3
 *
 * File Copyright: 06/22/2024
 */
declare(strict_types=1);

/**
 * Class Database provides functionality for connecting to a database.
 */
class Database {

    /**
     * Class constructor.
     *
     * @param string $host The host name or IP address of the database server.
     * @param string $name The name of the database.
     * @param string $user The username used to connect to the database server.
     * @param string $pass The password used to connect to the database server.
     *
     * @return void
     */
    public function __construct(
        private string $host,
        private string $name,
        private string $user,
        private string $pass
    ) {

    }

    /**
     * Gets a connection to the database.
     *
     * @return PDO The database connection.
     */
    public function getConnection(): PDO {
        $dsn = "mysql:host={$this->host};dbname={$this->name};charset=utf8";
        return new PDO($dsn, $this->user, $this->pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}