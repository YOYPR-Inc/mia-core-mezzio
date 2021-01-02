<?php namespace Mia\Core\Helper;

/**
 * Description of CollectionHelper
 *
 * @author matiascamiletti
 */
class MergeHelper
{
    const ORDER_TYPE_ASC = 0;
    const ORDER_TYPE_DESC = 1;
    
    const TYPE_INT = 0;
    const TYPE_STRING = 1;
    const TYPE_DATE = 2;
    /**
     * Key del array a tener en cuenta para hacer la unión
     * @var string
     */
    protected $keyValue = '';
    /**
     *
     * @var int
     */
    protected $typeKey = 0;
    /**
     *
     * @var int
     */
    protected $orderType = 0;
    /**
     * 
     * @param string $key
     * @param string $typeKey
     * @param int $orderType
     */
    public function __construct($key, $typeKey = self::TYPE_INT, $orderType = self::ORDER_TYPE_ASC)
    {
        $this->keyValue = $key;
        $this->typeKey = $typeKey;
        $this->orderType = $orderType;
    }
    /**
     * Unifica los arrays
     * @param array $array1
     * @param array $array2
     * @return array
     */
    public function merge(array $array1, array $array2): array
    {
        // Hacemos merge de los datos
        $merge = array_replace_recursive(
            $this->convert($array1),
            $this->convert($array2)
        );
        // obtenemo un Array identico a los que se enviaron
        $newArr = $this->convertWithoutKey($merge);
        // Aplicamos el orden
        usort($newArr, function($a, $b) {
            if($this->typeKey == self::TYPE_INT && $this->orderType == self::ORDER_TYPE_ASC){
                return $a[$this->keyValue] - $b[$this->keyValue];
            }elseif($this->typeKey == self::TYPE_INT && $this->orderType == self::ORDER_TYPE_DESC){
                return $b[$this->keyValue] - $a[$this->keyValue];
            }elseif($this->typeKey == self::TYPE_DATE && $this->orderType == self::ORDER_TYPE_ASC){
                return intval(str_replace('-', '', $a[$this->keyValue])) - intval(str_replace('-', '', $b[$this->keyValue]));
            }elseif($this->typeKey == self::TYPE_DATE && $this->orderType == self::ORDER_TYPE_DESC){
                return intval(str_replace('-', '', $b[$this->keyValue])) - intval(str_replace('-', '', $a[$this->keyValue]));
            }
        });
        return $newArr;
    }
    /**
     * Convierte el array con Key en uno sin Key
     * @param array $array
     * @return array
     */
    protected function convertWithoutKey(array $array): array
    {
        $newArr = [];
        foreach($array as $key => $value){
            $newArr[] = $value;
        }
        return $newArr;
    }
    /**
     * Convierte el array con la Key como elemento indicativo
     * @param array $array
     * @return array
     */
    protected function convert(array $array): array
    {
        foreach($array as $index => $value)
        {
            $array[$value[$this->keyValue]] = $value;
            unset($array[$index]);
        }
        return $array;
    }
}
