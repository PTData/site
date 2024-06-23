<?php

namespace App\Repository;

use App\Entity\Car;
use App\Entity\Value;
use App\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
#use Doctrine\ORM\Query\AST\Join;
use Doctrine\ORM\Query\Expr\Join;
/**
 * @extends ServiceEntityRepository<Car>
 */
class CarRepository extends ServiceEntityRepository
{
    private $conn;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
        $this->conn = $this->getEntityManager()->getConnection();
    }

    public function getAll()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
            
            select 
                car.id,
                car.brand,
                car.model,
                value.`total_price`,
                image.`url`
            from car
            inner join value on value.car_id = car.id
            left join image on image.car_id = car.id
            ';
        $stmt = $conn->prepare($sql);
        #$stmt->bindValue('category', $category->getId());
        $result = $stmt->executeQuery();
        return $result->fetchAll();
    }

    //    /**
    //     * @return Car[] Returns an array of Car objects
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

    //    public function findOneBySomeField($value): ?Car
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
