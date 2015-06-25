<?php

namespace TG\ProdBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProjetRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjetRepository extends EntityRepository
{
	public function getProjetsOuverts($etape, $sort, $direction)
	{
		$qb = $this->createQueryBuilder('p');
		
		$qb
			->where('p.etape NOT IN (:etape)')
			->setParameter('etape', $etape)
			->orderBy($sort, $direction);

		return $qb
			->getQuery()
			->getResult();
	}

	public function getProjetsFermes($etape, $sort, $direction)
	{
		$qb = $this->createQueryBuilder('p');
		
		$qb
			->where('p.etape IN (:etape)')
			->setParameter('etape', $etape)
			->orderBy($sort, $direction);

		return $qb
			->getQuery()
			->getResult();
	}

	public function getProjetParClient($client)
	{
		$qb = $this->createQueryBuilder('p');
	
		$qb
			->where('p.client = :client')
			->setParameter('client', $client)
			->orderBy('p.etape', 'ASC');

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

	public function getProjetEnfant($projet, $projetparent)
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

	public function getEnfants($projet)
	{
		$qb = $this->createQueryBuilder('p');

		$qb
			->where('p.projetparent = :projetID')
			->setParameter('projetID', $projet)
			->orderBy('p.maj', 'ASC');

		return $qb
			->getQuery()
			->getResult();
	}

	public function getProjetAgenda($start, $end, $etape)
	{
		$qb = $this->createQueryBuilder('p');

		$qb
			->where('p.delai BETWEEN :start and :end')
			->andwhere('p.etape NOT IN (:etape)')
			->setParameter('start', $start)
			->setParameter('end', $end)
			->setParameter('etape', $etape);

		return $qb->getQuery()->getResult();
	}

	public function getProjetAgenda2($start, $end, $etape)
	{
		$qb = $this->createQueryBuilder('p');

		$qb
			->where('p.delai BETWEEN :start and :end')
			->andwhere('p.etape IN (:etape)')
			->setParameter('start', $start)
			->setParameter('end', $end)
			->setParameter('etape', $etape);

		return $qb->getQuery()->getResult();
	}

	public function getProjetRetard($end, $etape)
	{
		$qb = $this->createQueryBuilder('p');

		$qb
			->where('p.delai <= :end')
			->andwhere('p.etape NOT IN (:etape)')
			->setParameter('end', $end)
			->setParameter('etape', $etape)
			->orderBy('p.delai', 'DESC');

		return $qb->getQuery()->getResult();
	}
}
