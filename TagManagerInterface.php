<?php
namespace FDevs\Tag;

use Doctrine\Common\Collections\Collection;
use FDevs\Tag\Exception\NotFoundException;

interface TagManagerInterface
{
    /**
     * create Tag
     *
     * @return TagInterface
     */
    public function createTag();

    /**
     * set Base Criteria
     *
     * @param array $criteria
     *
     * @return self
     */
    public function setDefaultCriteria(array $criteria = []);

    /**
     * get Tag By Id
     *
     * @param string $id
     *
     * @return TagInterface|null
     */
    public function find($id);

    /**
     * find tags by array criteria
     *
     * @param array $criteria
     * @param int   $limit
     * @param int   $offset
     *
     * @return array|Collection|TagInterface[]
     */
    public function findBy(array $criteria = [], $limit = 10, $offset = 0);

    /**
     * find one by slug and type
     *
     * @param string $slug
     * @param string $type
     *
     * @return TagInterface
     *
     * @throws NotFoundException
     */
    public function getBySlugAndType($slug, $type);

    /**
     * find Tags by array ids
     *
     * @param array $ids
     *
     * @return array|Collection|TagInterface[]
     */
    public function findByIds(array $ids);

    /**
     * get Class tag
     *
     * @return string
     */
    public function getClass();

    /**
     * update Tag
     *
     * @param \FDevs\Tag\TagInterface $tag
     *
     * @return self
     */
    public function updateTag(TagInterface $tag);

    /**
     * delete Tag
     *
     * @param \FDevs\Tag\TagInterface $tag
     *
     * @return self
     */
    public function removeTag(TagInterface $tag);

    /**
     * get All Tags
     *
     * @return array|Collection|TagInterface[]
     */
    public function findTags();
}
