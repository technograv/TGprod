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
            ->add('projet', new ProjetNextType())
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
