<?php

namespace TG\ClientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civilite', 'choice', array(
                'choices' => array(
                    'Mme' => 'Mme',
                    'M.' => 'M.'),
                'expanded' => true
                ))
            ->add('name', 'text')
            ->add('tel', 'text')
            ->add('portable', 'text', array('required' => false))
            ->add('fax', 'text', array('required' => false))
            ->add('email', 'text', array('required' => false))
            ->add('defaut', 'checkbox', array('required' => false))
            ->add('save', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TG\ClientBundle\Entity\Contact'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tg_clientbundle_contact';
    }
}
