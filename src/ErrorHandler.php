<?php
/**
 * This file contains the src/ErrorHandler.php file for project AWS-0001-A.
 *
 * File information:
 * Project Name: AWS-0001-A
 * Section Name: Source
 * File Name: ErrorHandler.php
 * File Author: Troy L. Marker
 * Language: PHP 8.3
 *
 * File Copyright: 06/22/2024
 */
declare(strict_types=1);

/**
 * Class ErrorHandler
 *
 * The ErrorHandler class handles exceptions and provides a standardized way of
 * returning error information as JSON response with HTTP status code 500.
 */
class ErrorHandler {
    public static function handleException(Throwable $exception): void {
        http_response_code(response_code: 500);
        echo json_encode([
            "code" => $exception->getCode(),
            "message" => $exception->getMessage(),
            "file" => $exception->getFile(),
            "line" => $exception->getLine()
        ]);
    }
}