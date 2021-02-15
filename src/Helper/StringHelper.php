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
}