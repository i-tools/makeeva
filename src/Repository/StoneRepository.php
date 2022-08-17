<?php

namespace App\Repository;

use App\Entity\Stone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Stone>
 *
 * @method Stone|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stone|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stone[]    findAll()
 * @method Stone[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stone::class);
    }

    public function add(Stone $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Stone $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
