<?php

namespace TG\ProdBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use TG\ProdBundle\Entity\EtapeRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProjetNextAtelierType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('recap', 'textarea')
            ->add('assign', 'entity', array(
                'label' => 'Assigner à',
                'class' => 'TGUserBundle:User',
                'property' => 'username',
                'multiple' => false,
                'empty_value' => 'Liste des utilisateurs'))
            ->add('etape',     'entity', array(
                'label' => 'Etape en cours',
                'class' => 'TGProdBundle:Etape',
                'property' => 'name',
                'query_builder' => function(EtapeRepository $er)
                {
                    return $er->createQueryBuilder('e')
                    ->where('e.id NOT IN (:id)')
                    ->setParameter('id', array(1, 4, 6, 18, 25, 26))
                    ->orderBy('e.name', 'ASC');
                },
                'multiple' => false,
                'empty_value' => 'Liste des étapes'))
            ->add('avancement', 'genemu_jquerydate', array(
                'widget' => 'single_text',
                'required' => true));
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
        return 'tg_prodbundle_projet_next';
    }
}
