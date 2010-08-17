<?php

class Munk_Log_Manager
{
    /**
     * 
     * @var array logs instances
     */
    protected $_logs = array();
    
    /**
     * 
     * @var Munk_Log_Manager
     */
    static protected $_instance;
    
    protected function __construct()
    {
    }
    
    public function __get($name)
    {
        return $this->get($name);
    }
    
    public function __set($name, $value)
    {
        $this->set($name, $value);
    }
    
    public function __isset($name)
    {
        return $this->has($name);
    }
    
    public function __unset($name)
    {
        $this->remove($name);
    }
    
    /**
     * @return Munk_Log_Manager
     */
    static public function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
    
    /**
     * 
     * @param string $name
     * @return Zend_Log
     * 
     * @throws Zend_Log_Exception
     */
    public function get($name)
    {
        if (isset($this->_logs[$name])) {
            return $this->_logs[$name];
        }
        
        throw new Zend_Log_Exception("Log $name is not registered");
    }
    
    /**
     * 
     * @param string $name
     * @return boolean
     */
    public function has($name)
    {
        return isset($this->_logs[$name]);
    }
    
    /**
     * 
     * @param string $name
     * @param array $config
     * 
     * @return Munk_Log_Manager
     */
    public function set($name, array $config)
    {
        $this->_logs[$name] = Zend_Log::factory($config);
        return $this;
    }
    
    public function remove($name)
    {
        if (isset($this->_logs[$name])) {
            unset($this->_logs[$name]);
        }
    }
    
    /**
     * 
     * @param string $name
     * @return Zend_Log
     */
    static public function getStatic($name)
    {
        return self::getInstance()->get($name);
    }
    
    /**
     * 
     * @param string $name
     * @param array $options
     * 
     * @return Munk_Log_Manager
     */
    static public function setStatic($name, array $options)
    {
        return self::getInstance()->set($name, $options);
    }
    
    /**
     * 
     * @param string $name
     * @return boolean
     */
    static public function hasStatic($name)
    {
        return self::getInstance()->has($name);
    }
}