<?php

namespace App\Repository;

use App\Entity\ClassAttendance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ClassAttendance|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClassAttendance|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClassAttendance[]    findAll()
 * @method ClassAttendance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassAttendanceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ClassAttendance::class);
    }

    // /**
    //  * @return ClassAttendance[] Returns an array of ClassAttendance objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ClassAttendance
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function checkAttendanceTaken($session, $id, $date, $subject)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT id FROM class_attendance 
                WHERE 
                session_id = :session_id
                AND student_id = :students_id
                AND date = :date 
                AND subject_id = :subject";
        
        if($stmt = $conn->prepare($sql)){

            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':session_id', $session);
            $stmt->bindParam(':students_id', $id);
            $stmt->bindParam(':subject', $subject);
          
            if($stmt->execute()){
                return $stmt;
            }
        }
    }

}
