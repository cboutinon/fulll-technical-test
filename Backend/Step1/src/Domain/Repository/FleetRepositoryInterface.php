<?php

declare(strict_types=1);

namespace Fulll\Domain\Repository;

use Fulll\Domain\Entity\Fleet;
use Fulll\Domain\ValueObject\FleetId;

interface FleetRepositoryInterface
{
    public function findById(FleetId $fleetId): Fleet|null;

    /**
     * @return Fleet[]
     */
    public function findByUser(string $user): array;

    public function save(Fleet $fleet): FleetId;
}
