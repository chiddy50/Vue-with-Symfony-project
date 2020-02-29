<?php

namespace App\Repository;

use App\Entity\Section;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Section|null find($id, $lockMode = null, $lockVersion = null)
 * @method Section|null findOneBy(array $criteria, array $orderBy = null)
 * @method Section[]    findAll()
 * @method Section[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Section::class);
    }

    // /**
    //  * @return Section[] Returns an array of Section objects
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
    public function findOneBySomeField($value): ?Section
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findIfSectionNameExists($section_name)
    {        
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "SELECT id FROM section WHERE section_name = :section_name";

        $stmt = $conn->prepare($sql);
        $stmt->execute(['section_name' => $section_name]);

        return $stmt;
    }

    public function findIfSectionCodeExists($section_code){
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = "SELECT id FROM section WHERE section_code = :section_code";

        $stmt = $conn->prepare($sql);
        $stmt->execute(['section_code' => $section_code]);

        return $stmt;
    }
}
