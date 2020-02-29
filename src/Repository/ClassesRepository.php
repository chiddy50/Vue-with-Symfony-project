<?php

namespace App\Repository;


use App\Entity\Classes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Parameter;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Classes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Classes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Classes[]    findAll()
 * @method Classes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Classes::class);
    }


    public function findIfClassNameExists($class_name)
    {        
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "SELECT id FROM classes WHERE class_name = :class_name";

        $stmt = $conn->prepare($sql);
        $stmt->execute(['class_name' => $class_name]);

        return $stmt;

        // $rsm = new ResultSetMapping();
        // // build rsm here
        // $entityManager = $this->getEntityManager();
        // $query = $entityManager->createNativeQuery('SELECT id FROM classes WHERE class_name = ?', $rsm);
        // $query->setParameter(1, $class_name);

        // $stmt = $query->getResult();
        // return $stmt;
    }

    public function findIfClassCodeExists($class_code){
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "SELECT id FROM classes WHERE class_code = :class_code";

        $stmt = $conn->prepare($sql);
        $stmt->execute(['class_code' => $class_code]);

        return $stmt;

        // $qb = $this->createQueryBuilder('c');

        // $qb->select('c.id')
        // ->from('entity', 'c')
        // ->where('c.class_code = :class_code')
        // ->setParameter('class_name', $class_code);
        
        // $stmt = $qb->getQuery()->getResult();

        // return $stmt;
    }

    public function getStudents($id){
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "SELECT student_info.firstname,
                student_info.id,
                student_info.lastname,
                classes.class_name
                FROM classes JOIN student_info 
                ON classes.id = student_info.classes_id
                WHERE classes.id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $param_id);
        $param_id = $id;
        $stmt->execute();
        $data = [];
        while($row = $stmt->fetchAll()){
            $data[] = $row;
        }

        return $data[0];
    }


    public function deleteClass($id)
    {
        // return $this->createQueryBuilder('s')
        //     ->delete()
        //     ->where('s.student = :student')
        //     ->andWhere('s.session = :session')
        //     ->andWhere('s.term = :term')
        //     ->setParameters(new ArrayCollection(array(
        //         new Parameter('student', $student),
        //         new Parameter('term', $term),
        //         new Parameter('session', $session)
        //     )))
        //     ->getQuery()
        //     ->getResult();

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'DELETE FROM App\Entity\Classes c WHERE c.id = :id'
        )
        ->setParameter('id', $id);
        $query->execute();
        
       
    }
}
