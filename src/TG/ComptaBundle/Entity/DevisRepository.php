<?php

namespace TG\ComptaBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * DevisRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DevisRepository extends EntityRepository
{
	public function getLastDevis($projet)
	{
		$qb = $this->createQueryBuilder('d');

		$qb
			->where('d.projet = :projet')
			->setParameter('projet', $projet)
			->orderBy('d.dateadd', 'DESC')
			->SetMaxResults(1, 1);

		return $qb
			->getQuery()
			->getResult();
	}
}
