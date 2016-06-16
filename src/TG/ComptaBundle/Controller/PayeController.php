<?php

// src/TG/ProdBundle/Controller/PayeController.php

namespace TG\ComptaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class PayeController extends Controller
{
	/**
	* @Security("has_role('ROLE_ATELIER')")
	*/
	public function profilAction()
	{
		$user = $this->getUser();
		$em = $this->getDoctrine()->getManager();
		$heuresups = $em->getRepository('TGComptaBundle:Heuresup')->findByUser($user);
		$paniers = $em->getRepository('TGComptaBundle:Panier')->findByUser($user);

		return $this->render('TGComptaBundle:Paye:profil.html.twig', array(
			'heuresups' => $heuresups,
			'paniers' => $paniers));
	}
}
