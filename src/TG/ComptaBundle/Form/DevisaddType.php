<?php

namespace TG\ComptaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DevisaddType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('save', 'submit')
        ;
    }
    
    /**
     * @return string
     */
    public function getParent()
    {
        return new DevisType();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tg_comptabundle_devis_add';
    }
}
