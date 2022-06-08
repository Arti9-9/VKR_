<?php

namespace App\Repository;

use App\Entity\Equipment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Equipment>
 *
 * @method Equipment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Equipment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Equipment[]    findAll()
 * @method Equipment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Equipment::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Equipment $entity, bool $flush = true): void
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
    public function remove(Equipment $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findByAuditorium($auditorium)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.auditorium = :auditorium')
            ->setParameter('auditorium', $auditorium)
            ->getQuery()
            ->getResult();
    }

    public function findByAuditoriumCategory($auditorium, $category)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.auditorium = :auditorium')
            ->andWhere('l.Category = :category')
            ->setParameter('auditorium', $auditorium)
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult();
    }

    public function findAnExistingRecord($auditorium, $category, $name)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.auditorium = :auditorium')
            ->andWhere('l.Category = :category')
            ->andWhere('l.Name = :name')
            ->setParameter('auditorium', $auditorium)
            ->setParameter('category', $category)
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return Equipment[] Returns an array of Equipment objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Equipment
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
