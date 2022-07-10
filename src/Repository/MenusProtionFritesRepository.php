<?php

namespace App\Repository;

use App\Entity\MenusProtionFrites;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MenusProtionFrites>
 *
 * @method MenusProtionFrites|null find($id, $lockMode = null, $lockVersion = null)
 * @method MenusProtionFrites|null findOneBy(array $criteria, array $orderBy = null)
 * @method MenusProtionFrites[]    findAll()
 * @method MenusProtionFrites[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenusProtionFritesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenusProtionFrites::class);
    }

    public function add(MenusProtionFrites $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MenusProtionFrites $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MenusProtionFrites[] Returns an array of MenusProtionFrites objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MenusProtionFrites
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
