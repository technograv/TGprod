<?php

namespace TG\ProdBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class NextType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('assign', 'entity', array(
                'label' => 'Assigné à',
                'class' => 'TGUserBundle:User',
                'property' => 'username',
                'mapped' => false,
                'multiple' => false,
                'empty_value' => 'Liste des utilisateurs'))
            ->add('etape', 'entity', array(
                'label' => 'Etape en cours',
                'class' => 'TGProdBundle:Etape',
                'property' => 'name',
                'mapped' => false,
                'multiple' => false,
                'empty_value' => 'Liste des étapes'))
            ->add('save',       'submit')
        ;
    }
    
    public function getParent()
  {
    return new CommentaireType();
  }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tg_prodbundle_projet_next';
    }
}
