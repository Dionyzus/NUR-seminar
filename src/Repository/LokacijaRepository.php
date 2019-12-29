<?php

namespace App\Repository;

use App\Entity\Lokacija;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Lokacija|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lokacija|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lokacija[]    findAll()
 * @method Lokacija[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LokacijaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lokacija::class);
    }

    /**
     * @param string|null $term
     */
    public function getWithSearchQueryBuilder(?string $term): QueryBuilder
    {
        $qb = $this->createQueryBuilder('l')
            ->innerJoin('l.ustanova', 'u')
            ->innerJoin('l.organizacija', 'o')
            ->innerJoin('l.namjena', 'n');
        if ($term) {
            $qb->andWhere('l.brojUcionice LIKE :term OR u.nazivUstanove LIKE :term OR o.nazivOrganizacije LIKE :term OR n.nazivNamjene LIKE :term')
                ->setParameter('term', '%' . $term . '%')
            ;
        }
        return $qb
            ->orderBy('l.brojUcionice', 'DESC')
            ;
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
