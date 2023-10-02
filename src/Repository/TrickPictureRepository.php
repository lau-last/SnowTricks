<?php

namespace App\Repository;

use App\Entity\TrickPicture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TrickPicture>
 *
 * @method TrickPicture|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrickPicture|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrickPicture[]    findAll()
 * @method TrickPicture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickPictureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrickPicture::class);
    }

    //    /**
    //     * @return Picture[] Returns an array of Picture objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Picture
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
