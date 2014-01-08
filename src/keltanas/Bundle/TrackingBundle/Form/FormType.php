<?php

namespace keltanas\Bundle\TrackingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', [
                    'label' => 'form.name',
                ])
            ->add('email', 'text', [
                    'label' => 'form.email',
                ])
            ->add('title', 'text', [
                    'label' => 'form.title',
                ])
            ->add('button', 'text', [
                    'label' => 'form.button',
                ])
            ->add('template', 'choice', [
                    'label' => 'form.template',
                    'choices' => [
                        'keltanasTrackingBundle:Form:form.html.twig' => 'normal',
                        'keltanasTrackingBundle:Form:form_horizontal.html.twig' => 'horizontal',
                        'keltanasTrackingBundle:Form:form_modal.html.twig' => 'modal',
                    ]
                ])
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'keltanas\Bundle\TrackingBundle\Entity\Form'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'keltanas_trackingbundle_form';
    }
}
