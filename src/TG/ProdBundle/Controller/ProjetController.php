<?php

// src/TG/ProdBundle/Controller/ProjetController.php

namespace TG\ProdBundle\Controller;

use TG\ProdBundle\Form\ProjetType;
use TG\ProdBundle\Form\ProjetEditType;
use TG\ProdBundle\Form\ProjetLinkType;
use TG\ProdBundle\Form\ProjetUnlinkType;
use TG\ProdBundle\Form\CommentaireType;
use TG\ProdBundle\Form\NextType;
use TG\ProdBundle\Entity\Projet;
use TG\ComptaBundle\Entity\Devis;
use TG\ClientBundle\Entity\Contact;
use TG\ClientBundle\Form\ContactprodType;
use TG\ComptaBundle\Form\DevisaddType;
use TG\ComptaBundle\Entity\Facture;
use TG\ComptaBundle\Form\FactureaddType;
use TG\CreaBundle\Entity\Crea;
use TG\ProdBundle\Entity\Documentjoint;
use TG\ProdBundle\Form\DocumentjointType;
use TG\CreaBundle\Form\CreaaddType;
use TG\ProdBundle\Entity\Commentaire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ProjetController extends Controller
{
	/**
	* @Security("has_role('ROLE_STAGIAIRE')")
	*/
	public function indexAction()
	{
		$etape = array(26, 24, 3, 4, 25); //26:terminé, 24:facturation, 3:devis, 4:AttenteValidationDevis, 25:AttentePaiement

		$yesterday = new \Datetime;
		$yesterday->setTime (0, 0, 0);
		$yesterday->sub(new \DateInterval('P1D'));
		$d12 = new \DateTime;
		$d12->setTime (0, 0, 0);
		$d12->add(new \DateInterval('P9D'));

		$allDays = array();
		$allDays[] = $yesterday->format('Y-m-d');
		
		$projetsallDays = $this->getDoctrine()->getManager()->getRepository('TGProdBundle:Projet')->getProjetAgenda($yesterday, $d12, $etape);
		
		while ($yesterday <= $d12) {
		 	$yesterday->add(new \DateInterval('P1D'));
		 	$allDays[] = $yesterday->format('Y-m-d');
		 }

		 $pagename = 'calendar';
		 $page1 = $this->get('request')->query->get($pagename, 1);

		 $calendar = $this->get('knp_paginator')->paginate($allDays, $page1, 6, array('pageParameterName' => $pagename));

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
				->getProjetsOuverts($etape, $sort, $direction);

			$listProjets  = $this->get('knp_paginator')->paginate($findprojets, $this->get('request')->query->get('page', 1), 20);

			return $this->render('TGProdBundle:Projet:index.html.twig', array(
				'calendar' => $calendar,
   				'allDays' => $allDays,
   				'projetsallDays' => $projetsallDays,
				'listProjets' => $listProjets));
	}

	/**
	* @Security("has_role('ROLE_STAGIAIRE')")
	*/
	public function viewAction(projet $projet,request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$emprojet = $em->getRepository('TGProdBundle:Projet');

		$newcom = new Commentaire;
		$newcom->setProjet($projet);

		if ($this->getUser())
		{
			$newcom->setUser($this->getUser());
		}

		$formcom = $this->createForm(new CommentaireType(), $newcom);

		if ($formcom->handleRequest($request)->isValid())
		{
			$em->persist($newcom);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Commentaire ajouté avec succès');

			return $this->redirect($this->generateUrl('tg_prod_view', array('id' => $projet->getId())));
		}

		$listComments = $em
			->getRepository('TGProdBundle:Commentaire')
			->getComments($projet/*, $page, $nbPerPage*/);

		$listcrea = $em
			->getRepository('TGCreaBundle:Crea')
			->getLastCrea($projet);

		$listdoc = $em
			->getRepository('TGProdBundle:Documentjoint')
			->getLastDoc($projet);
			
		$listdevis = $em
			->getRepository('TGComptaBundle:Devis')
			->getLastDevis($projet);

		$listfacture = $em
			->getRepository('TGComptaBundle:Facture')
			->getLastFacture($projet);

		$listlogo = $em
			->getRepository('TGCreaBundle:Logo')
			->getListLogo($projet->getClient());

		$listProjets = $emprojet
			->getProjetPourLier($projet);

		$projetparent = $projet->getProjetparent();

		$listEnfants = $emprojet
			->getProjetEnfant($projet, $projetparent);

		$listcreaparent = $em
			->getRepository('TGCreaBundle:Crea')
			->getLastCrea($projetparent);
			
		$listdevisparent = $em
			->getRepository('TGComptaBundle:Devis')
			->getLastDevis($projetparent);

			if ($projetparent === null)
			{
				$formlink = $this->get('form.factory')->create(new ProjetLinkType($projet), $projet);
			}
			else
			{
				$formlink = $this->get('form.factory')->create(new ProjetUnlinkType($projet), $projet);
			}		

		 if ($formlink->handleRequest($request)->isValid())
		{
			$em->persist($projet);
			$em->flush();

			if ($projetparent === null)
			{
				$request->getSession()->getFlashBag()->add('info', 'Projets liés avec succès');
			}
			else
			{
				$request->getSession()->getFlashBag()->add('info', 'Liaisons rompue avec succès');
			}
			return $this->redirect($this->generateUrl('tg_prod_view', array('id' => $projet->getId())));
		}

		$devis = new Devis;
		$formdevis = $this->get('form.factory')->create(new DevisaddType, $devis);

		if ($formdevis->handleRequest($request)->isValid())
		{
			$devis->setProjet($projet);
			$em->persist($devis);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Devis ajouté avec succès');

			return $this->redirect($this->generateUrl('tg_prod_view', array('id' => $projet->getId())));
		}

		$facture = new Facture;
		$formfacture = $this->get('form.factory')->create(new FactureaddType, $facture);

		if ($formfacture->handleRequest($request)->isValid())
		{
			$facture->setProjet($projet);
			$em->persist($facture);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Facture ajoutée avec succès');

			return $this->redirect($this->generateUrl('tg_prod_view', array('id' => $projet->getId())));
		}

		$crea = new Crea;
		$formcrea = $this->get('form.factory')->create(new CreaaddType, $crea);

		if ($formcrea->handleRequest($request)->isValid())
		{
			$crea->setProjet($projet);
			$em->persist($crea);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Compo ajoutée avec succès');

			return $this->redirect($this->generateUrl('tg_prod_view', array('id' => $projet->getId())));
		}

		$doc = new Documentjoint;
		$formdoc = $this->get('form.factory')->create(new DocumentjointType, $doc);

		if ($formdoc->handleRequest($request)->isValid())
		{
			$doc->setProjet($projet);
			$em->persist($doc);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Pièce jointe ajoutée avec succès');

			return $this->redirect($this->generateUrl('tg_prod_view', array('id' => $projet->getId())));
		}

			return $this->render('TGProdBundle:Projet:view.html.twig', array(
				'projet' => $projet,
				'listComments' => $listComments,
				'listProjets' => $listProjets,
				'listcrea' => $listcrea,
				'listlogo' => $listlogo,
				'listdevis' => $listdevis,
				'listfacture' => $listfacture,
				'listdoc' => $listdoc,
				'formlink' => $formlink->createView(),
				'formdevis' => $formdevis->createView(),
				'formfacture' => $formfacture->createView(),
				'formcrea' => $formcrea->createView(),
				'formcom' => $formcom->createView(),
				'formdoc' => $formdoc->createView(),
				'projetparent' => $projetparent,
				'listEnfants' => $listEnfants,
				'listdevisparent' => $listdevisparent,
				'listcreaparent' => $listcreaparent
				));
	}

	/**
	* @Security("has_role('ROLE_ATELIER')")
	*/
	public function addAction(request $request)
	{

		$projet = new Projet();

		$em = $this->getDoctrine()->getManager();
		$request = $this->get('request');

		if (isset($_GET['client']))
		{
			$client = $em->getRepository('TGClientBundle:Client')->find($request->query->get('client'));

			if ($client !== null)
			{
				$projet->setClient($client);
			}
		}

		if ($this->getUser())
		{
			$projet->setUser($this->getUser());
		}

		$form = $this->get('form.factory')->create(new ProjetType, $projet);

		$contact = new Contact();
		$formcontact = $this->get('form.factory')->create(new ContactprodType, $contact);

		if ($form->handleRequest($request)->isValid())
		{
			$em->persist($projet);

			$docfile = $form->get('docfile')->getData();

			if ($docfile !== null)
			{
				$doc = new Documentjoint;
				$doc->setProjet($projet);
				$doc->setFile($docfile);
				$doc->setExtention($docfile->guessExtension());
				$doc->setAlt($docfile->getClientOriginalName());
				$em->persist($doc);
			}

			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Projet créé avec succès.'); //Message de confirmation

			return $this->redirect($this->generateUrl('tg_prod_view', array('id' => $projet->getId()))); //redirection vers vue du nouveau projet
		}

		if ($formcontact->handleRequest($request)->isValid())
		{
			$em->persist($contact);
			$em->flush();
			$request->getSession()->getFlashBag()->add('info', 'Contact créé avec succès.');
		}

		return $this->render('TGProdBundle:Projet:add.html.twig', array(
			'form' => $form->createView(),
			'formcontact' => $formcontact->createView(),
			));
	} 


	public function editAction(projet $projet, request $request)
	{
		$form = $this->createForm(new ProjetEditType(), $projet);

		if ($this->getUser())
		{
			$projet->setUser($this->getUser());
		}

		if ($form->handleRequest($request)->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($projet);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Projet modifié avec succès.');

			return $this->redirect($this->generateUrl('tg_prod_view', array('id' => $projet->getId())));
		}

		return $this->render('TGProdBundle:Projet:edit.html.twig', array(
			'form' => $form->createView(),
			'projet' => $projet
			));
	}

	/**
	* @Security("has_role('ROLE_ATELIER')")
	*/
	public function nextAction(projet $projet, request $request)
	{
		$commentaire = new Commentaire();
		$commentaire->setProjet($projet);

		if ($this->getUser())
		{
			$commentaire->setUser($this->getUser());
		}

		$form = $this->get('form.factory')->create(new nextType, $commentaire);

		if ($form->handleRequest($request)->isValid())
		{
			$projet->setEtape($form->get('etape')->getData());
			$projet->setAssign($form->get('assign')->getData());
			$em = $this->getDoctrine()->getManager();
			$em->persist($commentaire);
			$em->persist($projet);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Projet transformé avec succès.');
			return $this->redirect($this->generateUrl('tg_prod_view', array('id' => $projet->getId())));
		}

		return $this->render('TGProdBundle:Projet:next.html.twig', array(
			'form' => $form->createView(),
			'projet' => $projet
			));

	}

	public function deleteAction(projet $projet, request $request)
	{
		$form = $this->createFormBuilder()->getForm();

		if ($form->handleRequest($request)->isValid())
		{
			$em = $this
				->getDoctrine()
				->getManager();

			$em->remove($projet);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Projet bien supprimé.');
			return $this->redirect($this->generateUrl('tg_prod_home'));
		}
		return $this->render('TGProdBundle:Projet:delete.html.twig', array(
			'projet' => $projet,
			'form' => $form->createView()));
	}

	/**
	* @Security("has_role('ROLE_STAGIAIRE')")
	*/
	public function menuAction($limit = 3)
	{
		$listProjets = $this->getDoctrine()
			->getManager()
			->getRepository('TGProdBundle:Projet')
			->findBy(
				array(),					// Pas de critère
				array('maj' => 'desc'),	// On trie par date décroissante
				$limit,					// On sélectionne $limit projets
				0);							// A partir du premier

		return $this->render('TGProdBundle:projet:menu.html.twig', array('listProjets' => $listProjets));
	}

	/**
	* @Security("has_role('ROLE_STAGIAIRE')")
	*/
	public function fichierAction(projet $projet, request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$listdoc = $em
			->getRepository('TGProdBundle:Documentjoint')
			->findBy(
				array('projet' => $projet),
				array('date' => 'asc'));

		$listcrea = $em
			->getRepository('TGCreaBundle:Crea')
			->findBy(
				array('projet' => $projet),
				array('dateadd' => 'asc'));
			
		$listdevis = $em
			->getRepository('TGComptaBundle:Devis')
			->findBy(
				array('projet' => $projet),
				array('dateadd' => 'asc'));

		$listfacture = $em
			->getRepository('TGComptaBundle:Facture')
			->findBy(
				array('projet' => $projet),
				array('dateadd' => 'asc'));

		$client = $projet->getClient();

		$listlogo = $em
			->getRepository('TGCreaBundle:Logo')
			->findBy(
				array('client' => $client),
				array('date' => 'asc'));

		return $this->render('TGProdBundle:projet:fichier.html.twig', array(
			'projet' => $projet,
			'listcrea' => $listcrea,
			'listdevis' => $listdevis,
			'listfacture' => $listfacture,
			'listlogo' => $listlogo,
			'listdoc' => $listdoc
			));
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


			return $this->render('TGProdBundle:Projet:archives.html.twig', array(
				'listProjets' => $listProjets));
	}

	public function comptaAction()
	{
		$etape = array(24, 3); //24:facturation, 3:devis

		$yesterday = new \Datetime;
		$yesterday->setTime (0, 0, 0);
		$yesterday->sub(new \DateInterval('P1D'));
		$d12 = new \DateTime;
		$d12->setTime (0, 0, 0);
		$d12->add(new \DateInterval('P9D'));

		$allDays = array();
		$allDays[] = $yesterday->format('Y-m-d');
		
		$projetsallDays = $this->getDoctrine()->getManager()->getRepository('TGProdBundle:Projet')->getProjetAgenda2($yesterday, $d12, $etape);
		
		while ($yesterday <= $d12) {
		 	$yesterday->add(new \DateInterval('P1D'));
		 	$allDays[] = $yesterday->format('Y-m-d');
		 }

		 $pagename = 'calendar';
		 $page1 = $this->get('request')->query->get($pagename, 1);

		 $calendar = $this->get('knp_paginator')->paginate($allDays, $page1, 6, array('pageParameterName' => $pagename));

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

			return $this->render('TGProdBundle:Projet:index.html.twig', array(
				'calendar' => $calendar,
   				'allDays' => $allDays,
   				'projetsallDays' => $projetsallDays,
				'listProjets' => $listProjets));
	}

	public function relancesAction()
	{
		$etape = array(4, 25); //4:AttenteValidationDevis, 25:AttentePaiement

		$yesterday = new \Datetime;
		$yesterday->setTime (0, 0, 0);
		$yesterday->sub(new \DateInterval('P1D'));
		$d12 = new \DateTime;
		$d12->setTime (0, 0, 0);
		$d12->add(new \DateInterval('P9D'));

		$allDays = array();
		$allDays[] = $yesterday->format('Y-m-d');
		
		$projetsallDays = $this->getDoctrine()->getManager()->getRepository('TGProdBundle:Projet')->getProjetAgenda2($yesterday, $d12, $etape);
		
		while ($yesterday <= $d12) {
		 	$yesterday->add(new \DateInterval('P1D'));
		 	$allDays[] = $yesterday->format('Y-m-d');
		 }

		 $pagename = 'calendar';
		 $page1 = $this->get('request')->query->get($pagename, 1);

		 $calendar = $this->get('knp_paginator')->paginate($allDays, $page1, 6, array('pageParameterName' => $pagename));

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

			return $this->render('TGProdBundle:Projet:index.html.twig', array(
				'calendar' => $calendar,
   				'allDays' => $allDays,
   				'projetsallDays' => $projetsallDays,
				'listProjets' => $listProjets));
	}
}
