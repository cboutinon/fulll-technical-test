<?php

declare(strict_types=1);

namespace App\Application\Command\Handler;

use App\Application\Command\CreateFleetByUserCommand;
use App\Domain\Entity\Fleet;
use App\Domain\Repository\FleetRepositoryInterface;
use App\Domain\ValueObject\FleetId;

final readonly class CreateFleetByUserCommandHandler
{
    public function __construct(
        private FleetRepositoryInterface $fleetRepository,
    ) {
    }

    public function handle(CreateFleetByUserCommand $createFleetByUserCommand): FleetId
    {
        $fleet = new Fleet(
            $createFleetByUserCommand->user,
            []
        );

        return $this->fleetRepository->save($fleet);
    }
}
