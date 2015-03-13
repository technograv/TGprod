<?php

namespace TG\ProdBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use TG\ComptaBundle\Form\DevisType;
use TG\ComptaBundle\Form\FactureType;
use TG\CreaBundle\Form\CreaType;
use TG\ClientBundle\Entity\ClientRepository;

class ProjetType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('published',  'checkbox', array('required' => false))
            ->add('assign',     'entity', array(
                'label' => 'Assigner à',
                'class' => 'TGUserBundle:User',
                'property' => 'username',
                'multiple' => false))
            ->add('type',     'entity', array(
                'label' => 'Nature du projet',
                'class' => 'TGProdBundle:Type',
                'property' => 'name',
                'multiple' => false))
            ->add('etape',     'entity', array(
                'label' => 'Etape en cours',
                'class' => 'TGProdBundle:Etape',
                'property' => 'name',
                'multiple' => false))
            ->add('titre',      'text')
            ->add('contenu',    'textarea', array(
                'attr' =>array('class' => 'ckeditor')))
            ->add('client', 'entity', array(
                'label'=> 'Liste des Clients',
                'class' => 'TGClientBundle:Client',
                'property' => 'name',
                'query_builder' => function(ClientRepository $er)
                {
                    return $er->createQueryBuilder('c')
                    ->orderBy('c.name', 'ASC');
                },
                'multiple' => false))                         
            ->add('save',       'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TG\ProdBundle\Entity\Projet'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tg_prodbundle_projet';
    }
}
