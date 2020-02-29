<?php

namespace App\Repository;

use App\Entity\Subjects;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Subjects|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subjects|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subjects[]    findAll()
 * @method Subjects[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubjectsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Subjects::class);
    }

    // /**
    //  * @return Subjects[] Returns an array of Subjects objects
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
    public function findOneBySomeField($value): ?Subjects
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function deleteSubject($id)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'DELETE FROM App\Entity\Subjects s WHERE s.id = :id'
        )
        ->setParameter('id', $id);
        $query->execute();
    }

    public function checkIfSubjectExist($subject_name)
    {        
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT id FROM subjects WHERE subject = :subject";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['subject' => $subject_name]);
        return $stmt;
    }

    public function checkIfSubjectCodeExist($subject_code){
        $conn = $this->getEntityManager()->getConnection();        
        $sql = "SELECT id FROM subjects WHERE subject_code = :subject_code";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['subject_code' => $subject_code]);
        return $stmt;
    }

    public function getStudentSubjects($id){
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "SELECT subjects.subject FROM
        subjects JOIN subject_group ON
        subjects.id = subject_group.subject_id
        WHERE subject_group.student_group_id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $subjects = [];
        while ($row = $stmt->fetch()) {
           $subjects[] = $row;
        }
        return $subjects;
    }

}
