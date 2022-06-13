<?php

namespace App\Repository;

use App\Entity\Requirements;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Requirements>
 *
 * @method Requirements|null find($id, $lockMode = null, $lockVersion = null)
 * @method Requirements|null findOneBy(array $criteria, array $orderBy = null)
 * @method Requirements[]    findAll()
 * @method Requirements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RequirementsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Requirements::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Requirements $entity, bool $flush = true): void
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
    public function remove(Requirements $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findByCurriculum($curriculum)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.curriculum = :curriculum')
            ->setParameter('curriculum', $curriculum)
            ->getQuery()
            ->getResult();
    }
    public function findByCurriculumDiscipline($curriculum, $discipline)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.curriculum = :curriculum')
            ->andWhere('l.discipline = :discipline')
            ->setParameter('curriculum', $curriculum)
            ->setParameter('discipline', $discipline)
            ->getQuery()
            ->getResult();
    }


//    /**
//     * @return Requirements[] Returns an array of Requirements objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Requirements
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
