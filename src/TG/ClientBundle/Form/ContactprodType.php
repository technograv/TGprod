<?php

namespace TG\ClientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use TG\ClientBundle\Entity\ClientRepository;

class ContactprodType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('client', 'entity', array(
                'label'=> 'Liste des Clients',
                'class' => 'TGClientBundle:Client',
                'property' => 'name',
                'query_builder' => function(ClientRepository $er)
                {
                    return $er->createQueryBuilder('c')
                    ->orderBy('c.name', 'ASC');
                },
                'multiple' => false,
                'empty_value' => 'Liste des clients'))
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
		return 'tg_clientbundle_contact_prod';
	}
}
