<?php

namespace TG\ProdBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CommentaireProdType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('save')
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
        return 'tg_prodbundle_commentaire_prod';
    }
}
