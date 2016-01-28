<?php

namespace TG\ComptaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HeuresupType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('chantier')
            ->add('date', 'genemu_jquerydate', array(
                'widget' => 'single_text',
                'required' => false))
            ->add('nombre', 'choice', array(
                'choices' => array('0,5' => '1/2 heure', '1' => '1 heure', '1,5' => '1 heure et demi', '2' => '2 heures'),
                'multiple' => false,
                'empty_value' => 'Nombre d\'heure'))
            ->add('save', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TG\ComptaBundle\Entity\Heuresup'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tg_comptabundle_Heuresup';
    }
}
