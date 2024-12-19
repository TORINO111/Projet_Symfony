<?php

namespace App\Repository;

use App\Entity\Cours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cours>
 */
class CoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cours::class);
    }

    public function findByNiveau($niveau): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.niveau = :niveau')
            ->setParameter('niveau', $niveau)
            ->getQuery()
            ->getResult();
    }

    public function findByClasse($classe): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.classe = :classe')
            ->setParameter('classe', $classe)
            ->getQuery()
            ->getResult();
    }

    public function findByProfesseur($professeur): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.professeur = :professeur')
            ->setParameter('professeur', $professeur)
            ->getQuery()
            ->getResult();
    }

    public function findSessions($cours): array
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.sessions', 's')
            ->andWhere('c.id = :coursId')
            ->setParameter('coursId', $cours->getId())
            ->getQuery()
            ->getResult();
    }
}