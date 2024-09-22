<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Fleet;
use App\Domain\ValueObject\FleetId;

interface FleetRepositoryInterface
{
    public function findById(FleetId $fleetId): Fleet|null;
    public function save(Fleet $fleet): FleetId;
    public function delete(Fleet $fleet): void;
}
