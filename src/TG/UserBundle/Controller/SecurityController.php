<?php

namespace TG\UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseSecurity;

class SecurityController extends BaseSecurity
{
	public function loginnavAction()
	{
    	$csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');
 
    	return $this->container->get('templating')->renderResponse(
    		'FOSUserBundle:Security:login_content.html.twig', array(
        	'last_username' => null,
        	'error'         => null,
        	'csrf_token'    => $csrfToken
    ));
    }
}
