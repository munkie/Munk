<?php
/**
 * 
 * @author munkie
 *
 */
abstract class Munk_MusicBrainz_Result implements Munk_MusicBrainz_Result_Interface
{
    /**
     * 
     * @var array
     */
    protected $_data = array();
    
    /**
     * 
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        $this->populate($data, false);
    }
    
    /**
     * 
     * @param array   $data
     * @param boolean $strictKeys
     */
    public function populate(array $data = array(), $strictKeys = true)
    {
        foreach ($data as $key => $value) {
            if ($strictKeys || $this->__isset($key)) {
                $this->__set($key, $value);
            }
        }
    }
    
    /**
     * 
     * @param string $method
     * @param array  $params
     * 
     * @return mixed
     * @throws Munk_MusicBrainz_Exception
     */
    public function __call($method, $params)
    {
        // get
        if (false !== ($name = $this->_stripName($method, 'get'))) {
            if (!array_key_exists($name, $this->_data)) {
                throw new Munk_MusicBrainz_Exception("Trying to get invalid property $name");
            }
            return $this->_data[$name];
        // set
        } else if (false !== ($name = $this->_stripName($method, 'set'))) {
            if (!array_key_exists($name, $this->_data)) {
                throw new Munk_MusicBrainz_Exception("Trying to set invalid property $name");
            }
            if (!array_key_exists(0, $params)) {
                throw new Munk_MusicBrainz_Exception("No value was passed to property $name");
            }
            $this->_data[$name] = $params[0];
            return $this;
        // isset           
        } else if (false !== ($name = $this->_stripName($method, 'isset'))) {
            return array_key_exists($name, $this->_data);
        // unset
        } else if (false !== ($name = $this->_stripName($method, 'unset'))) {
            if (!array_key_exists($name, $this->_data)) {
                throw new Munk_MusicBrainz_Exception("Trying to unset invalid property $name");
            }
            $this->_data[$name] = null;
            return $this;
        }
    }
    
    /**
     * 
     * @param string $method
     * @param string $type
     * 
     * @return string|false
     */
    protected function _stripName($method, $type)
    {
        if (0 === strpos($method, $type)) {
            $name = strtolower(substr($method, strlen($type)));
            return $name;
        } else {
            return false;
        }
    }
    
    /**
     * 
     * @param string $name
     */
    public function __get($name)
    {
        return $this->{'get' . $name}();
    }
    
    /**
     * 
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        return $this->{'set' . $name}($value);
    }
    
    /**
     * 
     * @param string $name
     * 
     * @return boolean
     */
    public function __isset($name)
    {
        return $this->{'isset' . $name}();
    }
    
    /**
     * 
     * @param string $name
     */
    public function __unset($name)
    {
        return $this->{'unset' . $name}();
    }
}