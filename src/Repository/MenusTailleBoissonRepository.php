<?php

namespace App\Repository;

use App\Entity\MenusTailleBoisson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MenusTailleBoisson>
 *
 * @method MenusTailleBoisson|null find($id, $lockMode = null, $lockVersion = null)
 * @method MenusTailleBoisson|null findOneBy(array $criteria, array $orderBy = null)
 * @method MenusTailleBoisson[]    findAll()
 * @method MenusTailleBoisson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenusTailleBoissonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenusTailleBoisson::class);
    }

    public function add(MenusTailleBoisson $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MenusTailleBoisson $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MenusTailleBoisson[] Returns an array of MenusTailleBoisson objects
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

//    public function findOneBySomeField($value): ?MenusTailleBoisson
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
