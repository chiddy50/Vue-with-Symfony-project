<?php

namespace App\Repository;

use App\Entity\StaffInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StaffInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method StaffInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method StaffInfo[]    findAll()
 * @method StaffInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StaffInfoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StaffInfo::class);
    }

    // /**
    //  * @return StaffInfo[] Returns an array of StaffInfo objects
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
    public function findOneBySomeField($value): ?StaffInfo
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
