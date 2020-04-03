<?php

namespace App\Repository;

use App\Entity\ExamResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ExamResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExamResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExamResult[]    findAll()
 * @method ExamResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExamResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExamResult::class);
    }

    // /**
    //  * @return ExamResult[] Returns an array of ExamResult objects
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
    public function findOneBySomeField($value): ?ExamResult
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function checkExamResultExists($session, $term, $student, $subject, $class, $section)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT id FROM exam_result 
                WHERE session_id = :session_id
                AND student_id = :student_id
                AND term_id = :term
                AND class_id = :class
                AND section_id = :section
                AND subject_id = :subject_id";
        
        if($stmt = $conn->prepare($sql)){
            $stmt->bindParam(':subject_id', $subject);
            $stmt->bindParam(':session_id', $session);
            $stmt->bindParam(':term', $term);
            $stmt->bindParam(':class', $class);
            $stmt->bindParam(':section', $section);
            $stmt->bindParam(':student_id', $student);
          
            if($stmt->execute()){
                return $stmt;
            }
        }
    }
}
