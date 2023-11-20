<?php

namespace TG\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TG\ProdBundle\Entity\Type;
use TG\ProdBundle\Form\TypeType;
use TG\ProdBundle\Entity\Etape;
use TG\ComptaBundle\Entity\Stock;
use TG\ComptaBundle\Form\StockType;
use TG\ComptaBundle\Entity\Dimension;
use TG\ComptaBundle\Form\DimensionType;
use TG\ComptaBundle\Entity\Besoin;
use TG\ProdBundle\Form\EtapeType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AdminController extends Controller
{
    /**
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();

    	$typeslist = $em->getRepository('TGProdBundle:Type')->FindAll();
    	$etapeslist = $em->getRepository('TGProdBundle:Etape')->FindAll();

       return $this->render('TGAdminBundle:Admin:index.html.twig', array(
        	'typeslist' => $typeslist,
        	'etapeslist' => $etapeslist));
    }

    /**
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function typesAction(request $request)
    {
    	$type = new Type;

        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');

    	$typeslist = $em->getRepository('TGProdBundle:Type')->FindAll();

        if ($request->query->get('type'))
        {
            $edittype = $em->getRepository('TGProdBundle:Type')->find($request->query->get('type'));

            if ($edittype !== null)
            {
                $type = $edittype;
            }
        }

    	$form = $this->get('form.factory')->create(new TypeType, $type);

    	if ($form->handleRequest($request)->isValid())
		{
			$em->persist($type);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Type défini avec succès.');

			return $this->redirect($this->generateUrl('tg_admin_types'));
		}

    	return $this->render('TGAdminBundle:Admin:types.html.twig', array(
    		'typeslist' => $typeslist,
    		'form' => $form->createView()));
    }

    /**
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function etapesAction(request $request)
    {
        $etape = new Etape;

    	$em = $this->getDoctrine()->getManager();
        $request = $this->get('request');

    	$etapeslist = $em->getRepository('TGProdBundle:Etape')->FindAll();

        if ($request->query->get('etape'))
        {
            $editetape = $em->getRepository('TGProdBundle:Etape')->find($request->query->get('etape'));

            if ($editetape !== null)
            {
                $etape = $editetape;
            }
        }

    	$form = $this->get('form.factory')->create(new EtapeType, $etape);

    	if ($form->handleRequest($request)->isValid())
		{
			$em->persist($etape);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Etape définie avec succès.');

			return $this->redirect($this->generateUrl('tg_admin_etapes'));
		}

    	return $this->render('TGAdminBundle:Admin:etapes.html.twig', array(
    		'etapeslist' => $etapeslist,
    		'form' => $form->createView()));
    }

    /**
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function comptesAction()
    {
    	$em = $this->getDoctrine()->getManager();

    	$compteslist = $em->getRepository('TGUserBundle:User')->FindAll();

    	return $this->render('TGAdminBundle:Admin:comptes.html.twig', array(
    		'compteslist' => $compteslist));
    }

    /**
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function droitsAction(request $request)
    {
    	$em = $this->getDoctrine()->getManager();

    	$compteslist = $em->getRepository('TGUserBundle:User')->FindAll();

    	$formbuilder = $this->get('form.factory')->createBuilder('form', $compteslist);

    	$formbuilder
			->add('user', 'entity', array(
				'label' => 'Liste des utilisateurs',
				'class' => 'TGUserBundle:User',
				'property' => 'username',
				'multiple' => false))
			->add('roles', 'choice', array(
					'choices' => array(
                        'ROLE_STAGIAIRE' => 'Stagiaire',
						'ROLE_atelier' => 'Atelier',
                        'ROLE_PAO' => 'PAO',       
						'ROLE_compta' => 'Comptable',
						'ROLE_gerant' => 'Gérant',
						'ROLE_admin' => 'Admin'),
					'multiple' => true))
			->add('Enregistrer', 'submit');

		$form = $formbuilder->getForm();

		if ($form->handleRequest($request)->isValid())
		{
			$user = $form->get('user')->getData();
			$roles = $form->get('roles')->getData();

			$user->setRoles($roles);

			$em->persist($user);
			$em->flush();

			$request->getSession()->getFlashBag()->add('info', 'Rôles définient avec succès.');

			return $this->redirect($this->generateUrl('tg_admin_droits'));
		}


    	return $this->render('TGAdminBundle:Admin:droits.html.twig', array(
    		'form' => $form->createView(),
    		'compteslist' => $compteslist
    		));
    }

    /**
    * @Security("has_role('ROLE_ATELIER')")
    */
    public function recetteAction(request $request)
    {
       if ($request->request->get('recette'))
        {
            $content = $request->request->get('recette');
            $rapporteur = $this->get('security.context')->getToken()->getUser();

            $message = \Swift_Message::newInstance()
            ->setSubject('Rapport de bug')
            ->setFrom('recette@technograv.fr')
            ->setTo('nicolas.michel@technograv.fr')
            ->setBody($this->renderView('TGAdminBundle:Admin:email.txt.twig', array(
            'rapporteur' => $rapporteur,
            'content' => $content
              )));

        $this->get('mailer')->send($message);

        $request->getSession()->getFlashBag()->add('info', 'Message envoyé avec succès.');
        }
        return $this->redirect($this->generateUrl('tg_prod_home'));
    }

/*    public function searchAction(request $request)
    {
        $query = $request->get('search');

        $indexprojet1 = $this->container->get('fos_elastica.index.test1.projet');
        $searchprojet1 = new \Elastica\Query\QueryString();
        $boolprojet1 = new \Elastica\Query\Bool();
        $searchprojet1->setDefaultField('titre');
        $searchprojet1->setQuery($query);
        $searchprojet1->setDefaultOperator('AND');
        $boolprojet1->addMust($searchprojet1);
        $projets1 = $indexprojet1->search($boolprojet1)->getResults();

        $indexprojet2 = $this->container->get('fos_elastica.index.test1.projet');
        $searchprojet2 = new \Elastica\Query\QueryString();
        $boolprojet2 = new \Elastica\Query\Bool();
        $searchprojet2->setDefaultField('contenu');
        $searchprojet2->setQuery($query);
        $searchprojet2->setDefaultOperator('AND');
        $boolprojet2->addMust($searchprojet2);
        $projets2 = $indexprojet2->search($boolprojet2)->getResults();

        $projets = array_merge($projets1, $projets2);

            return $this->render('TGProdBundle:Projet:resultats.html.twig', array(
                'projets' => $projets));    
      //  }
    } */

        /**
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function stockAction(request $request)
    {
        $stock = new Stock;
        $dimension = new Dimension;

        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');

        $stocklist = $em->getRepository('TGComptaBundle:Stock')->FindAllOrderedByName();
        $dimensionlist = $em->getRepository('TGComptaBundle:Dimension')->FindAllOrderedByName();

        $formstock = $this->get('form.factory')->create(new StockType, $stock);
        $formdimension = $this->get('form.factory')->create(new DimensionType, $dimension);

         if ($formstock->handleRequest($request)->isValid())
         {
             $em->persist($stock);
             $dimensions = $stock->getDimensions();
             foreach ($dimensions as $dimension) {
                 $besoin = new Besoin;
                 $besoin->setNombre(0);
                 $besoin->setStock($stock);
                 $besoin->setDimension($dimension);
                 $em->persist($besoin);
             }
             $em->flush();

             $request->getSession()->getFlashBag()->add('info', 'Matière ajoutée avec succès.');

             return $this->redirect($this->generateUrl('tg_admin_stocks'));
         }

         if ($formdimension->handleRequest($request)->isValid())
         {
             $em->persist($dimension);
             $em->flush();

             $request->getSession()->getFlashBag()->add('info', 'Dimension ajoutée avec succès.');

             return $this->redirect($this->generateUrl('tg_admin_stocks'));
         }

        return $this->render('TGAdminBundle:Admin:stocks.html.twig', array(
            'stocklist' => $stocklist,
            'dimensionlist' => $dimensionlist,
            'formstock' => $formstock->createView(),
            'formdimension' => $formdimension->createView()));
    }
}
