<?php

namespace TG\CreaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LogoEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('valider', 'submit')
        ;
    }
    
    public function getParent()
    {
        return new LogoType();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tg_creabundle_logo_edit';
    }
}
