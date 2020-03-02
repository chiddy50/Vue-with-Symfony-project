<?php

namespace App\Repository;

use App\Entity\Exam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Exam|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exam|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exam[]    findAll()
 * @method Exam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exam::class);
    }

    public function liveSearch($search)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT e
            FROM App\Entity\Exam e
            WHERE e.exam_name LIKE :search'            
        )->setParameter('search', '%'.$search.'%');
        
        // returns an array of Exam objects
        return $query->getResult();
    }

    public function examSearch($subject, $session, $term, $class, $section, $student_group)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT e
            FROM App\Entity\Exam e
            WHERE e.subject = :subject OR           
            e.session = :session OR           
            e.term = :term OR
            e.classes = :classes OR
            e.section = :section OR
            e.student_group = :student_group'           
        )->setParameters(array(
            'subject' => $subject,
            'session' => $session,
            'section' => $section,
            'term' => $term,
            'classes' => $class,
            'student_group' => $student_group
        ));
        // returns an array of Exam objects
        return $query->getResult();
    }
}
