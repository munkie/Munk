<?php
/**
 * 
 * @author munkie
 *
 */
class Munk_Application_Resource_Vk extends Zend_Application_Resource_ResourceAbstract
{
    /*
     * 
     */
    const DEFAULT_REGISTRY_KEY = 'Munk_Service_Vk';
    
    /**
     * 
     * @var Munk_Service_Vk
     */
    protected $_vkService;
    
	/**
     * @return Munk_Service_Vk
     */
    public function init()
    {
        return $this->getVkService();
    }

    /**
     * @return Munk_Service_Vk
     */
    public function getVkService()
    {
        if (null === $this->_vkService) {
            $options = $this->getOptions();

            $this->_vkService = new Munk_Service_Vk($options);
            
            $key = (isset($options['registry_key']) && !is_numeric($options['registry_key']))
                ? $options['registry_key']
                : self::DEFAULT_REGISTRY_KEY;
            Zend_Registry::set($key, $this->_vkService);
        }
        return $this->_vkService;
    }
    
}