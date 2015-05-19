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

class ProjetController extends Controller
{
	/**
	* @Security("has_role('ROLE_STAGIAIRE')")
	*/
	public function indexAction()
	{
		$etape = array(26, 24, 4, 25); //26:terminé, 24:facturation, 4:AttenteValidationDevis, 25:AttentePaiement

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
		$doc = new Documentjoint();
		$projet->addDocumentjoint($doc);

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
			$datadoc = $form->get('documentjoints')->getData();
			foreach ($datadoc as $doc)
			{
				$docfile = $doc->getFile();
			}
			if ($docfile !== null)
			{
			}
			else
			{
				$projet->removeDocumentjoint($doc);
			}

			$em->persist($projet);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Projet créé avec succès.'); //Message de confirmation

			return $this->redirect($this->generateUrl('tg_prod_view', array('id' => $projet->getId()))); //redirection vers vue du nouveau projet
		}

		if ($formcontact->handleRequest($request)->isValid())
		{
			$em->persist($contact);
			$em->flush();

				if ($contact->getDefaut() === true){
					$client = $contact->getClient();
         	 		$allcontact = $em->getRepository('TGClientBundle:Contact')->setDefauttrue($client, $contact);
          			foreach ($allcontact as $contact) {
            			$contact->setDefaut(false);
            			$em->persist($contact);
          			}
        		}

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
		$em = $this->getDoctrine()->getManager();
		$contact = new Contact();
		$contact->setClient($projet->getClient());
		$formcontact = $this->createForm(new ContactType(), $contact);

		if ($formcontact->handleRequest($request)->isValid())
		{
			$contact->setClient($projet->getClient());
			$em->persist($contact);
			$em->flush();

			if ($contact->getDefaut() === true){
				$client = $contact->getClient();
         	 	$allcontact = $em->getRepository('TGClientBundle:Contact')->setDefauttrue($client, $contact);
          		foreach ($allcontact as $contact) {
            		$contact->setDefaut(false);
            		$em->persist($contact);
          		}
        	}

			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Contact ajouté avec succès');
			return $this->redirect($this->generateUrl('tg_prod_edit', array('id' => $projet->getId())));
		}

		$form = $this->createForm(new ProjetEditType(), $projet);

		if ($this->getUser())
		{
			$projet->setUser($this->getUser());
		}

		if ($form->handleRequest($request)->isValid())
		{
			$em->persist($projet);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Projet modifié avec succès.');

			return $this->redirect($this->generateUrl('tg_prod_view', array('id' => $projet->getId())));
		}

		return $this->render('TGProdBundle:Projet:edit.html.twig', array(
			'form' => $form->createView(),
			'projet' => $projet,
			'formcontact' => $formcontact->createView(),
			));
	}

	/**
	* @Security("has_role('ROLE_STAGIAIRE')")
	*/
	public function nextAction(projet $projet, request $request)
	{
		$commentaire = new Commentaire();
		$projet->addCommentaire($commentaire);

		if ($this->getUser())
		{
			$commentaire->setUser($this->getUser());
			$commentaire->setProjet($projet);
		}

		$form = $this->get('form.factory')->create(new NextType, $commentaire);
		$form->remove('projet.contact');

		if ($form->handleRequest($request)->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			$em->persist($commentaire);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Projet transformé avec succès.');
			return $this->redirect($this->generateUrl('tg_prod_view', array('id' => $projet->getId())));
		}

		return $this->render('TGProdBundle:Projet:next.html.twig', array(
			'form' => $form->createView(),
			'projet' => $projet
			));

	}

	public function deleteAction(request $request)
	{
		$doc = new Documentjoint;
		$facture = new Facture;
		$devis = new Devis;
		$crea = new Crea;
		$logo = new Logo;
		$projet = new Projet;
		$client = new Client;
		$commentaire = new Commentaire;
		$em = $this
				->getDoctrine()
				->getManager();

		$form = $this->createFormBuilder()->getForm();

		if (isset($_POST['projet'])){
			$entity = 'projet';
		}
		elseif (isset($_POST['documentjoint'])){
			$entity = 'documentjoint';
		}
		elseif (isset($_POST['devis'])){
			$entity = 'devis';
		}
		elseif (isset($_POST['facture'])){
			$entity = 'facture';
		}
		elseif (isset($_POST['crea'])){
			$entity = 'crea';
		}
		elseif (isset($_POST['logo'])){
			$entity = 'logo';
		}
		elseif (isset($_POST['commentaire'])){
			$entity = 'commentaire';
		}

		if (isset($_GET['type']))
		{
		$request = $this->get('request');
		$entity = $request->get('type');
		}

		if (isset($_GET['id']))
		{
		$request = $this->get('request');
		$id = $request->get('id');
		}

		if ($entity == 'projet')
		{
			$projet = $em->getRepository('TGProdBundle:Projet')->find($id);

		if ($form->handleRequest($request)->isValid())
		{
			$em->remove($projet);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Projet bien supprimé.');
			return $this->redirect($this->generateUrl('tg_prod_home'));
		}
		}

		if ($entity == 'documentjoint')
		{
			$doc = $em->getRepository('TGProdBundle:Documentjoint')->find($id);
			$projet = $doc->getProjet();

		if ($form->handleRequest($request)->isValid())
		{
			$em->remove($doc);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Pièce jointe supprimée avec succès.');
			return $this->redirect($this->generateUrl('tg_prod_view', array('id' => $projet->getId())));
		}
		}

		if ($entity == 'facture')
		{
			$facture = $em->getRepository('TGComptaBundle:Facture')->find($id);
			$projet = $facture->getProjet();

		if ($form->handleRequest($request)->isValid())
		{
			$em->remove($facture);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Facture supprimée avec succès.');
			return $this->redirect($this->generateUrl('tg_prod_view', array('id' => $projet->getId())));
		}
		}

		if ($entity == 'devis')
		{
			$devis = $em->getRepository('TGComptaBundle:Devis')->find($id);
			$projet = $devis->getProjet();

		if ($form->handleRequest($request)->isValid())
		{
			$em->remove($devis);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Devis supprimé avec succès.');
			return $this->redirect($this->generateUrl('tg_prod_view', array('id' => $projet->getId())));
		}
		}

		if ($entity == 'crea')
		{
			$crea = $em->getRepository('TGCreaBundle:Crea')->find($id);
			$projet = $crea->getProjet();

		if ($form->handleRequest($request)->isValid())
		{
			$em->remove($crea);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Compo supprimée avec succès.');
			return $this->redirect($this->generateUrl('tg_prod_view', array('id' => $projet->getId())));
		}
		}

		if ($entity == 'logo')
		{
			$logo = $em->getRepository('TGCreaBundle:Logo')->find($id);
			$client = $logo->getClient();

		if ($form->handleRequest($request)->isValid())
		{
			$em->remove($logo);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Logo supprimé avec succès.');
			return $this->redirect($this->generateUrl('tg_client_view', array('id' => $client->getId())));
		}
		}

		if ($entity == 'commentaire')
		{
			$commentaire = $em->getRepository('TGProdBundle:Commentaire')->find($id);
			$projet = $commentaire->getProjet();

		if ($form->handleRequest($request)->isValid())
		{
			$em->remove($commentaire);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Commentaire supprimé avec succès.');
			return $this->redirect($this->generateUrl('tg_prod_view', array('id' => $projet->getId())));
		}
		}

		return $this->render('TGProdBundle:Projet:delete.html.twig', array(
			'entity' => $entity,
			'projet' => $projet,
			'client' => $client,
			'commentaire' => $commentaire,
			'doc' => $doc,
			'facture' => $facture,
			'devis' => $devis,
			'crea' => $crea,
			'logo' => $logo,
			'form' => $form->createView()));
	}

	public function filedeleteAction(type $type, id $id, request $request)
	{
		$projet = $file->getProjet();
		$form = $this->createFormBuilder()->getForm();

		if ($form->handleRequest($request)->isValid())
		{
			$em = $this->getDoctrine()->getManager();
			$em->remove($file);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Fichier supprimé avec succès.');
			return $this->redirect($this->generateUrl('tg_prod_view', array('id' => $projet->getId())));
		}
	}

	/**
	* @Security("has_role('ROLE_STAGIAIRE')")
	*/
	public function menuAction($limit = 3)
	{
		$ya2jour = new \Datetime;
		$ya2jour->setTime (0, 0, 0);
		$ya2jour->sub(new \DateInterval('P2D'));

	$retards = $this->getDoctrine()->getManager()->getRepository('TGProdBundle:Projet')->getProjetRetard($ya2jour);

		return $this->render('TGProdBundle:projet:menu.html.twig', array(
			'retards' => $retards));
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

	/**
	* @Security("has_role('ROLE_COMPTA')")
	*/
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

	/**
	* @Security("has_role('ROLE_PAO')")
	*/
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
