<?php

namespace App\Repository;

use App\Entity\StudentAttendance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * @method StudentAttendance|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudentAttendance|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudentAttendance[]    findAll()
 * @method StudentAttendance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentAttendanceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StudentAttendance::class);
    }

    // /**
    //  * @return StudentAttendance[] Returns an array of StudentAttendance objects
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
    public function findOneBySomeField($value): ?StudentAttendance
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function checkAttendanceTaken($session, $id, $date)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT id FROM student_attendance 
                WHERE 
                session_id = :session_id
                AND students_id = :students_id
                AND date = :date";
        
        if($stmt = $conn->prepare($sql)){
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':session_id', $session);
            $stmt->bindParam(':students_id', $id);
          
            if($stmt->execute()){
                return $stmt;
            }
        }
    }

    public function fetchOneAttndance($session, $id, $date)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT * FROM student_attendance 
                WHERE 
                session_id = :session_id
                AND students_id = :students_id
                AND date = :date";
        
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':date', $param_date);
            $stmt->bindParam(':session_id', $param_session);
            $stmt->bindParam(':students_id', $param_student);
            $param_date = $date;
            $param_session = $session;
            $param_student = $id;
    
          
            if($stmt->execute()){
                return $stmt;
            }
        }
    }

    public function getMonthlyAttendance($session, $student, $month)
    {
        return $this->createQueryBuilder('s')
            ->where('s.students = :student')
            ->andWhere('s.session = :session')
            ->andWhere('s.month = :month')
            ->setParameters(new ArrayCollection(array(
                new Parameter('student', $student),
                new Parameter('month', $month),
                new Parameter('session', $session)
            )))
            ->getQuery()
            ->getResult();
        // to get just one result:
        // $product = $query->setMaxResults(1)->getOneOrNullResult();
    }
}
