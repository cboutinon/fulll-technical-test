<?php

declare(strict_types=1);

namespace Fulll\App\Command\Handler;

use Fulll\App\Command\CreateFleetByUserCommand;
use Fulll\Domain\Entity\Fleet;
use Fulll\Domain\Repository\FleetRepositoryInterface;
use Fulll\Domain\ValueObject\FleetId;

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
