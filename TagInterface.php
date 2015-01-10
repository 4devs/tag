<?php

namespace FDevs\Tag;

use FDevs\Locale\LocaleTextInterface;

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
     * @param \FDevs\Locale\LocaleTextInterface $name
     *
     * @return self
     */
    public function addName(LocaleTextInterface $name);

    /**
     * get name
     *
     * @return \Doctrine\Common\Collections\Collection|\FDevs\Locale\Model\LocaleText[]
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
