<?php

namespace FDevs\Tag\Doctrine\Mongodb;

use Doctrine\ODM\MongoDB\DocumentRepository;
use FDevs\Tag\Doctrine\TagRepositoryInterface;

class TagRepository extends DocumentRepository implements TagRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function findByIds(array $ids = [])
    {
        $qb = $this->createQueryBuilder()
            ->field('_id')->in($ids)
        ;

        return $qb->getQuery()->execute();
    }
}
