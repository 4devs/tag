<?php

namespace FDevs\Tag\Form\EventListener;

use Cocur\Slugify\Slugify;
use FDevs\Tag\Model\Tag;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class SlugFormSubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return [FormEvents::SUBMIT => 'submitData'];
    }

    /**
     * {@inheritDoc}
     */
    public function submitData(FormEvent $event)
    {
        $data = $event->getData();
        if ($data instanceof Tag && !$data->getSlug() && $data->getName()->count() && $name = $data->getName()->first()->getText()) {
            $data->setSlug(Slugify::create()->slugify($name));
        }
    }
}
