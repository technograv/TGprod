<?php

// src/TG/ClientBundle/Controller/ClientController.php

namespace TG\ClientBundle\Controller;

use TG\ClientBundle\Form\ClientType;
use TG\ClientBundle\Form\ClientEditType;
use TG\ClientBundle\Form\HeaderType;
use TG\ClientBundle\Entity\Client;
use TG\ClientBundle\Entity\Contact;
use TG\ClientBundle\Form\ContactType;
use TG\CreaBundle\Entity\Logo;
use TG\CreaBundle\Form\LogoEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{
	public function indexAction()
	{
		if($this->get('request')->query->has('sort'))
        {
            $sort = $this->get('request')->query->get('sort');
            $direction = $this->get('request')->query->get('direction');
        }
        else
        {
            $sort = 'c.datemodif';
            $direction = 'desc';
        }

		$findClients = $this->getDoctrine()->getManager()->getRepository('TGClientBundle:Client')->clientIndex($sort, $direction);

		$listClients = $this->get('knp_paginator')->paginate($findClients, $this->get('request')->query->get('page', 1), 20);


		return $this->render('TGClientBundle:Client:index.html.twig', array(
			'listClients' => $listClients));
  	}


	public function viewAction(client $client, request $request)
	{
		$em = $this->getDoctrine()->getManager();

    	$projets = $em
    		->getRepository('TGProdBundle:Projet')->getProjetParClient($client);

    	$logoduclient = $em
    		->getRepository('TGCreaBundle:Logo')->getLogoView($client);

    	$contactduclient = $em
    		->getRepository('TGClientBundle:Contact')->getContactduclient($client);

    	$contactdefaut = $em
    		->getRepository('TGClientBundle:Contact')->getContactdefaut($client);

    	$logo = new Logo;

    	$form = $this->get('form.factory')->create(new LogoEditType, $logo);

    	if ($form->handleRequest($request)->isValid())
    	{
    		$logo->setClient($client);

    		$em->persist($logo);
    		$em->flush();

    		$request->getSession()->getFlashBag()->add('info', 'Logo ajouté avec succès.');

    		return $this->redirect($this->generateUrl('tg_client_view', array('id' => $client->getId())));
    	}

    	$newcontact = new Contact;

    	$formcontact = $this->get('form.factory')->create(new ContactType, $newcontact);

    	if ($formcontact->handleRequest($request)->isValid())
    	{
    		$newcontact->setClient($client);
    		$em->persist($newcontact);
    		$em->flush();

    		if ($newcontact->getDefaut() === true)
    		{
    			$allcontact = $em->getRepository('TGClientBundle:Contact')->setDefauttrue($client, $newcontact);
    			foreach ($allcontact as $contact) {
    				$contact->setDefaut(false);
    				$em->persist($contact);
    			}
    		}

    		$em->flush();
    		$request->getSession()->getFlashBag()->add('info', 'Contact ajouté avec succès.');

    		return $this->redirect($this->generateUrl('tg_client_view', array('id' => $client->getId())));
    	}

		return $this->render('TGClientBundle:Client:view.html.twig', array(
			'client' => $client,
			'projets' => $projets,
			'logoduclient' => $logoduclient,
			'contactduclient' => $contactduclient,
			'contactdefaut' => $contactdefaut,
			'form' => $form->createView(),
			'formcontact' => $formcontact->createView()));
	}

	/**
	* @Security("has_role('ROLE_ATELIER')")
	*/
	public function addAction(request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$client = new Client();
		$contact = new Contact();
		$logo = new Logo();
		$contact->setDefaut(true);
		$client->addContact($contact);
		$client->addLogo($logo);

		if ($this->getUser())
		{
			$client->setUseradd($this->getUser());
		}

		$form = $this->get('form.factory')->create(new ClientType, $client);

		$form->handleRequest($request);

		if ($form->isValid())
		{
			$datacontact = $form->get('contacts')->getData();
			foreach ($datacontact as $contact) 
			{
				$contactname = $contact->getName();
			}
			if ($contactname !== null)
			{
				$contact->setName($contactname);
			}
			else
			{
				$contact->setName($form->get('name')->getData());
			}

			$datalogo = $form->get('logos')->getData();
			foreach ($datalogo as $logo)
			{
				$logofile = $logo->getFile();
			}
			if ($logofile === null)
			{
				$client->removeLogo($logo);
			}

			$em->persist($client);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Client créé avec succès.'); //Message de confirmation

			return $this->redirect($this->generateUrl('tg_client_view', array('id' => $client->getId()))); //redirection vers vue du nouveau projet
		}

		return $this->render('TGClientBundle:Client:add.html.twig', array(
			'form' => $form->createView(),
			));
	} 

	public function editAction(client $client, request $request)
	{
		$form = $this->get('form.factory')->create(new ClientEditType, $client);
		
		$form->handleRequest($request);

		if ($form->isValid())
		{
			if ($this->getUser())
			{
			$client->setUsermodif($this->getUser());
			}
			$em = $this->getDoctrine()->getManager();
			$em->persist($client);

			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Client modifié avec succès.'); //Message de confirmation

			return $this->redirect($this->generateUrl('tg_client_view', array('id' => $client->getId()))); //redirection vers vue du nouveau projet
		}

		return $this->render('TGClientBundle:Client:edit.html.twig', array(
			'form' => $form->createView(),
			'client' => $client
			));
	}


	public function deleteAction(client $client, request $request)
	{
		$form = $this->createFormBuilder()->getForm();

		if ($form->handleRequest($request)->isValid())
		{
			$em = $this
				->getDoctrine()
				->getManager();

			$em->remove($client);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('info', 'Client bien supprimé.');
			return $this->redirect($this->generateUrl('tg_client_home'));
		}
		
		return $this->render('TGClientBundle:Client:delete.html.twig', array(
			'client' => $client,
			'form' => $form->createView()));
	}

	public function menuAction($limit = 3)
	{
		$listClients = $this->getDoctrine()
			->getManager()
			->getRepository('TGClientBundle:Client')
			->findBy(
				array(),
				array('dateadd' => 'desc'),
				$limit,
				0);
				
		return $this->render('TGClientBundle:client:menu.html.twig', array('listClients' => $listClients));
	}

	public function headerformAction()
	{
		$em = $this->getDoctrine()->getManager();
		$listClients = $em->getRepository('TGClientBundle:Client')
			->findBy(
				array(),
				array('name' => 'asc')
				);
		$listContacts = $em->getRepository('TGClientBundle:Contact')
			->findBy(
				array(),
				array('name' => 'asc')
				);


		return $this->render('TGClientBundle:client:header.html.twig', array(
			'listClients' => $listClients,
			'listContacts' => $listContacts
			));
	}
}
