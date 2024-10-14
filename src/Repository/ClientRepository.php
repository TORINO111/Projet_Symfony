<?php
namespace App\Repository;

use App\DTO\ClientSearch;
use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function findPaginated(int $page, int $limit, ClientSearch $searchParams): array
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);
    
        // Apply search filters if any
        if ($searchParams->getSurname()) {
            $queryBuilder->andWhere('c.surname LIKE :surname')
                        ->setParameter('surname', '%' . $searchParams->getSurname() . '%');
        }
    
        if ($searchParams->getTelephone()) {
            $queryBuilder->andWhere('c.telephone LIKE :telephone')
                        ->setParameter('telephone', '%' . $searchParams->getTelephone() . '%');
        }
    
        if ($searchParams->hasUser() !== null) {
            if ($searchParams->hasUser()) {
                $queryBuilder->innerJoin('c.user', 'u')
                            ->andWhere('u.id IS NOT NULL');
            } else {
                $queryBuilder->andWhere('c.user IS NULL');
            }
        }
    
        return $queryBuilder->getQuery()->getResult();
    }
    
    public function countAll(ClientSearch $searchParams = null): int
    {
        $queryBuilder = $this->createQueryBuilder('c');

        // Appliquer les mêmes filtres que dans findPaginated
        if ($searchParams) {
            if ($searchParams->getSurname()) {
                $queryBuilder->andWhere('c.surname LIKE :surname')
                            ->setParameter('surname', '%' . $searchParams->getSurname() . '%');
            }

            if ($searchParams->getTelephone()) {
                $queryBuilder->andWhere('c.telephone LIKE :telephone')
                            ->setParameter('telephone', '%' . $searchParams->getTelephone() . '%');
            }

            if ($searchParams->hasUser() !== null) {
                if ($searchParams->hasUser()) {
                    $queryBuilder->andWhere('c.user IS NOT NULL');
                } else {
                    $queryBuilder->andWhere('c.user IS NULL');
                }
            }
        }

        return (int) $queryBuilder->select('COUNT(c.id)')
                                ->getQuery()
                                ->getSingleScalarResult();
    }
}
