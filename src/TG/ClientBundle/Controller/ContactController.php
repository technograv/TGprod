<?php

// src/TG/ClientBundle/Controller/ContactController.php

namespace TG\ClientBundle\Controller;

use TG\ClientBundle\Entity\Client;
use TG\ClientBundle\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
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
      $contacts = $em->getRepository('TGClientBundle:Contact')->setcontactsbyclient($id); // qui retourne une collection d'objet je présume
      $tabContacts = array();
      $i = 0;
      foreach($contacts as $contact) // pour transformer la réponse à ta requete en tableau qui replira le select2
      {
        $tabContacts[$i]['idC'] = $contact->getId();
        $tabContacts[$i]['nameC'] = $contact->getName();
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
}
