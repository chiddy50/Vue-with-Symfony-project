<?php

namespace App\Repository;

use App\Entity\Term;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Term|null find($id, $lockMode = null, $lockVersion = null)
 * @method Term|null findOneBy(array $criteria, array $orderBy = null)
 * @method Term[]    findAll()
 * @method Term[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TermRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Term::class);
    }

    public function findIfCodeExists($term_code)
    {        
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "SELECT id FROM term WHERE term_code = :term_code";

        $stmt = $conn->prepare($sql);
        $stmt->execute(['term_code' => $term_code]);

        return $stmt;
    }

    public function findIfDescriptionExists($term_description){
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "SELECT id FROM term WHERE term_description = :term_description";

        $stmt = $conn->prepare($sql);
        $stmt->execute(['term_description' => $term_description]);
        return $stmt;
    }
}
