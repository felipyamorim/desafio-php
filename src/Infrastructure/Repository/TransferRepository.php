<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Transfer;
use App\Domain\Repository\TransferRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Transfer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transfer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transfer[]    findAll()
 * @method Transfer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransferRepository extends ServiceEntityRepository implements TransferRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transfer::class);
    }

    public function list(): array
    {
        return $this->findAll();
    }

    public function get(int $id): ?Transfer
    {
        return $this->find($id);
    }

    public function save(Transfer $transfer): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($transfer);
        $entityManager->flush();
    }
}
