<?php

namespace App\Repository;

use App\Entity\AtributesForRequirement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AtributesForRequirement>
 *
 * @method AtributesForRequirement|null find($id, $lockMode = null, $lockVersion = null)
 * @method AtributesForRequirement|null findOneBy(array $criteria, array $orderBy = null)
 * @method AtributesForRequirement[]    findAll()
 * @method AtributesForRequirement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AtributesForRequirementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AtributesForRequirement::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(AtributesForRequirement $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(AtributesForRequirement $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findByRequirements($requirement)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.requipment = :requirement')
            ->setParameter('requirement', $requirement)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return AtributesForRequirement[] Returns an array of AtributesForRequirement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AtributesForRequirement
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
