<?php

namespace AppBundle\Repository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
/**
 * evenementRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class evenementRepository extends \Doctrine\ORM\EntityRepository
{
	public function research(String $mot )
    {
        return $this->createQueryBuilder('e')
                    ->where('e.description LIKE ?1')
                    ->orwhere('e.description LIKE ?2')
                    ->orwhere('e.idTypeEvenement LIKE ?3')
                    ->setParameter(1, '% '.$mot.' %')
                    ->setParameter(2, $mot.' %')
                    ->setParameter(3, $mot)
                    ->getQuery()
                    ->execute();
    }
}
