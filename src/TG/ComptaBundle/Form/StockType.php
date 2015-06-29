<?php

namespace TG\ComptaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StockType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('prix')
            ->add('dimensions', 'entity', array(
                'class' => 'TGComptaBundle:Dimension',
                'property' => 'name',
                'multiple' => true))
            ->add('valider', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TG\ComptaBundle\Entity\Stock'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tg_comptabundle_stock';
    }
}
