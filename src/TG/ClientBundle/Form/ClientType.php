<?php

namespace TG\ClientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use TG\CreaBundle\Form\LogoType;
use TG\CreaBundle\Entity\LogoRepository;

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
		->add('cp',			'integer')
		->add('ville',		'text')
		->add('pays',		'text')
		->add('tel',		'text')
		->add('fax',		'text', array('required' => false))
		->add('email',		'email', array('required' => false))
		->add('contact',	'text', array('required' => false))
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
