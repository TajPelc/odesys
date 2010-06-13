<?php

/**
 * Common helper
 *
 * @author Taj
 *
 */
class Common
{
    /**
     * Is this a valid array
     *
     * return boolean
     */
    public static function isArray($var)
    {
        return is_array($var) && count($var) > 0;
    }
}