<?php

declare(strict_types=1);

namespace App\Application\Command\Handler;

use App\Application\Command\CreateFleetByUserCommand;
use App\Domain\Entity\Fleet;
use App\Domain\Repository\FleetRepositoryInterface;
use App\Domain\ValueObject\FleetId;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateFleetByUserCommandHandler
{
    public function __construct(
        private FleetRepositoryInterface $fleetRepository,
    ) {
    }

    public function __invoke(CreateFleetByUserCommand $createFleetByUserCommand): FleetId
    {
        $fleet = new Fleet(
            $createFleetByUserCommand->userId,
            new ArrayCollection(),
        );

        return $this->fleetRepository->save($fleet);
    }
}
