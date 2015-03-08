<?php

namespace TG\ProdBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use TG\ComptaBundle\Form\DevisType;
use TG\ComptaBundle\Form\FactureType;
use TG\CreaBundle\Form\CreaType;
use TG\ClientBundle\Entity\ClientRepository;

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
