<?php

namespace TG\ProdBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * ProjetRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjetRepository extends EntityRepository
{
	public function getProjetsOuverts($etape)
	{
		$qb = $this->createQueryBuilder('p');
		
		$qb
			->where('p.etape != :etape')
			->setParameter('etape', $etape)
			->orderBy('p.maj', 'DESC')
			->getQuery();

		return $qb
			->getQuery()
			->getResult();
	}

	public function getProjetsFermes($etape, $page, $nbPerPage)
	{
		$qb = $this->createQueryBuilder('p');
		
		$qb
			->where('p.etape = :etape')
			->setParameter('etape', $etape)
			->orderBy('p.maj', 'DESC')
			->getQuery();

		$qb
			->setFirstResult(($page-1) * $nbPerPage)
			->setMaxResults($nbPerPage);

		return new Paginator($qb, true);
	}

	public function getProjetParClient($client)
	{
		$qb = $this->createQueryBuilder('p');
	
		$qb
			->where('p.client = :client')
			->setParameter('client', $client)
			->orderBy('p.maj', 'DESC');

		return $qb
			->getQuery()
			->getResult();
	}

	public function getProjetPourLier($projet)
	{
		$qb = $this->createQueryBuilder('p');

		$qb
			->where('p.client = :client')
			->andwhere('p.id != :projetID')
			->setParameter('client', $projet->getClient())
			->setParameter('projetID', $projet->getId())
			->orderBy('p.maj', 'DESC');

		return $qb;
		//	->getQuery()
		//	->getResult();
	}

	public function GetProjetEnfant($projet, $projetparent)
	{
		$qb = $this->createQueryBuilder('p');

		$qb
			->where('p.projetparent = :projetparentID')
			->andwhere('p != :projetID')
			->setParameter('projetID', $projet)
			->setParameter('projetparentID', $projetparent)
			->orderBy('p.maj', 'ASC');

		return $qb
			->getQuery()
			->getResult();
	}
}
