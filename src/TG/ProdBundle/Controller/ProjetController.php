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
use TG\ComptaBundle\Form\DevisaddType;
use TG\ComptaBundle\Entity\Facture;
use TG\ComptaBundle\Form\FactureaddType;
use TG\CreaBundle\Entity\Crea;
use TG\CreaBundle\Form\CreaaddType;
use TG\ProdBundle\Entity\Commentaire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProjetController extends Controller
{
	public function indexAction($page)
	{
		if ($page < 1)
			{
				throw $this->createNotFoundException("La page ".$page." n'existe pas.");
			}

	 // récup du nombre de projets ouverts et division pour établir le nombre de page

			$nbPerPage = 10;

			$listProjets = $this
				->getDoctrine()
				->getManager()
				->getRepository('TGProdBundle:Projet')
				->getProjetsOuverts('Projet terminé', $page, $nbPerPage);

			$nbPages = ceil(count($listProjets)/$nbPerPage);

			if ($nbPages < 1)
			{
				$nbPages = 1;
			}

			if ($page > $nbPages)
			{
				throw $this->createNotFoundException("La page ".$page." n'existe pas.");
			}

			return $this->render('TGProdBundle:Projet:index.html.twig', array(
				'listProjets' => $listProjets,
				'nbPages' => $nbPages,
				'page' => $page));
	}


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
			
		$listdevis = $em
			->getRepository('TGComptaBundle:Devis')
			->getLastDevis($projet);

		$listfacture = $em
			->getRepository('TGComptaBundle:Facture')
			->getLastFacture($projet);

		$listProjets = $emprojet
			->getProjetPourLier($projet);

		$listEnfants = $emprojet
			->getProjetEnfant($projet);

		$projetparent = $projet->getProjetparent();

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

			$request->getSession()->getFlashBag()->add('infos', 'Projets liés avec succès');

			return $this->redirect($this->generateUrl('tg_prod_view', array('id' => $projet->getId())));
		}

		$devis = new Devis;
		$formdevis = $this->get('form.factory')->create(new DevisaddType, $devis);

		if ($formdevis->handleRequest($request)->isValid())
		{
			$devis->setProjet($projet);
			$em->persist($devis);
			$em->flush();

			$request->getSession()->getFlashBag()->add('infos', 'Devis ajouté avec succès');

			return $this->redirect($this->generateUrl('tg_prod_view', array('id' => $projet->getId())));
		}

		$facture = new Facture;
		$formfacture = $this->get('form.factory')->create(new FactureaddType, $facture);

		if ($formfacture->handleRequest($request)->isValid())
		{
			$facture->setProjet($projet);
			$em->persist($facture);
			$em->flush();

			$request->getSession()->getFlashBag()->add('infos', 'Facture ajoutée avec succès');

			return $this->redirect($this->generateUrl('tg_prod_view', array('id' => $projet->getId())));
		}

		$crea = new Crea;
		$formcrea = $this->get('form.factory')->create(new CreaaddType, $crea);

		if ($formcrea->handleRequest($request)->isValid())
		{
			$crea->setProjet($projet);
			$em->persist($crea);
			$em->flush();

			$request->getSession()->getFlashBag()->add('infos', 'Compo ajoutée avec succès');

			return $this->redirect($this->generateUrl('tg_prod_view', array('id' => $projet->getId())));
		}

			return $this->render('TGProdBundle:Projet:view.html.twig', array(
				'projet' => $projet,
				'listComments' => $listComments,
				//'nbPages' => $nbPages,
				//'page' => $page,
				'listProjets' => $listProjets,
				'listcrea' => $listcrea,
				'listdevis' => $listdevis,
				'listfacture' => $listfacture,
				'formlink' => $formlink->createView(),
				'formdevis' => $formdevis->createView(),
				'formfacture' => $formfacture->createView(),
				'formcrea' => $formcrea->createView(),
				'formcom' => $formcom->createView(),
				'projetparent' => $projetparent,
				'listEnfants' => $listEnfants,
				'listdevisparent' => $listdevisparent,
				'listcreaparent' => $listcreaparent
				));
	}

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

		if ($form->handleRequest($request)->isValid())
		{
			$em->persist($projet);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Projet créé avec succès.'); //Message de confirmation

			return $this->redirect($this->generateUrl('tg_prod_view', array('id' => $projet->getId()))); //redirection vers vue du nouveau projet
		}

		return $this->render('TGProdBundle:Projet:add.html.twig', array(
			'form' => $form->createView(),
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

	public function nextAction(projet $projet, request $request)
	{
		$commentaire = new Commentaire();
		$commentaire->setProjet($projet);

		if ($this->getUser())
		{
			$commentaire->setUser($this->getUser());
		}

		$form = $this->get('form.factory')->create(new nextType, $commentaire);

		$form->handleRequest($request);

		if ($form->isValid())
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

	public function testAction(request $request)
	{

	$form = $this->createFormBuilder()
		->add('text', 'textarea',array(
			'mapped' => false,
			'required' => false))
		->add('save', 'submit')
		->getForm();

		$text = 'Aucun message !';

	if ($form->handleRequest($request)->isValid())
	{
		$text = $form->get('text')->getData();

		return $this->render('TGProdBundle:projet:test.html.twig', array(
			'text' => $text,
			'form' => $form->createView()));
	}

	return $this->render('TGProdBundle:projet:test.html.twig', array(
		'form' => $form->createView(),
		'text' => $text));
	}

	public function fichierAction(projet $projet, request $request)
	{
		$em = $this->getDoctrine()->getManager();

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
			'listlogo' => $listlogo
			));
	}
	
	public function archivesAction($page)
	{
		if ($page < 1)
			{
				throw $this->createNotFoundException("La page ".$page." n'existe pas.");
			}

			$nbPerPage = 50;

			$listProjets = $this
				->getDoctrine()
				->getManager()
				->getRepository('TGProdBundle:Projet')
				->getProjetsFermes('Projet terminé', $page, $nbPerPage);

			$nbPages = ceil(count($listProjets)/$nbPerPage);

			if ($nbPages < 1)
			{
				$nbPages = 1;
			}

			if ($page > $nbPages)
			{
				throw $this->createNotFoundException("La page ".$page." n'existe pas.");
			}

			return $this->render('TGProdBundle:Projet:archives.html.twig', array(
				'listProjets' => $listProjets,
				'nbPages' => $nbPages,
				'page' => $page));
	}
}
