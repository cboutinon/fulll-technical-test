<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Entity\Fleet;
use App\Domain\Repository\FleetRepositoryInterface;
use App\Domain\ValueObject\FleetId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fleet>
 */
final class DoctrineFleetRepository extends ServiceEntityRepository implements FleetRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fleet::class);
    }

    public function findById(FleetId $fleetId): Fleet|null
    {
        /** @var Fleet|null $fleet */
        $fleet = $this->findOneBy(['id' => $fleetId]);
        return $fleet;
    }

    public function save(Fleet $fleet): FleetId
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($fleet);
        $entityManager->flush();

        return $fleet->getId();
    }

    public function delete(Fleet $fleet): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($fleet);
        $entityManager->flush();
    }
}
