<?php

namespace App\Repository;

use App\Entity\HardwareSoftware;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method HardwareSoftware|null find($id, $lockMode = null, $lockVersion = null)
 * @method HardwareSoftware|null findOneBy(array $criteria, array $orderBy = null)
 * @method HardwareSoftware[]    findAll()
 * @method HardwareSoftware[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HardwareSoftwareRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HardwareSoftware::class);
    }

    public function findSoftwareHardware($hardware)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.brojInventara = :brojInventara')
            ->setParameter('brojInventara', $hardware)
            ->getQuery()
            ->getResult();
    }


    public function findBySoftware($software): ?HardwareSoftware
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.sifraSoftware = :sifraSoftware')
            ->setParameter('sifraSoftware', $software)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

}
