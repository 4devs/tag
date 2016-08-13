<?php

namespace FDevs\Tag\Form\Type;

use FDevs\Locale\Form\Type\TransTextareaType;
use FDevs\Locale\Form\Type\TransTextType;
use FDevs\Tag\Form\EventListener\SlugFormSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagType extends AbstractType
{
    /** @var array */
    private $typeList = [];

    /**
     * @param array $typeList
     */
    public function __construct(array $typeList = [])
    {
        $this->typeList = $typeList;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, ['choices' => $options['type_list']])
            ->add('name', TransTextType::class)
            ->add('description', TransTextareaType::class, ['required' => false])
            ->add('slug', TextType::class, ['required' => false])
            ->addEventSubscriber(new SlugFormSubscriber())
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefined(['type_list'])
            ->setDefaults([
                'type_list' => $this->typeList,
                'data_class' => 'FDevs\Tag\Model\Tag',
                'cascade_validation' => true,
            ])
            ->addAllowedTypes('type_list', ['array'])
        ;
    }
}
