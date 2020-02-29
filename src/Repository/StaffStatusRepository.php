<?php

namespace App\Repository;

use App\Entity\StaffStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StaffStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method StaffStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method StaffStatus[]    findAll()
 * @method StaffStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StaffStatusRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StaffStatus::class);
    }

    // /**
    //  * @return StaffStatus[] Returns an array of StaffStatus objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StaffStatus
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
