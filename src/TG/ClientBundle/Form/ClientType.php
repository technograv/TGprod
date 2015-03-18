<?php

namespace TG\ClientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		->add('name',		'text')
		->add('adresse',	'text')
		->add('cp',			'text')
		->add('ville',		'text')
		->add('pays',		'text')
		->add('code',		'text', array('required' => false))
		->add('siret',		'text', array('required' => false))
		->add('logofile',	'file', array(
			'mapped' => false,
			'required' => false))
		->add('logoinfos',	'textarea', array(
			'mapped' => false,
			'required' => false))
		->add('notes',		'textarea', array(
			'required' => false,
			'attr' =>array('class' => 'ckeditor')))
		->add('contactname',	'text', array(
			'mapped' => false,
			'required' => false))
		->add('contacttel',	'text', array(
			'mapped' => false,
			'required' => true))
		->add('contactport',	'text', array(
			'mapped' => false,
			'required' => false))
		->add('contactemail',		'email', array(
			'required' => false,
			'mapped' => false,
			'required' => false))
		->add('contactfax',		'text', array(
			'required' => false,
			'mapped' => false,
			'required' => false))
		->add('save',		'submit')
		;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'TG\ClientBundle\Entity\Client'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'tg_clientbundle_client';
	}
}
