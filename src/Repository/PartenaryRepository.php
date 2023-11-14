<?php

namespace App\Repository;

use App\Entity\Partenary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Partenary>
 *
 * @method Partenary|null find($id, $lockMode = null, $lockVersion = null)
 * @method Partenary|null findOneBy(array $criteria, array $orderBy = null)
 * @method Partenary[]    findAll()
 * @method Partenary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartenaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Partenary::class);
    }

//    /**
//     * @return Partenary[] Returns an array of Partenary objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Partenary
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
