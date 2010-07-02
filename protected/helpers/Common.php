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

    /**
     * Truncate
     *
     * @param $text
     * @param $length
     */
    public static function truncate($text, $length) {
        $length = abs((int)$length);
        if(strlen($text) > $length) {
          $text = preg_replace("/^(.{1,$length})(\s.*|$)/s", '\\1...', $text);
        }
        return($text);
    }
}