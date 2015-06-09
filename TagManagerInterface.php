<?php
namespace FDevs\Tag;

use Doctrine\Common\Collections\Collection;

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
     * find Tag By Id
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
     *
     * @return array|Collection|TagInterface[]
     */
    public function findBy(array $criteria = []);

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

    /**
     * set Limit
     *
     * @param int|null $limit
     *
     * @return self
     */
    public function setLimit($limit);

    /**
     * set offset
     *
     * @param int|null $offset
     *
     * @return self
     */
    public function setOffset($offset);
}
