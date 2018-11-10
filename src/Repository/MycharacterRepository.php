<?php

namespace App\Repository;

use App\Entity\Mycharacter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Mycharacter|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mycharacter|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mycharacter[]    findAll()
 * @method Mycharacter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MycharacterRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Mycharacter::class);
    }

    // /**
    //  * @return Mycharacter[] Returns an array of Mycharacter objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Mycharacter
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
