<?php

namespace TG\ClientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use TG\CreaBundle\Form\LogoType;
use TG\CreaBundle\Entity\LogoRepository;

class ClientEditType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->remove('logos')
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
