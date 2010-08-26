<?php
/**
 * 
 * @author munkie
 *
 */
abstract class Munk_Util_DataObject_Abstract
{
    /**
     * keys are params names, please use lower case names
     * values are default values
     * if no default value is needed then null
     * 
     * @var array 
     */
    protected $_data = array();
    
    /**
     * 
     * @var string
     */
    protected $_exceptionClass = 'Munk_Util_DataObject_Exception';
    
    /**
     * 
     * @param string $name
     * @param array  $args
     * 
     * @return mixed
     * @throws Munk_MusicBrainz_Search_Query_Exception
     */
    public function __call($method, $args)
    {
        if (preg_match('/^(get|set|isset|unset)(.*)$/i', $method, $matches)) {
            $operation = strtolower($matches[1]);
            $parameter = strtolower($matches[2]);
        
            switch ($operation) {
                case 'get':
                    return $this->_get($parameter);
                case 'set':
                    if (!isset($args[0])) {
                        throw new Munk_MusicBrainz_Search_Query_Exception("Can't set $parameter - no value was provided");
                    }
                    return $this->_set($parameter, $args[0]);
                case 'isset':
                    return $this->_isset($parameter);
                case 'unset':
                    return $this->_unset($parameter);
            }
        }
        
        $this->_fault("Invalid method $method invocation");
    }
    
    /**
     * 
     */
    protected function _fault($message, $code = null)
    {
        throw new $this->_exceptionClass($message, $code);
    }
    
    /**
     * 
     * @param string $parameter
     * @return mixed
     */
    protected function _get($parameter)
    {
        if (array_key_exists($parameter, $this->_data)) {
            return $this->_data[$parameter];
        }
        
        $this->_fault("Parameter $parameter does not exist");
    }
    
    /**
     * 
     * @param string $parameter
     * @param mixed  $value
     * 
     * @return Munk_Util_DataObject_Abstract
     */
    protected function _set($parameter, $value)
    {
        if (array_key_exists($parameter, $this->_data)) {
            $this->_data[$parameter] = $value;
            return $this;
        }
        
        $this->_fault("Parameter $parameter does not exist");
    }
    
    /**
     * 
     * @param string $parameter
     * 
     * @return boolean
     */
    protected function _isset($parameter)
    {
        if (array_key_exists($parameter, $this->_data)) {
            return isset($this->_data[$parameter]);
        }
        
        $this->_fault("Parameter $parameter does not exist");
    }
    
    /**
     * 
     * @param string $parameter
     * 
     * @return boolean
     */
    protected function _unset($parameter)
    {
        if (array_key_exists($parameter, $this->_data)) {
            return $this->_data[$parameter] = null;
        }
        
        $this->_fault("Parameter $parameter does not exist");
    }
    
    /**
     * 
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        $method = 'get' . $name;
        return $this->$method($name);
    }
    
    /**
     * 
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        return $this->$method($name);
    }
    
    /**
     * 
     * @param string $name
     */
    public function __isset($name)
    {
        $method = 'isset' . $name;
        return $this->$method($name);
    }
    
    /**
     * 
     * @param string $name
     */
    public function __unset($name)
    {
        $method = 'unset' . $name;
        return $this->$method($name);
    }
}