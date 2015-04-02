<?php

namespace TG\ClientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ClientEditType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->remove('logofile')
			->remove('logoinfos')
			->remove('contacts')
		;
	}
	
  	public function getParent()
  	{
    	return new ClientType();
  	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'tg_clientbundle_client_edit';
	}
}
