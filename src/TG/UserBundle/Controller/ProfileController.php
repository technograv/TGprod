<?php

namespace TG\UserBundle\Controller;

use TG\ComptaBundle\Entity\Panier;
use TG\ComptaBundle\Entity\Heuresup;
use TG\ComptaBundle\Form\PanierType;
use TG\ComptaBundle\Form\HeuresupType;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProfileController extends Controller
{
	public function showAction(request $request)
	{
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $em = $this->getDoctrine()->getManager();
        $panier = new Panier();
        $heuresup = new Heuresup();

        $panierform = $this->createForm(new PanierType(), $panier);
        $heuresupform = $this->createForm(new HeuresupType(), $heuresup);

        if ($panierform->handleRequest($request)->isValid())
        {
            $panier->setUser($user);
            $em->persist($panier);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', 'Panier repas ajouté avec succès');
            return $this->redirect($this->generateUrl('fos_user_profile_show'));
        }

        if ($heuresupform->handleRequest($request)->isValid())
        {
            $heuresup->setUser($user);
            $em->persist($heuresup);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', 'Temps de travail supplémentaire ajouté avec succès');
            return $this->redirect($this->generateUrl('fos_user_profile_show'));
        }

        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
                'user' => $user,
                'panierform' => $panierform->createView(),
                'heuresupform' => $heuresupform->createView()));
    }

     public function editAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.profile.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_profile_show');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('FOSUserBundle:Profile:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
