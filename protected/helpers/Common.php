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
     * Is this a valid array
     *
     * return boolean
     */
    public static function getBaseURL()
    {
        $request = Yii::app()->request;
        return ($request->isSecureConnection ? 'https://' : 'http://' ) . $request->getServerName();
    }

    /**
     * Truncate
     *
     * @param $text
     * @param $length
     */
    public static function truncate($text, $length)
    {
        $length = abs((int)$length);
        if(strlen($text) > $length) {
            $text = preg_replace("/^(.{1,$length})(\s.*|$)/s", '\\1...', $text);
        }
        return($text);
    }

    /**
     * Implode an array of objects by a field
     *
     * @param array $Objects
     * @param string $length
     * @param string $glue
     */
    public static function implodeArrayOfObjects(array $Objects, $field, $glue = ', ')
    {
        $rv = array();
        foreach($Objects as $O)
        {
            $rv[] = CHtml::encode($O->{$field});
        }

        return implode($glue, $rv);
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


     /**
      * Converts a UTF-8 string to ASCII
      *
      * @param string $str
      * @param array $replace
      * @param string $delimiter
      */
    public static function toAscii($str, $replace=array(), $delimiter='-')
    {
        // set locale
        setlocale(LC_ALL, 'en_US.UTF8');

        // first replace
        if( !empty($replace) )
        {
            $str = str_replace((array)$replace, ' ', $str);
        }

        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $clean;
    }

    /**
     *
     * Load the current user model
     * @return User|mixed|null
     */
    public static function getUser($user = false) {
        return Identity::model()->findByPk((bool)$user ? $user : Yii::app()->user->id)->User;
    }
}