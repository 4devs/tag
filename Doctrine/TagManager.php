<?php

namespace FDevs\Tag\Doctrine;

use Cocur\Slugify\Slugify;
use FDevs\Tag\Event\TagEvent;
use FDevs\Tag\Events;
use FDevs\Tag\Exception\NotFoundException;
use FDevs\Tag\Model\Tag;
use FDevs\Tag\TagInterface;
use FDevs\Tag\TagManagerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class TagManager implements TagManagerInterface
{
    /** @var ObjectManager */
    protected $objectManager;

    /** @var TagRepositoryInterface */
    protected $repository;

    /** @var bool */
    protected $flush = true;

    /** @var null|int */
    private $limit = null;

    /** @var null|int */
    private $offset = null;

    /** @var EventDispatcherInterface */
    protected $dispatcher = null;

    /** @var array */
    private $criteria = [];

    /**
     * init
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $objectManager
     * @param TagRepositoryInterface                     $repository
     * @param EventDispatcherInterface|null              $dispatcher
     */
    public function __construct(ObjectManager $objectManager, TagRepositoryInterface $repository, EventDispatcherInterface $dispatcher = null)
    {
        $this->objectManager = $objectManager;
        $this->repository = $repository;
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
        return $this->repository->getClassName();
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
        $this->dispatch(Events::TAG_CREATE, $tag);

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
    public function findBy(array $criteria = [], $limit = 10, $offset = 0)
    {
        $criteria = array_merge($this->criteria, $criteria);

        $limit = is_int($this->limit) ? $this->limit : $limit;
        $offset = is_int($this->offset) ? $this->offset : $offset;

        return $this->repository->findBy($criteria, null, $limit, $offset);
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
    public function getBySlugAndType($slug, $type)
    {
        $tag = $this->repository->findOneBy(['slug' => $slug, 'type' => $type]);
        if (!$tag) {
            throw new NotFoundException($slug, $type);
        }

        return $tag;
    }

    /**
     * {@inheritDoc}
     */
    public function findByIds(array $ids)
    {
        return $this->repository->findByIds($ids);
    }

    /**
     * @param string       $eventName
     * @param TagInterface $tag
     *
     * @return $this
     */
    protected function dispatch($eventName, TagInterface $tag)
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

    /**
     * @param int|null $limit
     *
     * @deprecated since 1.2
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * @param int|null $offset
     *
     * @deprecated since 1.2
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
    }
}
