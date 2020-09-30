<?php

namespace App\Repository;

use App\Entity\AppDownload;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AppDownload|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppDownload|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppDownload[]    findAll()
 * @method AppDownload[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppDownloadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppDownload::class);
    }

    // /**
    //  * @return AppDownload[] Returns an array of AppDownload objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AppDownload
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
