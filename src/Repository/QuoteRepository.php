<?php

namespace App\Repository;

use App\Entity\Quote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Quote>
 */
class QuoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quote::class);
    }

    public function findAllOrderedByMovieName(): array
    {
        return $this->createQueryBuilder('q')
            ->leftJoin('q.Movie', 'm')
            ->addSelect('m')
            ->orderBy('m.name', 'ASC')
            ->addOrderBy('q.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
    public function findByMovieName(string $movieName): array
    {
        return $this->createQueryBuilder('q')
            ->leftJoin('q.Movie', 'm')
            ->addSelect('m')
            ->where('m.name LIKE :movieName')
            ->setParameter('movieName', '%'.$movieName.'%')
            ->getQuery()
            ->getResult();
    }
}

    //    /**
    //     * @return Quote[] Returns an array of Quote objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('q.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Q
