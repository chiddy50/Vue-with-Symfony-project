<?php

namespace App\Repository;

use App\Entity\Parents;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Parents|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parents|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parents[]    findAll()
 * @method Parents[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParentsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Parents::class);
    }

    // /**
    //  * @return Parents[] Returns an array of Parents objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Parents
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function countParents(){
        // $conn = $this->getEntityManager()->getConnection();

        //NATIVE SQL QUERY
        // $sql = 'SELECT COUNT(*) FROM parents';
        // $stmt = $conn->prepare($sql);
        // $stmt->execute();
        // $count = $stmt->fetch();
        // // returns an array of arrays (i.e. a raw data set)
        // return $count;

        //DOCTRINE QUERY LANGUAGE
        // $entityManager = $this->getEntityManager();
        // $query = $entityManager->createQuery(
        //     'SELECT COUNT(p.id)
        //     FROM App\Entity\Parents p
        //     '
        // );
        // $count = $query->getResult();
        // return $count;


        //SQL QUERY BUILDER
        $qb = $this->createQueryBuilder('p');

        $qb->select('p.id');
        
        $count = $qb->getQuery()->getResult();

        return count($count);
    }
}
