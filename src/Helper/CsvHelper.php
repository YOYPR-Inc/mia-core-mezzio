<?php

namespace Mia\Core\Helper;

/**
 * Description of CsvHelper
 *
 * @author matiascamiletti
 */
class CsvHelper 
{
    public static function convertToArray($handle, string $delimiter = ",", string $enclosure = '"', string $escape = "\\")
    {
        $items = array();
        $row = 0;
        while (($data = fgetcsv($handle, 0, $delimiter, $enclosure, $escape)) !== FALSE) {
            $num = count($data);
            $item = array();
            for ($c=0; $c < $num; $c++) {
                $item[] = $data[$c];
            }
            $items[] = $item;
            $row++;
        }
        fclose($handle);
        return $items;
    }
}
