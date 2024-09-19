<?php

declare(strict_types=1);

namespace Fulll\Domain\ValueObject;

final readonly class Location
{
    public function __construct(
        private float $latitude,
        private float $longitude,
    ) {
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }
}
