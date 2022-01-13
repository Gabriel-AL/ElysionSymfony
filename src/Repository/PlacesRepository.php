<?php

namespace App\Repository;

use App\Entity\Places;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Places|null find($id, $lockMode = null, $lockVersion = null)
 * @method Places|null findOneBy(array $criteria, array $orderBy = null)
 * @method Places[]    findAll()
 * @method Places[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlacesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Places::class);
    }

    public function findAllFromRoot() {
        $qb = $this->createQueryBuilder('p');

        $qb->leftJoin('p.rps', 'rp')
            ->leftJoin('rp.rPPosts', 'post');
        
        $qb->groupBy('p.id')
            ->orderBy('p.id, post.postedAt');


        return $qb->getQuery()->getResult();
    }


}
