<?php

namespace App\Repository;

use App\Entity\Aroma;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Aroma>
 *
 * @method Aroma|null find($id, $lockMode = null, $lockVersion = null)
 * @method Aroma|null findOneBy(array $criteria, array $orderBy = null)
 * @method Aroma[]    findAll()
 * @method Aroma[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AromaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Aroma::class);
    }

    public function add(Aroma $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Aroma $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
