<?php

// src/TG/ProdBundle/Controller/AgendaController.php

namespace TG\ProdBundle\Controller;

use \DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AgendaController extends Controller
{
		public function indexAction()
	{
		$today = date('Y-m-d');
		$yesterday = date('Y-m-d', strtotime($today."-1 days"));
		$tomorrow = date('Y-m-d', strtotime($today."+1 days"));
		$d2  = date('Y-m-d', strtotime($today."+2 days"));
		$d3  = date('Y-m-d', strtotime($today."+3 days"));
		$d4  = date('Y-m-d', strtotime($today."+4 days"));

	$em = $this->getDoctrine()->getManager()->getRepository('TGProdBundle:Projet');

	$projetsdate = $em->getProjetAgenda($today);
	$projetsyesterday = $em->getProjetAgenda($yesterday);
	$projetstomorrow = $em->getProjetAgenda($tomorrow);
	$projetsd2 = $em->getProjetAgenda($d2);
	$projetsd3 = $em->getProjetAgenda($d3);
	$projetsd4 = $em->getProjetAgenda($d4);

   return $this->render('TGProdBundle:agenda:index.html.twig', array(
   	'today' => $today,
   	'tomorrow' => $tomorrow,
 	'yesterday' => $yesterday,
   	'd2' => $d2,
   	'd3' => $d3,
   	'd4' => $d4,
   	'projetsdate' => $projetsdate,
   	'projetsyesterday' => $projetsyesterday,
   	'projetstomorrow' => $projetstomorrow,
   	'projetsd2' => $projetsd2,
   	'projetsd3' => $projetsd3,
   	'projetsd4' => $projetsd4));
	}
}
