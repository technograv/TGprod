<?php

// src/TG/ProdBundle/Controller/ProjetController.php

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

class ProjetController extends Controller
{
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

		$enfants = $emprojet
			->getEnfants($projet);

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
				'listcreaparent' => $listcreaparent,
				'enfants' => $enfants
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

		if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
			$form = $this->createForm(new ProjetType(), $projet);
			$form
				->remove('documentjoints');
		}
		else {
		$form = $this->createForm(new ProjetEditType(), $projet);
		$form
			->remove('contact')
			->remove('etape')
			->add('etape',     'entity', array(
                'label' => 'Etape en cours',
                'class' => 'TGProdBundle:Etape',
                'property' => 'name',
                'query_builder' => function(EtapeRepository $er)
                {
                    return $er->createQueryBuilder('e')
                    ->where('e.id NOT IN (:id)')
                    ->setParameter('id', array(1, 4, 6, 18, 25, 26))
                    ->orderBy('e.name', 'ASC');
                },
                'multiple' => false,
                'empty_value' => 'Liste des étapes'));
		}

		if ($this->getUser())
		{
			$projet->setUsermodif($this->getUser());
		}

		if ($form->handleRequest($request)->isValid())
		{
			$projet->setDatemodif();
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

		if ($this->get('security.context')->isGranted('ROLE_COMPTA')) {
			$form = $this->get('form.factory')->create(new NextType, $commentaire);
		}
		else {
		$form = $this->get('form.factory')->create(new NextAtelierType, $commentaire);
		}


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
}
