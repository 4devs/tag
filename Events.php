<?php

namespace FDevs\Tag;

final class Events
{
    const TAG_CREATE = 'fdevs_tag.tag.create';
    const TAG_PRE_PERSIST = 'fdevs_tag.tag.pre_persist';
    const TAG_POST_PERSIST = 'fdevs_tag.tag.post_persist';
    const TAG_PRE_REMOVE = 'fdevs_tag.tag.pre_remove';
    const TAG_POST_REMOVE = 'fdevs_tag.tag.post_remove';
}
