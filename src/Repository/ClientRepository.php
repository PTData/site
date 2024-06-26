<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }


    public function getAll()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            select
                c.id,
                c.function,
                c.name,
                c.job,
                c.datestart,
                c.dateend,
                group_concat(t.term) as tech,
                group_concat(t.awsome) as icon
            from client c
            inner join client_technology ct on ct.client_id = c.id
            inner join technology t on t.id = ct.technology_id
            group by c.id
            ';
        $stmt = $conn->prepare($sql);
        #$stmt->bindValue('category', $category->getId());
        $result = $stmt->executeQuery();
        return $result->fetchAll();
    }

    //    /**
    //     * @return Client[] Returns an array of Client objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Client
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
