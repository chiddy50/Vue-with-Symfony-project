<?php

namespace App\Repository;

use App\Entity\StudentGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StudentGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudentGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudentGroup[]    findAll()
 * @method StudentGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentGroupRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StudentGroup::class);
    }

    // /**
    //  * @return StudentGroup[] Returns an array of StudentGroup objects
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
    public function findOneBySomeField($value): ?StudentGroup
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findIfClassCodeExists($group_id, $subject_id){
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "SELECT student_group_id, subject_id
                FROM subject_group WHERE 
                student_group_id = :student_group_id
                AND 
                subject_id = :subject_id";

        $stmt = $conn->prepare($sql);
        $stmt->execute(['student_group_id' => $group_id, 'subject_id' => $subject_id]);

        return $stmt;

        // $qb = $this->createQueryBuilder('c');

        // $qb->select('c.id')
        // ->from('entity', 'c')
        // ->where('c.class_code = :class_code')
        // ->setParameter('class_name', $class_code);
        
        // $stmt = $qb->getQuery()->getResult();

        // return $stmt;
    }

    public function getGroupSubjects(){
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "SELECT * FROM student_group
                JOIN subject_group ON
                student_group.id = subject_group.student_group_id
                JOIN subjects ON
                subject_group.subject_id = subjects.id";

        $result = $conn->query($sql);

        $result->execute();
        $data = [];
        while ($row = $result->fetch()) {
            $data[] = $row;
        }
        return $data;
    }
}
