<?php

namespace TG\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TG\UserBundle\Entity\User;
use TG\ProdBundle\Entity\Type;
use TG\ProdBundle\Form\TypeType;
use TG\ProdBundle\Entity\Etape;
use TG\ProdBundle\Form\EtapeType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminController extends Controller
{
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();

    	$typeslist = $em->getRepository('TGProdBundle:Type')->FindAll();
    	$etapeslist = $em->getRepository('TGProdBundle:Etape')->FindAll();

       return $this->render('TGAdminBundle:Admin:index.html.twig', array(
        	'typeslist' => $typeslist,
        	'etapeslist' => $etapeslist));
    }

    public function typesAction(request $request)
    {
    	$type = new Type;

        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');

    	$typeslist = $em->getRepository('TGProdBundle:Type')->FindAll();

        if (isset($_GET['type']))
        {
            $edittype = $em->getRepository('TGProdBundle:Type')->find($request->query->get('type'));

            if ($edittype != null)
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

    public function etapesAction(request $request)
    {
        $etape = new Etape;

    	$em = $this->getDoctrine()->getManager();
        $request = $this->get('request');

    	$etapeslist = $em->getRepository('TGProdBundle:Etape')->FindAll();

        if (isset($_GET['etape']))
        {
            $editetape = $em->getRepository('TGProdBundle:Etape')->find($request->query->get('etape'));

            if ($editetape != null)
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

    public function comptesAction()
    {
    	$em = $this->getDoctrine()->getManager();

    	$compteslist = $em->getRepository('TGUserBundle:User')->FindAll();

    	return $this->render('TGAdminBundle:Admin:comptes.html.twig', array(
    		'compteslist' => $compteslist));
    }

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
					'choices' =>array(
						'ROLE_atelier' => 'Atelier',
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

    public function recetteAction(request $request)
    {
       if (isset($_POST['recette']))
        {
            $content = $_POST['recette'];
            $rapporteur = $this->get('security.context')->getToken()->getUser();

            $message = \Swift_Message::newInstance()
            ->setSubject('Rapport de bug')
            ->setFrom('recette@technograv.com')
            ->setTo('nicolas.michel2008@gmail.com')
            ->setBody($this->renderView('TGAdminBundle:Admin:email.txt.twig', array(
            'rapporteur' => $rapporteur,
            'content' => $content
              )));

        $this->get('mailer')->send($message);
        }
        return $this->redirect($this->generateUrl('tg_prod_home'));
    }
}
