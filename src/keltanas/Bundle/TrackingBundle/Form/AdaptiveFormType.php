<?php
/**
 *
 * @author: Nikolay Ermin <keltanas@gmail.com>
 */

namespace keltanas\Bundle\TrackingBundle\Form;

use keltanas\Bundle\TrackingBundle\Entity\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class AdaptiveFormType extends AbstractType
{
    /** @var Form */
    private $entity = null;

    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', [
                'attr' => [
                    'placeholder'=>'Иван Иванов',
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ]);
        $builder->add('phone', 'text', [
                'attr' => [
                    'placeholder'=>'+7 900 555-55-55',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Regex('/(\+?\d?)[-. ]?\(?(\d{3})\)?[-. ]?(\d{3})[-. ]?(\d{2,4})[-. ]?(\d{2,4})$/'),
                ]
            ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return $this->entity ? $this->entity->getName() : 'fail';
    }
}
