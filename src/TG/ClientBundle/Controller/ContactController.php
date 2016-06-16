<?php

// src/TG/ClientBundle/Controller/ContactController.php

namespace TG\ClientBundle\Controller;

use TG\ClientBundle\Form\ContactType;
use TG\ClientBundle\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
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
            $sort = 'c.name';
            $direction = 'asc';
        }

        $findContacts = $this->getDoctrine()->getManager()->getRepository('TGClientBundle:Contact')->contactIndex($sort, $direction);

        $listContacts = $this->get('knp_paginator')->paginate($findContacts, $this->get('request')->query->get('page', 1), 20);

        return $this->render('TGClientBundle:Contact:index.html.twig', array(
            'listContacts' => $listContacts));
    }

  /**
  * Combobox.
  *
  * @Route("/set_contacts", name="set_contacts")
  * @Method("post")
  */
  public function setcontactsAction()
	{
      $request = $this->getRequest();
      $em = $this->getDoctrine()->getManager();
  if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
  {
    $id = '';
    $id = $request->get('id');
    if ($id != '')
    {
      $contacts = $em
        ->getRepository('TGClientBundle:Contact')->getContactduclient($id);

      $contactdefaut = $em
        ->getRepository('TGClientBundle:Contact')->getContactdefaut($id);

      $allcontacts = array_merge($contactdefaut, $contacts);

      $tabContacts = array();
      $i = 0;
      foreach($allcontacts as $contact) // pour transformer la réponse à ta requete en tableau qui replira le select2
      {
        $tabContacts[$i]['idC'] = $contact->getId();
        $tabContacts[$i]['nameC'] = $contact->getName();
        $tabContacts[$i]['defautC'] = $contact->getDefaut();
        $i++;
      }

      $response = new Response();
      $data = json_encode($tabContacts); // c'est pour formater la réponse de la requete en format que jquery va comprendre
      $response->headers->set('Content-Type', 'application/json');
      $response->setContent($data);
      return $response;
    }
  }
  return new Response('Erreur');
  }

  public function editAction(contact $contact, request $request)
  {
    $formcontact = $this->get('form.factory')->create(new ContactType, $contact);
    
    $formcontact->handleRequest($request);

    $client = $contact->getClient();

    if ($formcontact->isValid())
    {
      $em = $this->getDoctrine()->getManager();
      $em->persist($contact);

      if ($contact->getDefaut() === true)
        {
          $allcontact = $em->getRepository('TGClientBundle:Contact')->setDefauttrue($client, $contact);
          foreach ($allcontact as $contact) {
            $contact->setDefaut(false);
            $em->persist($contact);
          }
        }

      $em->flush();
      $request->getSession()->getFlashBag()->add('info', 'Contact modifié avec succès.'); //Message de confirmation

      return $this->redirect($this->generateUrl('tg_client_view', array('id' => $contact->getClient()->getId()))); //redirection vers vue du nouveau projet
    }

    return $this->render('TGClientBundle:Contact:edit.html.twig', array(
      'formcontact' => $formcontact->createView(),
      'contact' => $contact
      ));
  }

  /**
  * Combobox.
  *
  * @Route("/set_projets", name="set_projets")
  * @Method("post")
  */
  public function setprojetsAction()
  {
      $request = $this->getRequest();
      $em = $this->getDoctrine()->getManager();
  if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
  {
    $id = '';
    $id = $request->get('id');
    if ($id != '')
    {
      $projets = $em->getRepository('TGProdBundle:Projet')->findByContact($id); // qui retourne une collection d'objet je présume
      $tabProjets = array();
      $i = 0;
      foreach($projets as $projet) // pour transformer la réponse à ta requete en tableau qui replira le select2
      {
        $tabProjets[$i]['idP'] = $projet->getId();
        $tabProjets[$i]['titreP'] = $projet->getTitre();
        $tabProjets[$i]['typeP'] = $projet->getType()->getName();
        $tabProjets[$i]['userP'] = $projet->getUser()->getUsername();
        $tabProjets[$i]['assignP'] = $projet->getAssign()->getUsername();
        $tabProjets[$i]['etapeP'] = $projet->getEtape()->getName();
        $tabProjets[$i]['delaiP'] = $projet->getDelai()->format('d/m/Y');
        $i++;
      }
      $response = new Response();
      $data = json_encode($tabProjets); // c'est pour formater la réponse de la requete en format que jquery va comprendre
      $response->headers->set('Content-Type', 'application/json');
      $response->setContent($data);
      return $response;
    }
  }
  return new Response('Erreur');
  }
}
