<?php

namespace FDevs\Tag\Doctrine;

use Cocur\Slugify\Slugify;
use FDevs\Tag\Event\TagEvent;
use FDevs\Tag\Events;
use FDevs\Tag\Model\Tag;
use FDevs\Tag\TagInterface;
use FDevs\Tag\TagManagerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class TagManager implements TagManagerInterface
{
    /** @var ObjectManager */
    protected $objectManager;

    /** @var string */
    protected $class;

    /** @var \Doctrine\Common\Persistence\ObjectRepository */
    protected $repository;

    /** @var bool */
    protected $flush = true;

    /** @var null|int */
    protected $limit = null;

    /** @var null|int */
    protected $offset = null;

    /** @var EventDispatcherInterface */
    protected $dispatcher = null;

    /** @var array */
    private $criteria = [];

    /**
     * init
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $objectManager
     * @param string                                     $class
     * @param EventDispatcherInterface                   $dispatcher
     */
    public function __construct(ObjectManager $objectManager, $class, EventDispatcherInterface $dispatcher)
    {
        $this->objectManager = $objectManager;
        $this->class = $class;
        $this->repository = $objectManager->getRepository($class);
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param boolean $flush
     *
     * @return self
     */
    public function setFlush($flush)
    {
        $this->flush = (boolean) $flush;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * {@inheritDoc}
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function createTag()
    {
        $class = $this->getClass();
        $tag = new $class();
        /** @var TagInterface $tag */
        $this->dispatcher->dispatch(Events::TAG_CREATE, new TagEvent($tag));

        return $tag;
    }

    /**
     * {@inheritDoc}
     */
    public function updateTag(TagInterface $tag)
    {
        $name = $tag->getName();
        if (!$tag->getId() && ($tag->getSlug() || $name->count())) {
            $this->refreshSlug($tag, $tag->getSlug() ?: $name->first()->getText());
        }
        $this->dispatch(Events::TAG_PRE_PERSIST, $tag);

        $this->objectManager->persist($tag);

        $this->dispatch(Events::TAG_POST_PERSIST, $tag);
        $this->flush();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function removeTag(TagInterface $tag)
    {
        $this->dispatch(Events::TAG_POST_REMOVE, $tag);

        $this->objectManager->remove($tag);

        $this->dispatch(Events::TAG_POST_REMOVE, $tag);

        $this->flush();

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultCriteria(array $criteria = [])
    {
        $this->criteria = $criteria;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function findBy(array $criteria = [])
    {
        $criteria = array_merge($this->criteria, $criteria);

        return $this->repository->findBy($criteria, null, $this->limit, $this->offset);
    }

    /**
     * {@inheritDoc}
     */
    public function findTags()
    {
        return $this->repository->findAll();
    }

    /**
     * {@inheritDoc}
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @param string               $eventName
     * @param \FDevs\Tag\Model\Tag $tag
     *
     * @return $this
     */
    protected function dispatch($eventName, Tag $tag)
    {
        if ($this->dispatcher) {
            $this->dispatcher->dispatch($eventName, new TagEvent($tag));
        }

        return $this;
    }

    /**
     * @return $this
     */
    private function flush()
    {
        if ($this->flush) {
            $this->objectManager->flush();
        }

        return $this;
    }

    /**
     * refresh tag
     *
     * @param \FDevs\Tag\TagInterface $tag
     * @param string                  $name
     *
     * @return \FDevs\Tag\TagInterface
     */
    private function refreshSlug(TagInterface $tag, $name)
    {
        $slug = Slugify::create()->slugify($name);
        $tag->setId($slug.'~'.crc32($tag->getType()))->setSlug($slug);

        return $tag;
    }
}
