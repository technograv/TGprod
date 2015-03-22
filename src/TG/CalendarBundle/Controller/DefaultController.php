<?php

namespace TG\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TGCalendarBundle:Default:index.html.twig', array('name' => $name));
    }
}
