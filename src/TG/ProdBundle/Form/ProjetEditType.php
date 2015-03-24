<?php

namespace TG\ProdBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProjetEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('published')
            ->remove('contact')
            ->remove('client')
            ->remove('devix')
            ->remove('factures')
            ->remove('creas')
            ->remove('docfile');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tg_prodbundle_projet_edit';
    }

    public function getParent()
  {
    return new ProjetType();
  }
}
