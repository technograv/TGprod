<?php

//src/TG/ProdBundle/Controller/ProjetController.php

namespace TG\ProdBundle\Controller;

use TG\ProdBundle\Entity\Projet;
use TG\ComptaBundle\Entity\Devis;
use TG\ClientBundle\Entity\Contact;
use TG\ClientBundle\Entity\Client;
use TG\ComptaBundle\Entity\Facture;
use TG\CreaBundle\Entity\Crea;
use TG\CreaBundle\Entity\Logo;
use TG\ProdBundle\Entity\Documentjoint;
use TG\ProdBundle\Entity\Commentaire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class FichierController extends Controller
{
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

		$extention = array('pdf', 'jpg', 'JPEG', 'doc', 'docx', 'PNG');
		$listcrea = $em
			->getRepository('TGCreaBundle:Crea')
			->findBy(
				array('projet' => $projet, 'extention' => $extention),
				array('dateadd' => 'asc'));

		$extention = array('cdr', 'psd', 'eps', 'ai', 'tiff', 'indd', 'cpt');
		$listsource = $em
			->getRepository('TGCreaBundle:Crea')
			->findBy(
				array('projet' => $projet, 'extention' => $extention),
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

		return $this->render('TGProdBundle:Fichier:fichier.html.twig', array(
			'projet' => $projet,
			'listcrea' => $listcrea,
			'listsource' => $listsource,
			'listdevis' => $listdevis,
			'listfacture' => $listfacture,
			'listlogo' => $listlogo,
			'listdoc' => $listdoc
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

			$request->getSession()->getFlashBag()->add('info', 'Projet supprimé avec succès.');
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

		return $this->render('TGProdBundle:Fichier:delete.html.twig', array(
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
}