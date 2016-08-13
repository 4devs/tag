<?php

namespace FDevs\Tag;

final class Events
{
    /**
     * The CREATE event is dispatched then tag create.
     *
     * The event listener method receives a FDevs\Tag\Event\TagEvent instance
     *
     * @Event
     *
     * @var string
     */
    const TAG_CREATE = 'fdevs_tag.tag.create';

    /**
     * The TAG_PRE_PERSIST event is dispatched then tag pre persist in db.
     *
     * The event listener method receives a FDevs\Tag\Event\TagEvent instance
     *
     * @Event
     *
     * @var string
     */
    const TAG_PRE_PERSIST = 'fdevs_tag.tag.pre_persist';

    /**
     * The TAG_POST_PERSIST event is dispatched then tag post persist in db.
     *
     * The event listener method receives a FDevs\Tag\Event\TagEvent instance
     *
     * @Event
     *
     * @var string
     */
    const TAG_POST_PERSIST = 'fdevs_tag.tag.post_persist';

    /**
     * The TAG_PRE_REMOVE event is dispatched then tag pre remove from db.
     *
     * The event listener method receives a FDevs\Tag\Event\TagEvent instance
     *
     * @Event
     *
     * @var string
     */
    const TAG_PRE_REMOVE = 'fdevs_tag.tag.pre_remove';

    /**
     * The TAG_PRE_REMOVE event is dispatched then tag post remove from db.
     *
     * The event listener method receives a FDevs\Tag\Event\TagEvent instance
     *
     * @Event
     *
     * @var string
     */
    const TAG_POST_REMOVE = 'fdevs_tag.tag.post_remove';
}
