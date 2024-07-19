<?php

namespace App\Repository;

use App\Entity\Stay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class StayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stay::class);
    }

    /**
     * Find stays by date range
     *
     * @param string $startDate
     * @param string $endDate
     * @return Stay[]
     */
    public function findByDateRange(string $startDate, string $endDate): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.startDate <= :endDate')
            ->andWhere('s.endDate >= :startDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->getQuery()
            ->getResult();
    }

    public function findByDateRangeByUser(string $startDate, string $endDate, int $userId): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.user = :userId')
            ->andWhere('s.startDate <= :endDate')
            ->andWhere('s.endDate >= :startDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }
}
