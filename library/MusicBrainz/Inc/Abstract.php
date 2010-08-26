<?php
/**
 * 
 * @author munkie
 *
 */
abstract class Munk_MusicBrainz_Inc_Abstract extends Munk_Util_DataObject_Abstract
{
    /**
     * 
     * @param string $method
     * @param array  $args
     */
    public function __call($method, array $args)
    {
        // force to set true as value 
        if (0 === strpos($method, 'set')) {
            if (isset($args[0]) && false == $args[0]) {
                $args[0] = null;
            } else {
                $args[0] = true;
            }
        }
        parent::__call($method, $args);
    }
    
    /**
     * 
     * @param boolean $filterNullValues
     * @return array
     */
    public function toArray($filterEmptyValues = false)
    {
        $data = parent::toArray();
        if ($filterEmptyValues) {
            $data = array_filter($data);
        }
        return $data;
    }
    
    /**
     * @return string
     */
    public function toString()
    {
        return $this->__toString();
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return implode(' ', $this->toArray(true));
    }
    
    /**
     * 
     * @param array $data
     * @return Munk_MusicBrainz_Inc_Abstract
     */
    public function populate(array $data)
    {
        // convert indexed array to assoc array with true values
        if (!empty($data) && array_values($data) === $data) {
            $values = array_fill(0, count($data) - 1, true);
            $data = array_combine($data, $values);
        }
        return parent::populate($data);
    }
}