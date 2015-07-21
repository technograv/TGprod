<?php

// src/TG/ProdBundle/Controller/ProjetController.php

namespace TG\ComptaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class StockController extends Controller
{
	/**
	* @Security("has_role('ROLE_ATELIER')")
	*/
	public function commandeAction()
	{
		$em = $this->getDoctrine()->getManager();
		$materiauxlist = $em->getRepository('TGComptaBundle:Stock')->findAll();
		$dimensionslist = $em->getRepository('TGComptaBundle:Dimension')->findAll();
		$tab1 = array_merge($materiauxlist, $dimensionslist);
		$besoins = array();

		foreach ($materiauxlist as $stock) {
				foreach ($dimensionslist as $dimension) {
					$besoin = $em->getRepository('TGComptaBundle:Besoin')->findBy(array('stock' => $stock, 'dimension' => $dimension), null, 1);
					$tableau = array('stock' => $stock, 'dimension' => $dimension, 'besoin' => $besoin);
					$besoins[] = $tableau;
				}
		}

		return $this->render('TGProdBundle:Projet:stocks.html.twig', array(
				'materiauxlist' => $materiauxlist,
				'dimensionslist' => $dimensionslist,
				'besoin' => $besoin,
				'tableau' => $tableau,
				'besoins' => $besoins));
	}
}
