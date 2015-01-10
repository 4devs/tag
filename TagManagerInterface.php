<?php
namespace FDevs\Tag;

interface TagManagerInterface
{
    /**
     * create Tag
     *
     * @return TagInterface
     */
    public function createTag();

    /**
     * find Tag By Slug And Type
     *
     * @param string $slug
     * @param string $type
     *
     * @return TagInterface|null
     */
    public function findBySlugAndType($slug, $type);

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
     * @return \Doctrine\Common\Collections\Collection|TagInterface[]
     */
    public function findBy(array $criteria);

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
     * @return \Doctrine\Common\Collections\Collection|TagInterface[]
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
