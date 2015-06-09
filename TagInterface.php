<?php

namespace FDevs\Tag;

use FDevs\Locale\LocaleTextInterface;
use Doctrine\Common\Collections\Collection;

interface TagInterface
{
    /**
     * set Id
     *
     * @param string $id
     *
     * @return self
     */
    public function setId($id);

    /**
     * get Id
     *
     * @return string
     */
    public function getId();

    /**
     * add Name
     *
     * @param LocaleTextInterface $name
     *
     * @return self
     */
    public function addName(LocaleTextInterface $name);

    /**
     * get name
     *
     * @return array|Collection|LocaleTextInterface[]
     */
    public function getName();

    /**
     * set Tag Slug
     *
     * @param string $slug
     *
     * @return self
     */
    public function setSlug($slug);

    /**
     * get Tag Slug
     *
     * @return string
     */
    public function getSlug();

    /**
     * set Tag Type
     *
     * @param string $type
     *
     * @return self
     */
    public function setType($type);

    /**
     * get Type
     *
     * @return string
     */
    public function getType();
}
