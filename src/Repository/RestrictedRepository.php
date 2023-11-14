<?php

namespace App\Repository;

use App\Entity\Restricted;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Restricted>
 *
 * @method Restricted|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restricted|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restricted[]    findAll()
 * @method Restricted[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestrictedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restricted::class);
    }

//    /**
//     * @return Restricted[] Returns an array of Restricted objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Restricted
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
