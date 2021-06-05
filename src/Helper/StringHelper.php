<?php

namespace Mia\Core\Helper;

/**
 * Description of CsvHelper
 *
 * @author matiascamiletti
 */
class StringHelper 
{
    public static function splitName($fullname)
    {
        $name = trim($fullname);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim( preg_replace('#'.preg_quote($last_name,'#').'#', '', $name ) );
        return array($first_name, $last_name);
    }
    /**
     * Matias Camiletti -> M. Camiletti
     */
    public static function abbreviateFullName($fullname)
    {
        $split = self::splitName($fullname);
        if($split[1] == ''){
            return $split[0];
        }

        return ucfirst($split[0][0]) . '. ' . $split[1];
    }
    /**
     * Example:
     * 
     * Titulo del post -> titulo-del-post
     */
    public static function createSlug($text)
    {
        return strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $text));
    }
}