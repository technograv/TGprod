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
            ->add('file', 'file')
            ->add('infos')
            ->add('numero', 'text')
            ->add('prixHT', 'text')
            ->add('tva', 'text')
            ->add('prixttc', 'text')
            ->add('acompte', 'text')
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
