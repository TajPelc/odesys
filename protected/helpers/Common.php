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

    /**
     * Generates a random string
     *
     * @param $length
     * @param $chars
     */
    public static function randomString($length = 32, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890')
     {
         // Length of character list
         $chars_length = (strlen($chars) - 1);

         // Start our string
         $string = $chars{rand(0, $chars_length)};

         // Generate random string
         for ($i = 1; $i < $length; $i = strlen($string))
         {
             // Grab a random character from our list
             $r = $chars{rand(0, $chars_length)};

             // Make sure the same two characters don't appear next to each other
             if ($r != $string{$i - 1}) $string .=  $r;
         }

         // Return the string
         return $string;
     }
}