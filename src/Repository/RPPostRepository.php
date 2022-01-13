<?php

namespace App\Repository;

use App\Entity\RPPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RPPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method RPPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method RPPost[]    findAll()
 * @method RPPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RPPostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RPPost::class);
    }

    // /**
    //  * @return RPPost[] Returns an array of RPPost objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RPPost
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
