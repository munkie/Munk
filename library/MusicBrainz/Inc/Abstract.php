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
     * @var string
     */
    protected $_exceptionClass = 'Munk_MusicBrainz_Inc_Exception';
    
    /**
     * Inc types that needs authorization
     * 
     * @var array
     */
    protected $_needsAuth = array(
        Munk_MusicBrainz::INC_USER_RATINGS,
        Munk_MusicBrainz::INC_USER_TAGS,
    );
    
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
        return parent::__call($method, $args);
    }
    
    /**
     * 
     * @param string $name
     * 
     * @return Munk_MusicBrainz_Inc_Abstract
     */
    public function set($name)
    {
        $names = (array) $name;
        foreach ($names as $n) {
            $this->__set($name, true);
        }
        return $this;
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
        return implode(' ', array_keys($this->toArray(true)));
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
    
    /**
     * 
     * @param array $data
     * @return Munk_MusicBrainz_Inc_Abstract
     */
    public function populate(array $data)
    {
        foreach ($data as $key => $value) {
            if (is_int($key)) {
                $data[$value] = true;
                unset($data[$key]);
            }
        }
        return parent::populate($data);
    }
    
    
    /**
     * 
     * @param string $key
     * @return boolean
     */
    protected function _needsAuth($key)
    {
        return in_array($key, $this->_needsAuth);
    }
    
    /**
     * 
     * @param boolean $flag
     */
    public function setAll($flag = true, $excludeAuth = true)
    {
        $flag = (boolean) $flag;
        foreach ($this->_data as $key => $value) {
            if (true === $flag && $excludeAuth && $this->_needsAuth($key)) {
                continue;
            }
            $this->__set($key, $flag);
        }
    }
    
    /**
     *  
     */
    public function unsetAll()
    {
        $this->setAll(false);
    }
    
    /**
     * 
     * @param string $type
     * @param array $data
     * 
     * @return Munk_MusicBrainz_Inc_Abstract
     * 
     * @throws Munk_MusicBrainz_Inc_Exception
     */
    static public function factory($type, array $data = null)
    {
        $class = 'Munk_MusicBrainz_Inc_' . $type;
        if (!class_exists($class)) {
            throw new Munk_MusicBrainz_Inc_Exception("Invalid inc type provided: $type. Class $class does not exist");
        }

        return new $class($data);
    }
}