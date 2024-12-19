<?php

namespace App\Repository;

use App\Entity\Classe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Classe>
 */
class ClasseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Classe::class);
    }

    public function findByStudent($etudiant): array
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.etudiants', 'e')
            ->andWhere('e.id = :etudiantId')
            ->setParameter('etudiantId', $etudiant->getId())
            ->getQuery()
            ->getResult();
    }
}