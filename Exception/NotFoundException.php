<?php

namespace FDevs\Tag\Exception;

class NotFoundException extends Exception
{
    /**
     * NotFoundException constructor.
     *
     * @param string         $slug
     * @param string         $type
     * @param int            $code
     * @param Exception|null $previous
     */
    public function __construct($slug, $type, $code = 0, Exception $previous = null)
    {
        $message = sprintf('Tag with slug "%s" and tag "%s" not found', $slug, $type);
        parent::__construct($message, $code, $previous);
    }
}
