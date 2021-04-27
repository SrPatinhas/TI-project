<?php
/**
 * Created by PhpStorm.
 * Project: TI
 * User: Miguel Cerejo
 * Date: 4/25/2021
 * Time: 5:54 PM
 *
 * File: ValidationException.php
 */
namespace App\Exception;

use RuntimeException;
use Throwable;

final class ValidationException extends RuntimeException
{
    private $errors;

    public function __construct(
        string $message,
        array $errors = [],
        int $code = 422,
        Throwable $previous = null
    ){
        parent::__construct($message, $code, $previous);

        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}