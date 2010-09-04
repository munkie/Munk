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
     * @param array $data
     */
    public function __construct(array $data = null)
    {
        $this->init();
        
        if (null !== $data) {
            $this->populate($data);
        }
    }
    
    /**
     * 
     */
    public function init()
    {
    }

    /**
     * 
     * @param string $method
     * @param array  $args
     * 
     * @return mixed
     * @throws Munk_MusicBrainz_Search_Query_Exception
     */
    public function __call($method, $args)
    {
        if (preg_match('/^(get|set|isset|unset)(.+)$/i', $method, $matches)) {
            $operation = strtolower($matches[1]);
            $parameter = strtolower($matches[2]);

            switch ($operation) {
                case 'get':
                    return $this->_get($parameter);
                case 'set':
                    if (!array_key_exists(0, $args)) {
                        return $this->_fault("Can't set $parameter - no value was provided");
                    }
                    return $this->_set($parameter, $args[0]);
                case 'isset':
                    return $this->_isset($parameter);
                case 'unset':
                    return $this->_unset($parameter);
            }
        }

        return $this->_fault("Invalid method $method invocation");
    }

    /**
     * 
     * @param string $parameter
     * @return mixed
     */
    public function __get($parameter)
    {
        $method = 'get' . $parameter;
        return $this->$method();
    }

    /**
     * 
     * @param $parameter
     * @param $value
     */
    public function __set($parameter, $value)
    {
        $method = 'set' . $parameter;
        return $this->$method($value);
    }

    /**
     * 
     * @param string $parameter
     */
    public function __isset($parameter)
    {
        $method = 'isset' . $parameter;
        return $this->$method($parameter);
    }

    /**
     * 
     * @param string $parameter
     */
    public function __unset($parameter)
    {
        $method = 'unset' . $parameter;
        return $this->$method($parameter);
    }

    /**
     * @throws Munk_Util_DataObject_Exception
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

        return $this->_fault("Parameter $parameter does not exist");
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

        return $this->_fault("Parameter $parameter does not exist");
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

        // if param is impemented using set|get method then get value and check if it is null
        $method = 'get' . $parameter;
        if (method_exists($this, $method)) {
            $value = $this->$method($parameter);
            return (null === $value);
        }

        return $this->_fault("Parameter $parameter does not exist");
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

        // if param is impemented using set|get method then set null value
        $method = 'set' . $parameter;
        if (method_exists($this, $method)) {
            return $this->$method(null);
        }

        return $this->_fault("Parameter $parameter does not exist");
    }

    /**
     * 
     * @param  array $data
     * @return Munk_Util_DataObject_Abstract
     */
    public function populate(array $data)
    {
        foreach ($data as $key => $value) {
            $this->__set($key, $value);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = array();
        foreach ($this->_data as $key => $value) {
            $data[$key] = $this->__get($key);
        }
        return $data;
    }
}