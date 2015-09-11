<?php

namespace FDevs\Tag\Doctrine;

use Doctrine\Common\Persistence\ObjectRepository;
use FDevs\Tag\TagInterface;
use Doctrine\Common\Collections\Collection;

interface TagRepositoryInterface extends ObjectRepository
{
    /**
     * @param array $ids
     *
     * @return array|Collection|TagInterface[]
     */
    public function findByIds(array $ids = []);
}
