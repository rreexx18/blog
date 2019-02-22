<?php

namespace App\Repository;

use App\Entity\Posty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Posty|null find($id, $lockMode = null, $lockVersion = null)
 * @method Posty|null findOneBy(array $criteria, array $orderBy = null)
 * @method Posty[]    findAll()
 * @method Posty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Posty::class);
    }

    // /**
    //  * @return Posty[] Returns an array of Posty objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Posty
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
