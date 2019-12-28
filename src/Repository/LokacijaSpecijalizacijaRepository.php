<?php

namespace App\Repository;

use App\Entity\LokacijaSpecijalizacija;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LokacijaSpecijalizacija|null find($id, $lockMode = null, $lockVersion = null)
 * @method LokacijaSpecijalizacija|null findOneBy(array $criteria, array $orderBy = null)
 * @method LokacijaSpecijalizacija[]    findAll()
 * @method LokacijaSpecijalizacija[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LokacijaSpecijalizacijaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LokacijaSpecijalizacija::class);
    }

    public function findSpecijalizacijeLokacije($ucionica)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.ucionicaBroj = :ucionicaBroj')
            ->setParameter('ucionicaBroj', $ucionica)
            ->getQuery()
            ->getResult();
    }


    public function findBySpecijalizacija($specijalizacija): ?LokacijaSpecijalizacija
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.specijalizacijaId = :specijalizacijaId')
            ->setParameter('specijalizacijaId', $specijalizacija)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

}
