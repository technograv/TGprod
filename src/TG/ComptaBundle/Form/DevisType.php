<?php

namespace TG\ComptaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DevisType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file')
            ->add('infos', 'textarea', array('required' => false))
            ->add('numero', 'text', array('required' => false))
            ->add('prixHT', 'text', array('required' => false))
            ->add('tva', 'text', array('required' => false))
            ->add('prixttc', 'text', array('required' => false))
            ->add('acompte', 'text', array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TG\ComptaBundle\Entity\Devis'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tg_comptabundle_devis';
    }
}
