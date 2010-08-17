<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_Cache_Frontend_Class extends Zend_Cache_Frontend_Class
{
    /**
     * 
     * @param object|string   $class
     * @param Zend_Cache_Core $cache
     */
    public function __construct($class, Zend_Cache_Core $cache)
    {
        if (!is_object($class) && !is_string($class)) {
            throw new Zend_Cache_Exception('Invalid class, must be object or string');
        }
        
        $options = array(
            'cached_entity' => $class,
            'backend' => $cache->getBackend(),
        );
        parent::__construct($options);
    }
}