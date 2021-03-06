<?php

namespace App\Repository;

use App\Entity\SubjectResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Parameter;

/**
 * @method SubjectResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubjectResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubjectResult[]    findAll()
 * @method SubjectResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubjectResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubjectResult::class);
    }

    // /**
    //  * @return SubjectResult[] Returns an array of SubjectResult objects
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
    public function findOneBySomeField($value): ?SubjectResult
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function checkSubjectResultExists($session, $id, $subject, $term)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT id FROM subject_result 
                WHERE session_id = :session_id
                AND student_id = :student_id
                AND term_id = :term
                AND subject_id = :subject_id";
        
        if($stmt = $conn->prepare($sql)){
            $stmt->bindParam(':subject_id', $subject);
            $stmt->bindParam(':session_id', $session);
            $stmt->bindParam(':term', $term);
            $stmt->bindParam(':student_id', $id);
          
            if($stmt->execute()){
                return $stmt;
            }
        }

        // return $this->createQueryBuilder('sr')
        //     ->where('sr.student = :student')
        //     ->andWhere('sr.session = :session')
        //     ->andWhere('sr.term = :term')
        //     ->andWhere('sr.subject = :subject')
        //     ->setParameters(new ArrayCollection(array(
        //         new Parameter('student', $id),
        //         new Parameter('session', $session),
        //         new Parameter('term', $term),
        //         new Parameter('subject', $subject)
        //     )))
        //     ->select('sr.id') or select('count(account.id)')
        //     ->getQuery()
        //     ->getResult();
        
        // to count use $count = getQuery()->getSingleScalarResult();
    }

 

    public function getSingleRecords($id, $session, $term){
        return $this->createQueryBuilder('sr')
            ->where('sr.student = :student')
            ->andWhere('sr.session = :session')
            ->andWhere('sr.term = :term')
            ->setParameters(new ArrayCollection(array(
                new Parameter('student', $id),
                new Parameter('session', $session),
                new Parameter('term', $term)
            )))
            ->getQuery()
            ->getResult();
    }
}
