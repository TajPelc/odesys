<?php
/**
 * The Ajax helper
 *
 * @author Taj
 *
 */
class Ajax
{
    /**
     * Is this an ajax request?
     *
     * return boolean
     */
    public static function isAjax()
    {
        return Yii::app()->request->isAjaxRequest;
    }

    /**
     * Return a valid response
     *
     * @param array $var
     */
    public static function respondOk($var = array())
    {
        $var['status'] = true;
        self::returnJSON($var);
    }

    /**
     * Return errors
     *
     * @param array $var
     */
    public static function respondError($var = array())
    {
        $var['status'] = false;
        $var['errors'] = $var;
        self::returnJSON($var);
    }

    /**
     * Return JSON and end execution
     *
     * @param array $var
     */
    public static function returnJSON(array $var)
    {
        header('Content-type: application/json');
        echo CJSON::encode($var);
        Yii::app()->end();
    }
}