<?php

namespace FDevs\Tag\Event;

use FDevs\Tag\TagInterface;
use Symfony\Component\EventDispatcher\Event;

class TagEvent extends Event
{
    private $tag;

    /**
     * Constructs an event.
     *
     * @param TagInterface $tag
     */
    public function __construct(TagInterface $tag)
    {
        $this->tag = $tag;
    }

    /**
     * Returns the tag for this event.
     *
     * @return TagInterface
     */
    public function getTag()
    {
        return $this->tag;
    }
}
