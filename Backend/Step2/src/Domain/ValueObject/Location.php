<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final readonly class Location
{
    #[ORM\Column(type: 'float', nullable: true)]
    private float|null $latitude;
    #[ORM\Column(type: 'float', nullable: true)]
    private float|null $longitude;
    #[ORM\Column(type: 'float', nullable: true)]
    private float|null $altitude;

    public function __construct(
        float|null $latitude,
        float|null $longitude,
        float|null $altitude
    ) {
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->altitude = $altitude;
    }

    public function getLatitude(): float|null
    {
        return $this->latitude;
    }

    public function getLongitude(): float|null
    {
        return $this->longitude;
    }

    public function getAltitude(): ?float
    {
        return $this->altitude;
    }
}
