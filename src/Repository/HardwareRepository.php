<?php


namespace App\Repository;

use App\Entity\Hardware;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Hardware|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hardware|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hardware[]    findAll()
 * @method Hardware[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HardwareRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hardware::class);
    }

    /**
    * @param string|null $term
    */
    public function getWithSearchQueryBuilder(?string $term): QueryBuilder
    {
        $qb = $this->createQueryBuilder('h')
            ->innerJoin('h.brojUcionice', 'l')
            ->innerJoin('h.vlasnistvo', 'v')
            ->innerJoin('h.organizacija', 'o')
            ->innerJoin('h.namjena', 'n');
        if ($term) {
            $qb->andWhere('h.nazivHardware LIKE :term OR l.brojUcionice LIKE :term OR v.nazivVlasnika LIKE :term OR o.nazivOrganizacije LIKE :term OR n.nazivNamjene LIKE :term')
                ->setParameter('term', '%' . $term . '%')
            ;
        }
        return $qb
            ->orderBy('h.nazivHardware', 'DESC')
            ;
    }
}
