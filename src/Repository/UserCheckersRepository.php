<?php

namespace App\Repository;

use App\Entity\UserCheckers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserCheckers|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserCheckers|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserCheckers[]    findAll()
 * @method UserCheckers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserCheckersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserCheckers::class);
    }

    // /**
    //  * @return UserCheckers[] Returns an array of UserCheckers objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserCheckers
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
