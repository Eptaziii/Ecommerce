<?php

namespace App\Repository;

use App\Entity\Vouloir;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vouloir>
 *
 * @method Vouloir|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vouloir|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vouloir[]    findAll()
 * @method Vouloir[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VouloirRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vouloir::class);
    }

//    /**
//     * @return Vouloir[] Returns an array of Vouloir objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Vouloir
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
