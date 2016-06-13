<?php

//src/TG/ProdBundle/Controller/CalendrierController.php

namespace TG\ProdBundle\Controller;

use TG\ProdBundle\Form\ProjetType;
use TG\ProdBundle\Entity\EtapeRepository;
use TG\ProdBundle\Form\ProjetEditType;
use TG\ProdBundle\Form\ProjetLinkType;
use TG\ProdBundle\Form\ProjetUnlinkType;
use TG\ProdBundle\Form\CommentaireType;
use TG\ProdBundle\Form\NextType;
use TG\ProdBundle\Form\NextAtelierType;
use TG\ProdBundle\Entity\Projet;
use TG\ComptaBundle\Entity\Devis;
use TG\ClientBundle\Entity\Contact;
use TG\ClientBundle\Entity\Client;
use TG\ClientBundle\Form\ContactprodType;
use TG\ClientBundle\Form\ContactType;
use TG\ComptaBundle\Form\DevisaddType;
use TG\ComptaBundle\Entity\Facture;
use TG\ComptaBundle\Form\FactureaddType;
use TG\CreaBundle\Entity\Crea;
use TG\CreaBundle\Entity\Logo;
use TG\ProdBundle\Entity\Documentjoint;
use TG\ProdBundle\Form\DocumentjointType;
use TG\CreaBundle\Form\CreaaddType;
use TG\ProdBundle\Entity\Commentaire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CalendrierController extends Controller
{

/**
	* @Security("has_role('ROLE_STAGIAIRE')")
	*/
	public function indexAction()
	{
		$etape = array(1, 26, 24, 4, 6, 25, 18); //1,AttenteDonnéesClient, 26:terminé, 24:facturation, 4:AttenteValidationDevis, 6:AttenteValidationGraphique , 25:AttentePaiement, 18:AttenteLivraisonFournisseur

		$yesterday = new \Datetime;
		$yesterday->setTime (0, 0, 0);
		$yesterday->sub(new \DateInterval('P1D'));
		$d12 = new \DateTime;
		$d12->setTime (0, 0, 0);
		$d12->add(new \DateInterval('P15D'));

		$allDays = array();
		$allDays[] = $yesterday->format('Y-m-d');
		
		$em = $this->getDoctrine()->getManager();

		$projetslivraison = $em->getRepository('TGProdBundle:Projet')->getProjetLivraison($yesterday, $d12, $etape);
		$projetslivraisontoday = $em->getRepository('TGProdBundle:Projet')->getProjetLivraisonToday($yesterday, $d12, $etape);
		$projetsallDays = $em->getRepository('TGProdBundle:Projet')->getProjetAgenda($yesterday, $d12, $etape);

		while ($yesterday <= $d12) {
		 	$yesterday->add(new \DateInterval('P1D'));
		 	$allDays[] = $yesterday->format('Y-m-d');
		 }

		 $pagename = 'calendar';
		 $page1 = $this->get('request')->query->get($pagename, 1);

		 $calendar = $this->get('knp_paginator')->paginate($allDays, $page1, 18, array('pageParameterName' => $pagename));

		return $this->render('TGProdBundle:Calendrier:index.html.twig', array(
			'calendar' => $calendar,
   			'allDays' => $allDays,
   			'projetsallDays' => $projetsallDays,
   			'projetslivraison' => $projetslivraison,
   			'projetslivraisontoday' => $projetslivraisontoday,));
	}

	/**
	* @Security("has_role('ROLE_ATELIER')")
	*/
	public function archivesAction()
	{
		if($this->get('request')->query->has('sort'))
        {
            $sort = $this->get('request')->query->get('sort');
            $direction = $this->get('request')->query->get('direction');
        }
        else
        {
            $sort = 'p.maj';
            $direction = 'desc';
        }

			$findprojets = $this
				->getDoctrine()
				->getManager()
				->getRepository('TGProdBundle:Projet')
				->getProjetsFermes(26, $sort, $direction);

			$listProjets  = $this->get('knp_paginator')->paginate($findprojets, $this->get('request')->query->get('page', 1), 20);


			return $this->render('TGProdBundle:Calendrier:archives.html.twig', array(
				'listProjets' => $listProjets));
	}

	/**
	* @Security("has_role('ROLE_PAO')")
	*/
	public function relancesAction()
	{
		$etape = array(1, 4, 25, 6, 18); //1:attenteDonnéesClient, 4:AttenteValidationDevis, 25:AttentePaiement, 6:AttenteValidationGraphique, 18:AttenteLivraisonFournisseur

		if($this->get('request')->query->has('sort'))
        {
            $sort = $this->get('request')->query->get('sort');
            $direction = $this->get('request')->query->get('direction');
        }
        else
        {
            $sort = 'p.maj';
            $direction = 'desc';
        }
			
			$findprojets = $this
				->getDoctrine()
				->getManager()
				->getRepository('TGProdBundle:Projet')
				->getProjetsFermes($etape, $sort, $direction);

			$listProjets  = $this->get('knp_paginator')->paginate($findprojets, $this->get('request')->query->get('page', 1), 20);

			return $this->render('TGProdBundle:Calendrier:relances.html.twig', array(
				'listProjets' => $listProjets));
	}

	/**
	* @Security("has_role('ROLE_COMPTA')")
	*/
	public function comptaAction()
	{
		$etape = array(24); //24:facturation

				if($this->get('request')->query->has('sort'))
        {
            $sort = $this->get('request')->query->get('sort');
            $direction = $this->get('request')->query->get('direction');
        }
        else
        {
            $sort = 'p.maj';
            $direction = 'desc';
        }
			
			$findprojets = $this
				->getDoctrine()
				->getManager()
				->getRepository('TGProdBundle:Projet')
				->getProjetsFermes($etape, $sort, $direction);

			$listProjets  = $this->get('knp_paginator')->paginate($findprojets, $this->get('request')->query->get('page', 1), 20);

			return $this->render('TGProdBundle:Calendrier:facturation.html.twig', array(
				'listProjets' => $listProjets));
	}
}