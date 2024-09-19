<?php

declare(strict_types=1);

namespace Fulll\Domain\Exception;

final class VehicleAlreadyExistsException extends \RuntimeException
{
    public function __construct(string $plateNumber, int $code = 0, \Throwable $previous = null)
    {
        $message = "Vehicle with plate number {$plateNumber} already exists.";
        parent::__construct($message, $code, $previous);
    }
}
