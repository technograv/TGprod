<?php

namespace TG\ComptaBundle\Form;

use Symfony\Component\Form\AbstractType;
use TG\ComptaBundle\Entity\StockRepository;
use TG\ComptaBundle\Entity\Stock;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class BesoinType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('stock', 'entity', array(
                'label' => 'Liste des matériaux',
                'class' => 'TGComptaBundle:Stock',
                'property' => 'name',
                'query_builder' => function(StockRepository $er)
                {
                    return $er->createQueryBuilder('s')
                    ->orderBy('s.name', 'ASC');
                },
                'multiple' => false,
                'empty_value' => 'Liste des materiaux'))
            ->add('nombre', 'integer');

    $formModifier = function (FormInterface $form, Stock $stock = null) {
        $dimensions = null === $stock ? array() : $stock->getDimensions();

        $form->add('dimension', 'entity', array(
            'class' => 'TGComptaBundle:Dimension',
            'choices' => $dimensions,
            'property' => 'name',
            'empty_value' => 'Liste des dimensions'
            ));
    };

    $builder->addEventListener(FormEvents::PRE_SET_DATA,
        function(FormEvent $event) use ($formModifier)
        {
            $data = $event->getData();
            $formModifier($event->getForm(), $data->getDimension());
        });

    $builder->get('stock')->addEventListener(FormEvents::POST_SUBMIT,
        function (FormEvent $event) use ($formModifier) {
            $stock = $event->getForm()->getData();
            $formModifier($event->getForm()->getParent(), $stock); 
        });
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TG\ComptaBundle\Entity\Besoin'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tg_comptabundle_besoin';
    }
}
