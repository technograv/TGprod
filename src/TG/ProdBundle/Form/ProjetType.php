<?php

namespace TG\ProdBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use TG\ClientBundle\Entity\ClientRepository;
use TG\ClientBundle\Entity\Client;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ProjetType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('published',  'checkbox', array('required' => false))
            ->add('assign',     'entity', array(
                'label' => 'Assigner à',
                'class' => 'TGUserBundle:User',
                'property' => 'username',
                'multiple' => false,
                'empty_value' => 'Liste des utilisateurs'))
            ->add('type',     'entity', array(
                'label' => 'Nature du projet',
                'class' => 'TGProdBundle:Type',
                'property' => 'name',
                'multiple' => false,
                'empty_value' => 'Liste des types de projet'))
            ->add('etape',     'entity', array(
                'label' => 'Etape en cours',
                'class' => 'TGProdBundle:Etape',
                'property' => 'name',
                'multiple' => false,
                'empty_value' => 'Liste des étapes'))
            ->add('avancement', 'genemu_jquerydate', array(
                'widget' => 'single_text',
                'required' => true))
            ->add('titre',      'text')
            ->add('livraison', 'choice', array(
                    'choices' => array('Retrait au magasin', 'Envoi postal', 'Déplacement chez le client'),
                    'multiple' => false,
                    'empty_value' => 'Liste des types de livraison'))
            ->add('delai', 'genemu_jquerydate', array(
                'widget' => 'single_text',
                'required' => true))
            ->add('contenu',    'textarea', array(
                'attr' =>array('class' => 'ckeditor')))
            ->add('client', 'entity', array(
                'label' => 'Liste des Clients',
                'class' => 'TGClientBundle:Client',
                'property' => 'name',
                'query_builder' => function(ClientRepository $er)
                {
                    return $er->createQueryBuilder('c')
                    ->orderBy('c.name', 'ASC');
                },
                'multiple' => false,
                'empty_value' => 'Liste des clients'))
            ->add('documentjoints', 'collection', array(
                'label' => 'Pièce jointe',
                'type' => new DocumentjointProdType(),
                'required' => false))
            ->add('save',       'submit')
        ;

        $formModifier = function (FormInterface $form, Client $client = null) {
            $contacts = null === $client ? array() : $client->getContacts();

            $form->add('contact', 'entity', array(
                'class' => 'TGClientBundle:Contact',
                'choices' => $contacts,
                ));
        };

        $builder->addEventListener(FormEvents::PRE_SET_DATA,
            function(FormEvent $event) use ($formModifier)
            {
                $data = $event->getData();
                $formModifier($event->getForm(), $data->getClient());                    
            });

        $builder->get('client')->addEventListener(FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $client = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $client);
            });
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
