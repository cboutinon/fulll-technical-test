<?php

declare(strict_types=1);

namespace Fulll\Domain\Exception;

use Fulll\Domain\ValueObject\Location;

final class VehicleIsAlreadyParkedAtLocation extends \RuntimeException
{
    public function __construct(Location $location, int $code = 0, \Throwable $previous = null)
    {
        $message = "Vehicle is already parked at location : {$location->getLatitude()},{$location->getLongitude()}.";
        parent::__construct($message, $code, $previous);
    }
}
