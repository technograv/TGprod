<?php

namespace TG\ProdBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProjetNextType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('published')
            ->remove('delai')
            ->remove('type')
            ->remove('titre')
            ->remove('contenu')
            ->remove('client')
            ->remove('devix')
            ->remove('factures')
            ->remove('creas')
            ->remove('save');
    }
   
    public function getParent()
  {
    return new ProjetType();
  }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tg_prodbundle_projet_next_projet';
    }
}
