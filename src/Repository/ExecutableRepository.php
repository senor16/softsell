<?php

namespace App\Repository;

use App\Entity\Executable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Executable|null find($id, $lockMode = null, $lockVersion = null)
 * @method Executable|null findOneBy(array $criteria, array $orderBy = null)
 * @method Executable[]    findAll()
 * @method Executable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExecutableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Executable::class);
    }

    // /**
    //  * @return Executable[] Returns an array of Executable objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Executable
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
