<?php

//src/TG/ProdBundle/Controller/ProjetController.php

namespace TG\ProdBundle\Controller;

use TG\ProdBundle\Entity\Projet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class MenuController extends Controller
{

	/**
	* @Security("has_role('ROLE_STAGIAIRE')")
	*/
	public function menuAction($limit = 3)
	{

	$etape = array(1, 4, 6, 24, 25, 26); //1:attente données client, 4:attente validation devis, 6:attente validation graphique, 24:facturation, 25:AttentePaiement, 26:terminé

		$ya2jour = new \Datetime;
		$ya2jour->setTime (0, 0, 0);
		$ya2jour->sub(new \DateInterval('P2D'));

	$retards = $this->getDoctrine()->getManager()->getRepository('TGProdBundle:Projet')->getProjetRetard($ya2jour, $etape);

		return $this->render('TGProdBundle:Menu:menu.html.twig', array(
			'retards' => $retards));
	}
}