<?php

namespace App\Repository;

use App\Entity\VideoCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VideoCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method VideoCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method VideoCategory[]    findAll()
 * @method VideoCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VideoCategory::class);
    }

    // /**
    //  * @return VideoCategory[] Returns an array of VideoCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VideoCategory
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
