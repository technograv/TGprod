<?php

// src/TG/ProdBundle/Controller/ProjetController.php

namespace TG\ComptaBundle\Controller;

use TG\ComptaBundle\Entity\Besoin;
use TG\ComptaBundle\Entity\Stock;
use TG\ComptaBundle\Entity\Dimension;
use TG\ComptaBundle\Form\BesoinType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class StockController extends Controller
{
	/**
	* @Security("has_role('ROLE_ATELIER')")
	*/
	public function commandeAction(request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$materiauxlist = $em->getRepository('TGComptaBundle:Stock')->findAllOrderedByName();
		$dimensionslist = $em->getRepository('TGComptaBundle:Dimension')->findAllOrderedByName();
		$tab1 = array_merge($materiauxlist, $dimensionslist);
		$besoins = array();

		foreach ($materiauxlist as $stock) {
				foreach ($dimensionslist as $dimension) {
					$besoin = $em->getRepository('TGComptaBundle:Besoin')->findBy(array('stock' => $stock, 'dimension' => $dimension), null, 1);
					$tableau = array('stock' => $stock, 'dimension' => $dimension, 'besoin' => $besoin);
					$besoins[] = $tableau;
				}
		}

		$newbesoin = new Besoin;
		$besoinform = $this->createForm(new BesoinType(), $newbesoin);

		if ($besoinform->handleRequest($request)->isValid())
		{
			$datastock = $besoinform->get('stock')->getData();
			$datadimension = $besoinform->get('dimension')->getData();
			$datanombre = $besoinform->get('nombre')->getData();

			$besoin = new Besoin;
			$besoin = $em->getRepository('TGComptaBundle:Besoin')->findOneBy(array('stock' => $datastock, 'dimension' => $datadimension));
			
			if ($besoin !== null) {
				$tempnombre = $besoin->getNombre();
				
				if ($this->getRequest()->request->get('submitAction') == 'besoin')
				{
				$nombre = $tempnombre + $datanombre;
				$besoin->setNombre($nombre);
				$em->persist($besoin);
				$em->flush();
				$request->getSession()->getFlashBag()->add('info', 'Besoin ajouté avec succès');
				return $this->redirect($this->generateUrl('tg_prod_stocks'));
				}

				elseif ($this->getRequest()->request->get('submitAction') == 'commande')
				{
				$nombre = $tempnombre - $datanombre;
				$besoin->setNombre($nombre);
				$em->persist($besoin);
				$em->flush();
				$request->getSession()->getFlashBag()->add('info', 'Commande validée avec succès');
				return $this->redirect($this->generateUrl('tg_prod_stocks'));

				}
			}

			else {
			$request->getSession()->getFlashBag()->add('info', 'Désolé, le matériaux ou la dimension sélectionné n\'existe pas');
			}
		}
			return $this->render('TGProdBundle:Projet:stocks.html.twig', array(
				'materiauxlist' => $materiauxlist,
				'dimensionslist' => $dimensionslist,
				'tableau' => $tableau,
				'besoins' => $besoins,
				'besoinform' => $besoinform->createView()));
	}

  /**
  * Combobox.
  *
  * @Route("/set_dimensions", name="set_dimensions")
  * @Method("post")
  */
  public function setdimensionsAction()
	{
      $request = $this->getRequest();
      $em = $this->getDoctrine()->getManager();
  if($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
  {
    $id = '';
    $id = $request->get('id');
    if ($id != '')
    {
      $stock = $em->getRepository('TGComptaBundle:Stock')->find($id);
	  $dimensions = $stock->getDimensions(); // qui retourne une collection d'objet je présume
      $tabDimensions = array();
      $i = 0;
      foreach($dimensions as $dimension) // pour transformer la réponse à ta requete en tableau qui replira le select2
      {
        $tabDimensions[$i]['idD'] = $dimension->getId();
        $tabDimensions[$i]['nameD'] = $dimension->getName();
        $i++;
      }
      $response = new Response();
      $data = json_encode($tabDimensions); // c'est pour formater la réponse de la requete en format que jquery va comprendre
      $response->headers->set('Content-Type', 'application/json');
      $response->setContent($data);
      return $response;
    }
  }
  return new Response('Erreur');
  }
}
