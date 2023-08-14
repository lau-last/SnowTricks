<?php

namespace App\Repository;

use App\Entity\TrickId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TrickId>
 *
 * @method TrickId|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrickId|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrickId[]    findAll()
 * @method TrickId[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickIdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrickId::class);
    }

//    /**
//     * @return TrickId[] Returns an array of TrickId objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TrickId
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
