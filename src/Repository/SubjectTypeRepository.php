<?php

namespace App\Repository;

use App\Entity\SubjectType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SubjectType|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubjectType|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubjectType[]    findAll()
 * @method SubjectType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubjectTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SubjectType::class);
    }

    // /**
    //  * @return SubjectType[] Returns an array of SubjectType objects
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
    public function findOneBySomeField($value): ?SubjectType
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function checkSubjectTypeExists($subject_type)
    {        
        $conn = $this->getEntityManager()->getConnection();        
        $sql = "SELECT id FROM subject_type WHERE subject_type = :subject_type";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['subject_type' => $subject_type]);

        return $stmt;
    }
}
