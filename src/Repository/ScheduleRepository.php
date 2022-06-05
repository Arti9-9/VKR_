<?php

namespace App\Repository;

use App\Entity\Schedule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Schedule>
 *
 * @method Schedule|null find($id, $lockMode = null, $lockVersion = null)
 * @method Schedule|null findOneBy(array $criteria, array $orderBy = null)
 * @method Schedule[]    findAll()
 * @method Schedule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScheduleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Schedule::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Schedule $entity, bool $flush = true): void
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
    public function remove(Schedule $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    //нужно для того чтобы не записывать повторяющееся записи в БД
    public function findByAuditoriumDisciplineGroup($auditorium, $discipline, $group)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.auditorium = :auditorium')
            ->andWhere('l.discipline = :discipline')
            ->andWhere('l.groupName = :group')
            ->setParameter('auditorium', $auditorium)
            ->setParameter('discipline', $discipline)
            ->setParameter('group', $group)
            ->getQuery()
            ->getResult();
    }

    public function findOrderBy()
    {
        return $this->createQueryBuilder('l')
            ->orderBy('l.groupName', 'ASC')
            ->getQuery()
            ->getResult();
    }
    public function findByGroup($group)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.groupName LIKE :group')
            ->setParameter('group' ,$group . "-%")
            ->orderBy('l.groupName', 'ASC')
            ->getQuery()
            ->getResult();
    }
    public function findByGroupByDiscipline($group, $discipline)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.groupName LIKE :group')
            ->andWhere('l.discipline = :discipline')
            ->setParameter('group' ,$group . "-%")
            ->setParameter('discipline' , $discipline)
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return Schedule[] Returns an array of Schedule objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Schedule
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
