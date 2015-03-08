<?php

namespace TG\CreaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CreaaddType extends AbstractType
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
    public function getName()
    {
        return 'tg_creabundle_crea_add';
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return new CreaType();
    }
}
