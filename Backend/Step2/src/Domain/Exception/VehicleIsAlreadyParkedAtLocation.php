<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use App\Domain\ValueObject\Location;
use Symfony\Component\Messenger\Exception\ExceptionInterface;

final class VehicleIsAlreadyParkedAtLocation extends \RuntimeException implements ExceptionInterface
{
    public function __construct(Location $location, int $code = 0, \Throwable $previous = null)
    {
        $message = "Vehicle is already parked at location : {$location->getLatitude()},{$location->getLongitude()}.";
        parent::__construct($message, $code, $previous);
    }
}
