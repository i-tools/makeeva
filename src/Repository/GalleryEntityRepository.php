<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\GalleriedEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GalleriedEntity>
 *
 * @method GalleriedEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method GalleriedEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method GalleriedEntity[]    findAll()
 * @method GalleriedEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GalleriedEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GalleriedEntity::class);
    }

    public function add(GalleriedEntity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(GalleriedEntity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
