<?php

namespace App\Repository;

use App\Entity\Auditorium;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Auditorium>
 *
 * @method Auditorium|null find($id, $lockMode = null, $lockVersion = null)
 * @method Auditorium|null findOneBy(array $criteria, array $orderBy = null)
 * @method Auditorium[]    findAll()
 * @method Auditorium[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuditoriumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Auditorium::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Auditorium $entity, bool $flush = true): void
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
    public function remove(Auditorium $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    public function findByNumber($number)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.Number = :number')
            ->setParameter('number', $number)
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return AuditoriumFixture[] Returns an array of AuditoriumFixture objects
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

//    public function findOneBySomeField($value): ?AuditoriumFixture
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
