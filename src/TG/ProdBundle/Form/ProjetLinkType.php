<?php

namespace TG\ProdBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use TG\ProdBundle\Entity\ProjetRepository;

class ProjetLinkType extends AbstractType
{
    public function __construct($projet)
    {
        $this->projet = $projet;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $projet = $this->projet;

        $builder
            ->add('projetparent', 'entity', array(
                                'label'=> ' ',
                                'class' => 'TGProdBundle:Projet',
                                'property' => 'titre',
                                'query_builder' => function(ProjetRepository $er) use ($projet)
                                                            {
                                                                return $er->getProjetPourLier($projet);
                                                            },
                                'multiple' => false,
                                'empty_value' => 'Liaisons possibles',
                                'empty_data' => null))                   
            ->add('lier', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TG\ProdBundle\Entity\Projet'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tg_prodbundle_projet';
    }
}
