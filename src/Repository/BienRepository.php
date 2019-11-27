<?php

namespace App\Repository;

use App\Entity\Bien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Bien|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bien|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bien[]    findAll()
 * @method Bien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BienRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bien::class);
    }

        /**
     * @return Bien[}
     */
    public function findAllVisible(): array {
        // on donne un alias a l'objet pour la requete
        return $this->findVisibleQuery()
           // ->where('b.sold = false')
            ->getQuery()
            ->getResult();
    }


    /**
     * @return Bien[]
     */
        public function  findLatest(): array{
            return $this->findVisibleQuery()
              //  ->where('b.sold = false')
                ->setMaxResults(4)
                ->getQuery()
                ->getResult();
        }

        // méthode privé
        private function findVisibleQuery(): QueryBuilder{
            return $this->createQueryBuilder('b')
                ->where('b.sold = false');
        }
}
