<?php

namespace TG\ComptaBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * FactureRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FactureRepository extends EntityRepository
{
	public function getLastFacture($projet)
	{
		$qb = $this->createQueryBuilder('f');

		$qb
			->where('f.projet = :projet')
			->setParameter('projet', $projet)
			->orderBy('f.dateadd', 'DESC')
			->SetMaxResults(1, 1);

		return $qb
			->getQuery()
			->getResult();
	}
}
