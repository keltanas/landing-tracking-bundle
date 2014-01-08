<?php

namespace keltanas\Bundle\TrackingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RfqType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('form')
            ->add('title', 'hidden')
            ->add('button', 'hidden')
            ->add('name')
            ->add('phone')
            ->add('ip')
            ->add('history_id')
//            ->add('history')
            ->add('createdAt', 'datetime', [
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd HH:mm:ss',
                ])
            ->add('numberEntry', 'hidden')
            ->add('status', 'choice', [
                    'choices' => [
                        0=>'Не обработан',
                        1=>'Назначен ответственный',
                        2=>'Уточнение информации',
                        3=>'Не удалось связаться',
                        4=>'В обработке',
                        5=>'Обработка приостановлена',
                        6=>'Восстановлен',
                        7=>'Обработка завершена',
                    ]
                ])
            ->add('result')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'keltanas\Bundle\TrackingBundle\Entity\Rfq'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'keltanas_trackingbundle_rfq';
    }
}
