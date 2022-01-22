<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Notification;
use App\Domain\Repository\NotificationRepositoryInteface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Notification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notification[]    findAll()
 * @method Notification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationRepository extends ServiceEntityRepository implements NotificationRepositoryInteface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notification::class);
    }

    public function list(): array
    {
        return $this->findAll();
    }

    public function get(int $id): ?Notification
    {
        return $this->find($id);
    }

    public function save(Notification $notification): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($notification);
        $entityManager->flush();
    }
}
