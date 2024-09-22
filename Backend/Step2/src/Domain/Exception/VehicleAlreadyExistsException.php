<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use Symfony\Component\Messenger\Exception\ExceptionInterface;

final class VehicleAlreadyExistsException extends \RuntimeException implements ExceptionInterface
{
    public function __construct(string $plateNumber, int $code = 0, \Throwable $previous = null)
    {
        $message = "Vehicle with plate number {$plateNumber} already exists.";
        parent::__construct($message, $code, $previous);
    }
}
