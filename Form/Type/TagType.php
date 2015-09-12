<?php

namespace FDevs\Tag\Form\Type;

use FDevs\Tag\Form\EventListener\SlugFormSubscriber;
use Symfony\Component\Form\AbstractType;
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
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'choice', ['choices' => $options['type_list']])
            ->add('name', 'trans_text')
            ->add('description', 'trans_textarea', ['required' => false])
            ->add('slug', 'text', ['required' => false])
            ->addEventSubscriber(new SlugFormSubscriber());
    }

    /**
     * {@inheritDoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'type_list'          => $this->typeList,
                'data_class'         => 'FDevs\Tag\Model\Tag',
                'cascade_validation' => true,
            ])
            ->setDefined(['type_list'])
            ->addAllowedTypes(['type_list' => 'array']);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'fdevs_tag';
    }
}
