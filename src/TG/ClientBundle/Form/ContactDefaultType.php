<?php

namespace TG\ClientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactDefaultType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->remove('defaut')
			->remove('name')
			->remove('save')
			->add('name', 'text', array(
				'required' => false))
		;
	}
	
  	public function getParent()
  	{
    	return new ContactType();
  	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'tg_clientbundle_contact_default';
	}
}
