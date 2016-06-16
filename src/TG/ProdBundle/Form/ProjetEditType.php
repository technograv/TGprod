<?php

namespace TG\ProdBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProjetEditType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->remove('documentjoints')
			->remove('client')
			->remove('contact');
	}
	
  	public function getParent()
  	{
    	return new ProjetType();
  	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'tg_prodbundle_projet_edit';
	}
}
