<?php

namespace TG\ProdBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentaireType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contenu',    'textarea')
            ->add('save',       'submit', array(
                'label' => 'Valider'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TG\ProdBundle\Entity\Commentaire'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tg_prodbundle_commentaire';
    }
}
