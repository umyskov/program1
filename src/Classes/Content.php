<?php

namespace Program1\Classes;

/**
 * Class Content
 * @package Program1\Classes
 */
class Content
{
    /**
     * @return bool|string
     */
    public static function get($filename)
    {

        try {
            if (!file_exists($filename)) {
                throw new \Exception('Файл с данными не найден!');
            }
        } catch (\Exception $e) {
            echo $e->getMessage() . '<br />';
            return false;
        }

        return file_get_contents($filename);
    }
}


