<?php

namespace App\Repository;

use App\Entity\EmploymentSkill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EmploymentSkill>
 *
 * @method EmploymentSkill|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmploymentSkill|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmploymentSkill[]    findAll()
 * @method EmploymentSkill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmploymentSkillRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmploymentSkill::class);
    }

    public function save(EmploymentSkill $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EmploymentSkill $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return EmploymentSkill[] Returns an array of EmploymentSkill objects
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

//    public function findOneBySomeField($value): ?EmploymentSkill
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
