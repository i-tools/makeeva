<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\GalleryEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GalleryEntity>
 *
 * @method GalleryEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method GalleryEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method GalleryEntity[]    findAll()
 * @method GalleryEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GalleryEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GalleryEntity::class);
    }

    public function add(GalleryEntity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(GalleryEntity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
