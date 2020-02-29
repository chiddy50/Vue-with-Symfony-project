<?php

namespace App\Repository;

use App\Entity\StudentInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StudentInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudentInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudentInfo[]    findAll()
 * @method StudentInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentInfoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StudentInfo::class);
    }


    public function findOneByIdJoinedToStudent($parent_id)
    {
        return $this->createQueryBuilder('c')
            // p.category refers to the "category" property on product
            ->innerJoin('s.parent', 'p')
            // selects all the category data to avoid the query
            ->addSelect('p')
            ->andWhere('s.id = :id')
            ->setParameter('id', $parent_id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findIfRollExists($roll_no){
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "SELECT id FROM student_info WHERE roll_no = :roll_no";

        $stmt = $conn->prepare($sql);
        $stmt->execute(['roll_no' => $roll_no]);

        return $stmt;
    }

    public function studentCount(){
        $qb = $this->createQueryBuilder('s');
        $qb->select('s.id');        
        $count = $qb->getQuery()->getResult();

        return count($count);
    }

    public function maleGender($gender){
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "SELECT student_info.id FROM 
                student_info JOIN gender 
                ON student_info.gender_id = gender.id
                WHERE gender.id = :gender";

        $stmt = $conn->prepare($sql);
        $stmt->execute(['gender' => $gender]);
        $count = [];
        while ($row = $stmt->fetch()) {
           $count[] = $row;
        }
        return $count;
    }   

    public function femaleGender($gender){
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "SELECT student_info.id FROM 
                student_info JOIN gender 
                ON student_info.gender_id = gender.id
                WHERE gender.id = :gender";

        $stmt = $conn->prepare($sql);
        $stmt->execute(['gender' => $gender]);
        $count = [];
        while ($row = $stmt->fetch()) {
           $count[] = $row;
        }
        return $count;
    }   

 
    public function liveSearch($name)
    {
        // $qb = $this->getEntityManager();
        // $sql = $qb->createQuery('SELECT s, c FROM App\Entity\StudentInfo s JOIN s.classes c');
        // $students = $sql->execute();
        // return $students;

        // $conn = $this->getEntityManager()->getConnection();

        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT s
            FROM App\Entity\StudentInfo s
            WHERE s.firstname LIKE :name
            OR s.lastname LIKE :name
            OR s.roll_no LIKE :name'            
        )->setParameter('name', '%'.$name.'%');
        

        // returns an array of Product objects
        return $query->getResult();

    }

    public function removeStudent($id){
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "DELETE FROM student_info WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt;
    }



    
}
