<?php

declare(strict_types=1);

namespace Fulll\Domain\Exception;

final class FleetNotFoundException extends \RuntimeException
{
    public function __construct(string $fleetId, int $code = 0, \Throwable $previous = null)
    {
        $message = "Fleet with ID {$fleetId} not found.";
        parent::__construct($message, $code, $previous);
    }
}
